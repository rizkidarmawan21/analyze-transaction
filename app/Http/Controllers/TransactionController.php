<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $listDataset = Dataset::all();
        // get id dataset from url parameter
        $id_dataset = request()->get('dataset_id');
        $search = request()->get('search');

        if ($id_dataset) {
            $dataset = Dataset::find($id_dataset);

            if (!$dataset) {
                return redirect()->route('analyze.index')->with('failed', 'Dataset not found');
            }
        } else {
            $dataset = Dataset::latest()->first();
        }


        if ($search) {
            $transactions = $dataset->transactions()
                ->where('no_transaction', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%')
                ->paginate(15);

            $total = $dataset->transactions->where('no_transaction', 'like', '%' . $search . '%')->count();
        } else {
            $transactions = $dataset->transactions()->paginate(15);
            $total = $dataset->transactions->count();
        }

        // $transactions = $dataset->transactions()->paginate(15);
        // $total = $dataset->transactions->count();

        return view('pages.transaction.index', compact('transactions', 'total', 'dataset', 'listDataset'));
    }
}
