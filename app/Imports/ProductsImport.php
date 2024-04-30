<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;


class ProductsImport implements ToModel, WithStartRow, WithChunkReading,   WithCustomCsvSettings,WithHeadingRow,SkipsEmptyRows,withValidation

{
    use Importable;
    private $validationErrors = [];
    public function headingRow(): int
    {
        return 1; // Change this to the row number where your headers are located
    }
    public function model(array $row)
    {
        return new Product([
            'sku' => $row['sku'],
            'title' => $row['title'],
            'ean' => $row['ean'],
            'uk_only' => $row['uk_only'],
            
        ]);
    }
    public function startRow(): int
    {
        return 2; // Skip the first row (header row)
    }

    // WithChunkReading implementation
    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }

    // WithValidation implementation
    public function rules(): array
    {
        return [
            'sku' => 'required|integer|unique:products,sku',
            'title' => 'required|string',
            'ean' => 'nullable',
            'uk_only' => 'required',
        ];
        
    } 
    public function customValidationMessages()
    {
        return [
            'sku.required' => 'SKU is required.',
            'sku.integer' => 'SKU must be an integer.',
            'sku.unique' => 'SKU is already taken.',
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a string.',
            'ean.string' => 'EAN must be a string.',
            'ean.max' => 'EAN cannot be longer than :max characters.',
            'uk_only.required' => 'UK-Only field is required.',
        ];
    }
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
            'validation_messages' => $this->customValidationMessages(),
        ];
    }
    public function onError(\Throwable $e)
    {
        if ($e instanceof \Maatwebsite\Excel\Validators\ValidationException) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $rowIndex = $failure->row();
                $columnName = $failure->attribute();
                $errorMessage = $failure->errors()[0];
                $this->validationErrors[] = "Row $rowIndex: $columnName - $errorMessage";
            }
        } else {
            \Log::error('An error occurred during import: ' . $e->getMessage());
        }
    }

  
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
    
}