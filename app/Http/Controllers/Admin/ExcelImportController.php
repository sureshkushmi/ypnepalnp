<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ListingsImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    /**
     * Show Excel import page.
     */
    public function create()
    {
        return Inertia::render('Admin/ExcelImport');
    }

    /**
     * Import Excel file.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:10240',
            ],
        ]);

        $import = new ListingsImport();

        try {

            Excel::import(
                $import,
                $request->file('file')
            );

        } catch (\Throwable $e) {

            return back()->withErrors([
                'file' => 'Unable to import Excel file: ' . $e->getMessage(),
            ]);
        }

        return back()->with([
            'import_result' => [
                'total' => $import->totalRows,
                'imported' => $import->importedRows,
                'duplicates' => $import->duplicateRows,
                'invalid' => $import->invalidRows,
                'errors' => $import->errors,
                'duplicate_rows' => $import->duplicates,
            ],
        ]);
    }
}