<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Facades\Excel;

class BarangImport
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function import($filePath)
    {
        $data = Excel::toArray([], $filePath)[0];

        $columnNames = $data[0];
        $kodejsColumnIndex = array_search('Kode JS', $columnNames);
        $namaColumnIndex = array_search('Nama Barang', $columnNames);
        $minWireColumnIndex = array_search('min_stok', $columnNames);
        $maxColumnIndex = array_search('max_stok', $columnNames);
        $hargaColumnIndex = array_search('Price($)', $columnNames);

        $importedCount = 0;
        $skippedRows = [];

        foreach ($data as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $emptyColumns = [];

            if ($row[$kodejsColumnIndex] === null) {
                $emptyColumns[] = 'Kode JS';
            }
            if ($row[$namaColumnIndex] === null) {
                $emptyColumns[] = 'Nama Barang';
            }
            if ($row[$minWireColumnIndex] === null) {
                $emptyColumns[] = 'min_stok';
            }
            if ($row[$maxColumnIndex] === null) {
                $emptyColumns[] = 'max_stok';
            }
            if ($row[$hargaColumnIndex] === null) {
                $emptyColumns[] = 'Price($)';
            }

            if (!empty($emptyColumns)) {
                $skippedRows[] = [
                    'row' => $key + 1,
                    'empty_columns' => $emptyColumns
                ];
                continue;
            }

            Barang::updateOrCreate(
                ['kode_js' => $row[$kodejsColumnIndex]],
                [
                    'nama' => $row[$namaColumnIndex],
                    'min_stok' => $row[$minWireColumnIndex],
                    'max_stok' => $row[$maxColumnIndex],
                    'harga' => $row[$hargaColumnIndex],
                ]
            );
            $importedCount++;
        }
        return [
            'imported_count' => $importedCount,
            'skipped_rows' => $skippedRows
        ];
    }
}