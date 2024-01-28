<?php

namespace App\Services;

use App\Models\OutgingProduct;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelReader
{
    public function readProductsFromXslx(){
        $baseDirectory = storage_path('app/products');

        $todayDate = now()->format('Y-m-d');
        $folderPath = $baseDirectory . '/' . $todayDate;

        if (File::isDirectory($folderPath)){
            $this->fetchFiles($folderPath);
        } else {
            echo "Folder for today's date not found.";
        }
    }

    private function fetchFiles($folderPath){
        $files = File::files($folderPath);

        $xlsxFiles = array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) == 'xlsx';
        });

        foreach ($xlsxFiles as $xlsxFile){
            $this->readSingleFile($xlsxFile);
        }
    }

    private function readSingleFile($filePath){
        $spreadsheet = IOFactory::load($filePath);

        $sheet = $spreadsheet->getActiveSheet();

        $outgoing_products = [];
        $user_id = basename($filePath->getFilename(), '.' . $filePath->getExtension());

        foreach ($sheet->getRowIterator() as $row){
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            $quantity = 0;
            $barcode = "";
            foreach ($cellIterator as $key => $cell){

                if (!empty($cell->getValue())){
                    if ($key == 'A'){
                        $quantity = $cell->getValue();
                    } elseif ($key == 'B'){
                        $barcode = $cell->getValue();
                    }
                }
            }

            if (!empty($barcode) && is_numeric($quantity)){
                $product = Product::where(['user_id' => $user_id, 'barcode' => $barcode])->first();
                if (!empty($product)){

                    if ($product->quantity != $quantity){
                        $product->quantity = $quantity;
                        $product->save();
                    }
                } else {
                    $outgoing_products[] = [
                        'quantity' => $quantity,
                        'user_id' => $user_id,
                        'barcode' => $barcode
                    ];
                }
            }
        }

        if(!empty($outgoing_products)){
            OutgingProduct::insert($outgoing_products);
        }
    }

    private function getColumnParam($index)
    {
        return [
            'A' => 'quantity',
            'B' => 'barcode'
        ];
    }
}
