<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use TCPDF;
use ZipArchive;

class QrCodeController extends Controller
{
    // public function generate(Request $request)
    // {
    //     $qrCodeContent = $request->input('qrCodeContent');

    //     $qrCode = QrCode::format('png')->size(256)->generate($qrCodeContent);

    //     $base64Image = base64_encode($qrCode);

    //     return response()->json($base64Image);
    // }

    // public function download(Request $request)
    // {
    //     $qrCodeContent = $request->input('qrCodeContent');
    //     $qrCode = QrCode::format('png')->size(256)->generate($qrCodeContent);
    //     $base64Image = base64_encode($qrCode);
    //     $file = base64_decode($base64Image);
    //     return response($file, 200, [
    //         'Content-Type' => 'image/png',
    //         'Content-Disposition' => 'attachment; filename="qr-code.png"'
    //     ]);
    // }
    public function generate(Request $request)
    {
        $qrCodeContent = $request->input('qrCodeContent');
        $qrCodeName = $request->input('nama');
        $qrCodeContentWithLineBreak = $qrCodeContent . "\n";

        $qrCodesDirectory = storage_path('app/qr_codes');
        if (!file_exists($qrCodesDirectory)) {
            mkdir($qrCodesDirectory, 0755, true);
        }

        $qrCodeFileName = $qrCodeContent.'-'.$qrCodeName . '.svg';
        $qrCodeFilePath = $qrCodesDirectory . '/' . $qrCodeFileName;

        if (!file_exists($qrCodeFilePath)) {
            $qrCode = QrCode::format('svg')->size(280)->margin(1)->generate($qrCodeContentWithLineBreak);
            file_put_contents($qrCodeFilePath, $qrCode);
        }

        $base64Image = file_get_contents($qrCodeFilePath);

        return response()->json($base64Image);
    }

    public function download(Request $request)
    {
        $qrCodeContent = $request->input('qrCodeContent');
        $qrCodeName = $request->input('nama');
        $qrCodeContentWithLineBreak = $qrCodeContent . "\n";

        $qrCodesDirectory = storage_path('app/qr_codes');
        if (!file_exists($qrCodesDirectory)) {
            mkdir($qrCodesDirectory, 0755, true);
        }

        $qrCodeFileName = $qrCodeContent.'-'.$qrCodeName . '.svg';
        $qrCodeFilePath = $qrCodesDirectory . '/' . $qrCodeFileName;

        if (!file_exists($qrCodeFilePath)) {
            $qrCode = QrCode::format('svg')->size(280)->margin(1)->generate($qrCodeContentWithLineBreak);
            file_put_contents($qrCodeFilePath, $qrCode);
        }

        $file = file_get_contents($qrCodeFilePath);

        return response($file, 200, [
            'Content-Type' => 'image/svg',
            'Content-Disposition' => 'attachment; filename="qr-code.svg"'
        ]);
    }

    // public function downloadBatch()
    // {
    //     $barangs = Barang::all();
        
    //     $tempDir = sys_get_temp_dir() . '/' . uniqid('qrcodes_');
    //     mkdir($tempDir);

    //     $qrCodePaths = [];
    //     foreach ($barangs as $barang) {
    //         $qrCodePath = $tempDir . '/' . $barang->kode_js.'-'. $barang->nama . '.png';
    //         QrCode::size(515)
    //             ->format('png')
    //             ->margin(1)
    //             ->generate($barang->kode_js, $qrCodePath);
    //         $qrCodePaths[] = $qrCodePath;
    //     }

    //     $zipFile = $tempDir . '.zip';
    //     $zip = new ZipArchive();
    //     $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    //     foreach ($qrCodePaths as $path) {
    //         $zip->addFile($path, basename($path));
    //     }

    //     $zip->close();

    //     return response()->download($zipFile, 'qr-codes.zip')->deleteFileAfterSend(true);
    // }

    public function downloadBatch()
    {
        $barangs = Barang::all();
        
        $tempDir = storage_path('app/qr_codes');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $qrCodePaths = [];
        $generatedFiles = [];
        foreach ($barangs as $barang) {
            $qrCodePath = $tempDir . '/' . $barang->kode_js.'-'. $barang->nama . '.svg';
            
            if (!file_exists($qrCodePath)) {
                QrCode::size(515)
                    ->format('svg')
                    ->margin(1)
                    ->generate($barang->kode_js. "\n", $qrCodePath);
            }
            
            $generatedFiles[] = $barang->kode_js.'-'. $barang->nama . '.svg';
            $qrCodePaths[] = $qrCodePath;
        }

        $zipFile = $tempDir . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($qrCodePaths as $path) {
            $zip->addFile($path, basename($path));
        }

        $zip->close();

        $this->deleteUnusedQrCodes($tempDir, $generatedFiles);

        return response()->download($zipFile, 'qr-codes.zip')->deleteFileAfterSend(true);
    }

