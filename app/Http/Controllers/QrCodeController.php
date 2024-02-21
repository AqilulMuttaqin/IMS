<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use TCPDF;
use ZipArchive;

class QrCodeController extends Controller
{
    public function show()
    {
        $data = QrCode::size(512)
            ->format('png')
            ->margin(1)
            ->generate(
                'nyobakkk',
            );

        return response($data)
            ->header('Content-type', 'image/png');
    }

    public function download()
    {
        return response()->streamDownload(
            function () {
                echo QrCode::size(515)
                    ->format('png')
                    ->margin(1)
                    ->generate('nyobak');
            },
            'qr-code.png',
            [
                'Content-Type' => 'image/png',
            ]
        );
    }

    public function downloadBatch()
    {
        $tempDir = sys_get_temp_dir() . '/' . uniqid('qrcodes_');
        mkdir($tempDir);

        $qrCodeCount = 10;
        $qrCodePaths = [];
        for ($i = 1; $i <= $qrCodeCount; $i++) {
            $qrCodePath = $tempDir . "/qr-code_$i.png";
            QrCode::size(515)
                ->format('png')
                ->margin(1)
                ->generate("nyobak_$i", $qrCodePath);
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

        for ($i = 1; $i <= 35; $i++) {
            if (($i - 1) % 20 === 0) {
                if ($i !== 1) {
                    $html .= '</div><div style="page-break-after: always;"></div>';
                }
                $html .= '<div style="display: flex; flex-wrap: wrap;">';
            }

            $html .= "<div style='width: 20%; padding: 10px;'>";
            $qrCodeData = QrCode::size(150)
                ->format('png')
                ->generate("QR Code $i");

            $qrCodeBase64 = base64_encode($qrCodeData);

            $html .= "<img src='data:image/png;base64,{$qrCodeBase64}' style='width: 100%; height: auto;' />";
            
            $html .= "<p style='text-align: center;'>Name $i</p>";

            $html .= '</div>';
        }

        $html .= '</div></body></html>';

        // Load HTML content into DomPDF
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (Optional: You can save the PDF to a file by providing a file path instead of outputting it)
        $dompdf->render();

        // Output PDF
        return $dompdf->stream('qrcodes.pdf');
    }
}
