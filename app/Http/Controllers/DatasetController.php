<?php

namespace App\Http\Controllers;

use App\Imports\DatasetsImport;
use App\Models\Dataset;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DatasetController extends Controller
{
    public function index()
    {
        $datasets = Dataset::all();
        return view('pages.datasets.index', compact('datasets'));
    }

    public function show($id)
    {
        $dataset = Dataset::find($id);
        return view('pages.datasets.show', compact('dataset'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();
        $path = $file->storeAs('public/dataset/', $file_name);
        $fileName = 'storage/' . str_replace('public/', '', $path);

        $dataset =   Dataset::create([
            'file_name' => $fileName,
            'user_id' => auth()->id()
        ]);

        Excel::import(new DatasetsImport($dataset->id), $file);

        return redirect()->back();
    }
}