    // public function generatePdfWithQrCodes()
    // {
    //     $dompdf = new Dompdf();
        
    //     $html = '<html><body>';

    //     $barangs = Barang::all();

    //     // Define CSS styles for the container and individual QR code items
    //     $html .= '<style>
    //                 .qr-code-row {
    //                     clear: both;
    //                     width: 100%;
    //                 }
    //                 .qr-code-item {
    //                     float: left;
    //                     width: 22%;
    //                     padding: 10px;
    //                 }
    //             </style>';

    //     // Loop through barangs to generate QR codes and details
    //     foreach ($barangs as $key => $barang) {
    //         // Start a new row for every 4 items (adjust as needed)
    //         if ($key % 4 === 0) {
    //             if ($key !== 0) {
    //                 $html .= '</div>';
    //             }
    //             $html .= '<div class="qr-code-row">';
    //         }

    //         // Generate QR code and encode to base64
    //         $qrCodeData = QrCode::size(150)
    //             ->format('png')
    //             ->generate($barang->kode_js);
    //         $qrCodeBase64 = base64_encode($qrCodeData);

    //         // Add QR code and details to HTML
    //         $html .= "<div class='qr-code-item'>";
    //         $html .= "<img src='data:image/png;base64,{$qrCodeBase64}' style='width: 100%; height: auto;' />";
    //         $html .= "<p style='text-align: center;'>{$barang->nama}</p>";
    //         $html .= '</div>';
    //     }

    //     // Close the last row
    //     $html .= '</div>';

    //     $html .= '</body></html>';

    //     $dompdf->loadHtml($html);

    //     $dompdf->setPaper('A4', 'portrait');

    //     $dompdf->render();

    //     return $dompdf->stream('qrcodes.pdf');
    // }

    public function generatePdfWithQrCodes()
    {
        $dompdf = new Dompdf();
        
        $html = '<html><body>';

        $qrCodesDirectory = storage_path('app/qr_codes');
        if (!file_exists($qrCodesDirectory)) {
            mkdir($qrCodesDirectory, 0755, true);
        }

        $html .= '<style>
                    .qr-code-row {
                        clear: both;
                        width: 100%;
                    }
                    .qr-code-item {
                        float: left;
                        width: 22%;
                        padding: 10px;
                    }
                </style>';

        $barangs = Barang::all();

        $generatedFiles = [];

        foreach ($barangs as $key => $barang) {
            if ($key % 4 === 0) {
                if ($key !== 0) {
                    $html .= '</div>';
                }
                $html .= '<div class="qr-code-row">';
            }

            $qrCodeFileName = $barang->kode_js.'-'. $barang->nama . '.svg';
            $qrCodeFilePath = $qrCodesDirectory . '/' . $qrCodeFileName;

            if (!file_exists($qrCodeFilePath)) {
                QrCode::size(280)
                    ->format('svg')
                    ->generate($barang->kode_js. "\n", $qrCodeFilePath);
            }

            $generatedFiles[] = $qrCodeFileName;

            $imageData = base64_encode(file_get_contents($qrCodeFilePath));
            $src = 'data:image/svg;base64,' . $imageData;

            $html .= "<div class='qr-code-item'>";
            $html .= "<img src='$src' style='width: 100%; height: auto;' />";
            $html .= "<p style='text-align: center;'>{$barang->nama}</p>";
            $html .= '</div>';
        }

        // Close the last row
        $html .= '</div>';

        $html .= '</body></html>';

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $pdfContent = $dompdf->output();
    
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="qrcodes.pdf"',
        ];

        $this->deleteUnusedQrCodes($qrCodesDirectory, $generatedFiles);

        return Response::make($pdfContent, 200, $headers);
    }

    public function deleteUnusedQrCodes($directory, $generatedFiles)
    {
        if (file_exists($directory) && is_dir($directory)) {
            $files = glob($directory . '/*');
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    $filename = basename($file);
                    if (!in_array($filename, $generatedFiles)) {
                        unlink($file);
                    }
                }
            }
        }
    }
}
