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
        $transactions = $dataset->transactions()->paginate(15);
        $total = $dataset->transactions->count();
        return view('pages.datasets.show', compact('dataset', 'transactions', 'total'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file_name' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('file_name');

        // file_name = name_file + time() + extension
        $file_name = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('public/dataset', $file_name);
        $fileName = 'storage/' . str_replace('public/', '', $path);

        $dataset = Dataset::create([
            'name' => $request->name,
            'file_name' => $fileName,
            'user_id' => auth()->id()
        ]);

        Excel::import(new DatasetsImport($dataset->id), $file);

        return redirect()->back()->with('success', 'Import dataset successfully.');
    }


    public function downloadTemplate()
    {
        return response()->download(public_path('template_excel.xlsx'));
    }

    public function destroy(Dataset $dataset)
    {
        $transactions = $dataset->transactions;
        foreach ($transactions as $transaction) {
            $transaction->details()->delete();
            $transaction->delete();
        }

        $dataset->delete();

        return redirect()->back()->with('success', 'Delete dataset successfully.');
    }
}
