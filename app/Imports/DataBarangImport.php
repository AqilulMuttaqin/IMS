<?php

namespace App\Imports;

use App\Models\DataBarang;
use App\Models\Lokasi;
use Maatwebsite\Excel\Facades\Excel;

class DataBarangImport
{
    public function import($filePath)
    {
        $data = Excel::toArray([], $filePath)[0];

        $columnNames = $data[0];
        $kodejsColumnIndex = array_search('Kode JS', $columnNames);
        $inv_numColumnIndex = array_search('Invoice Number', $columnNames);
        $po_numberColumnIndex = array_search('PO Number', $columnNames);
        $qtyColumnIndex = array_search('Qty', $columnNames);
        $lokasiColumnIndex = array_search('Lokasi', $columnNames);
        
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
            if ($row[$inv_numColumnIndex] === null) {
                $emptyColumns[] = 'Invoice Number';
            }
            if ($row[$po_numberColumnIndex] === null) {
                $emptyColumns[] = 'PO Number';
            }
            if ($row[$qtyColumnIndex] === null) {
                $emptyColumns[] = 'Qty';
            }
            if ($row[$lokasiColumnIndex] === null) {
                $emptyColumns[] = 'Lokasi';
            }

            if (!empty($emptyColumns)) {
                $skippedRows[] = [
                    'row' => $key + 1,
                    'empty_columns' => $emptyColumns
                ];
                continue;
            }

            $barang = DataBarang::where('kode_js', $row[$kodejsColumnIndex])
                ->where('inv_number', $row[$inv_numColumnIndex])
                ->where('PO_number', $row[$po_numberColumnIndex])
                ->first();

            if ($barang) {
                $lokasiId = Lokasi::where('nama', $row[$lokasiColumnIndex])->value('id');

                if ($barang->lokasi()->where('lokasi_id', $lokasiId)->exists()) {
                    $barang->lokasi()->updateExistingPivot($lokasiId, ['qty' => $row[$qtyColumnIndex]]);
                } else {
                    $barang->lokasi()->attach($lokasiId, ['qty' => $row[$qtyColumnIndex]]);
                }
            } else {
                $barang = DataBarang::create([
                    'kode_js' => $row[$kodejsColumnIndex],
                    'inv_number' => $row[$inv_numColumnIndex],
                    'PO_number' => $row[$po_numberColumnIndex],
                ]);

                $lokasiId = Lokasi::where('nama', $row[$lokasiColumnIndex])->value('id');
                $barang->lokasi()->attach($lokasiId, ['qty' => $row[$qtyColumnIndex]]);
            }

            $importedCount++;
        }
        return [
            'imported_count' => $importedCount,
            'skipped_rows' => $skippedRows
        ];
    }
}
