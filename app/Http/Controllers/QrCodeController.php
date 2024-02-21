<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
}
