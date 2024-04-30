<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
class ExcelController extends Controller
{
    public function importProducts(Request $request)
    {
       
       try {
            if ($request->hasFile('file_input')) {
                $filePaths = [];
                $file=$request->file('file_input');
                $filePath = $file->store('file_input', 'public');
               
                
            }
            $storage_path =storage_path('app/public/'.$filePath);
            if (!file_exists($storage_path )) {
                $this->error('File not found: ' . $storage_path );
                return 'file not found';
            }
            $import =new ProductsImport();
            $import->import($storage_path);
            $validationErrors = $import->getValidationErrors();
            session()->flash('success', 'Excel Imported Successfully');
            return redirect()->route('products');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
        
            foreach ($failures as $failure) {
                $rowIndex = $failure->row();
                $columnName = $failure->attribute();
                $errorMessage = $failure->errors()[0];
                $inputData = $failure->values();
                // $errors[] = "Row $rowIndex: $columnName - $errorMessage (Input data:  json_encode($inputData))";
                $errors[] = "Row $rowIndex: $columnName - $errorMessage";
        
            }
        
            // Flash error message to session
            session()->flash('failed', 'Validation errors during import: ' . implode(', ', $errors));
        
            // Redirect back to the products view with error message
            return redirect()->route('products');
        }
        
        catch (\Exception $e) {
            // Flash error message to session
            session()->flash('failed', 'Validation errors during import: ' . $e->getMessage());
    
            // Redirect back to the products view with error message
            return redirect()->route('products');
        }
    }
}
