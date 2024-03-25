<?php

namespace App\Imports;

use App\Models\Lokasi;
use Maatwebsite\Excel\Facades\Excel;

class LokasiImport
{
    public function import($filePath)
    {
        $data = Excel::toArray([], $filePath)[0];

        $columnNames = $data[0];
        $namaColumnIndex = array_search('Nama', $columnNames);

        $importedCount = 0;
        $skippedRows = [];

        foreach ($data as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $emptyColumns = [];

            if ($row[$namaColumnIndex] === null) {
                $emptyColumns[] = 'Nama';
            }

            if (!empty($emptyColumns)) {
                $skippedRows[] = [
                    'row' => $key + 1,
                    'empty_columns' => $emptyColumns
                ];
                continue;
            }

            $lokasi = Lokasi::where('nama', $row[$namaColumnIndex])->first();

            if ($lokasi === null) {
                Lokasi::create([
                    'nama' => $row[$namaColumnIndex]
                ]);
            } else {
                continue;
            }

            $importedCount++;
        }
        return [
            'imported_count' => $importedCount,
            'skipped_rows' => $skippedRows
        ];
    }
}
