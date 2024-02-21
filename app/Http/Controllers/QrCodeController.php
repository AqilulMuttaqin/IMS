<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use TCPDF;
use ZipArchive;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $qrCodeContent = $request->input('qrCodeContent');

        $qrCode = QrCode::format('png')->size(256)->generate($qrCodeContent);

        $base64Image = base64_encode($qrCode);

        return response()->json($base64Image);
    }

    public function download(Request $request)
    {
        $qrCodeContent = $request->input('qrCodeContent');
        $qrCode = QrCode::format('png')->size(256)->generate($qrCodeContent);
        $base64Image = base64_encode($qrCode);
        $file = base64_decode($base64Image);
        return response($file, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qr-code.png"'
        ]);
    }

    public function downloadBatch()
    {
        $barangs = Barang::all();
        
        $tempDir = sys_get_temp_dir() . '/' . uniqid('qrcodes_');
        mkdir($tempDir);

        $qrCodePaths = [];
        foreach ($barangs as $barang) {
            $qrCodePath = $tempDir . '/' . $barang->nama . '.png';
            QrCode::size(515)
                ->format('png')
                ->margin(1)
                ->generate($barang->no_js, $qrCodePath);
            $qrCodePaths[] = $qrCodePath;
        }

        $zipFile = $tempDir . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($qrCodePaths as $path) {
            $zip->addFile($path, basename($path));
        }

        $zip->close();

        return response()->download($zipFile, 'qr-codes.zip')->deleteFileAfterSend(true);
    }


    public function generatePdfWithQrCodes()
    {
        $dompdf = new Dompdf();
        
        $html = '<html><body>';

        $barangs = Barang::all();

        for ($i = 0; $i < count($barangs); $i++) {
            if ($i % 20 === 0) {
                if ($i !== 0) {
                    $html .= '</div><div style="page-break-after: always;"></div>';
                }
                $html .= '<div style="display: flex; flex-wrap: wrap;">';
            }

            $barang = $barangs[$i];
            $html .= "<div style='width: 20%; padding: 10px;'>";
            $qrCodeData = QrCode::size(150)
                ->format('png')
                ->generate($barang->no_js);

            $qrCodeBase64 = base64_encode($qrCodeData);

            $html .= "<img src='data:image/png;base64,{$qrCodeBase64}' style='width: 100%; height: auto;' />";
            
            $html .= "<p style='text-align: center;'>{$barang->nama}</p>";

            $html .= '</div>';
        }

        $html .= '</div></body></html>';

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return $dompdf->stream('qrcodes.pdf');
    }
}
