<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Services\FPGrowthService;
use Illuminate\Http\Request;

class AnalyzeProductController extends Controller
{
    public function index()
    {
        $listDataset = Dataset::all();
        // get id dataset from url parameter
        $id_dataset = request()->get('dataset_id');

        if ($id_dataset) {
            $dataset = Dataset::find($id_dataset);

            if (!$dataset) {
                return redirect()->route('analyze.index')->with('failed', 'Dataset not found');
            }
        } else {
            $dataset = Dataset::latest()->first();
        }

        $FPGrowth = new FPGrowthService();
        if($dataset){
            $output = $FPGrowth->algoritma($dataset->id);
        }else{
            $output = [
                'frequent' => [],
                'rules' => [],
                'pattern' => []
            ];
        }

        // dd($output);

        return view('pages.product_analyze.index', compact('listDataset', 'output', 'dataset'));
    }
}
