<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Transaction;
use App\Services\FPGrowthService;
use Carbon\Carbon;
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
        if ($dataset) {
            $output = $FPGrowth->algoritma($dataset->id);
        } else {
            $output = [
                'frequent' => [],
                'rules' => [],
                'pattern' => []
            ];
        }

        return view('pages.product_analyze.index', compact('listDataset', 'output', 'dataset'));
    }

    public function grafik()
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
        if ($dataset) {
            $output = $FPGrowth->algoritma($dataset->id);
        } else {
            $output = [
                'frequent' => [],
                'rules' => [],
                'pattern' => []
            ];
        }

        return view('pages.product_analyze.grafik', compact('listDataset', 'output', 'dataset'));
    }

    public function report(Request $request)
    {
        $startYear = $request->start_year ?? date('Y');
        $endYear = $request->end_year ?? date('Y') - 2;

        $transactions = Transaction::whereYear('transaction_date', '>=', $endYear)
            ->whereYear('transaction_date', '<=', $startYear)
            ->get()
            ->groupBy(function ($transaction) {
                // Convert the transaction_date string to a Carbon object
                $transaction_date = Carbon::parse($transaction->transaction_date);
                // Group transactions by year
                return $transaction_date->format('Y');
            });

        $dataWithFrequency = [];
        $result = [];
        $labels = [];

        // GET LABELS & Master Data
        foreach ($transactions as $year => $transaction) {
            $items = [];
            foreach ($transaction as $key => $value) {
                $items[] = $value->details->pluck('product_name')->toArray();
            }
            $FPGrowth = new FPGrowthService();

            $support = 3;
            $output = $FPGrowth->frequency2($items, $support);

            $frequent = array_slice($output, 0, 10);

            $dataWithFrequency[] = [
                'year' => $year,
                'frequent' => $frequent,
            ];

            // add array_keys($frequent) to labels if not already present
            foreach (array_keys($frequent) as $key) {
                if (!in_array($key, $labels)) {
                    $labels[] = $key;
                }
            }
        }


        // GET DATA 
        foreach ($transactions as $year => $transaction) {
            $items = [];
            foreach ($transaction as $key => $value) {
                $items[] = $value->details->pluck('product_name')->toArray();
            }
            $FPGrowth = new FPGrowthService();

            $support = 3;
            $output = $FPGrowth->frequency2($items, $support);

            $frequent = array_slice($output, 0, 10);

            // Check and add 0 for labels that don't exist
            foreach ($labels as $label) {
                if (!array_key_exists($label, $frequent)) {
                    $frequent[$label] = 0;
                }
            }

            $data = [];

            foreach ($labels as $label) {
                $data[] = $frequent[$label];
            }

            $color = "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 0.4)";

            $result[] = [
                'year' => $year,
                'label' => "Thn $year",
                'frequent' => $frequent,
                'data' => $data,
                'fill' => false,
                'lineTension' => 0.1,
                'backgroundColor' => $color,
                "borderColor" => $color,
            ];
        }

        // dd($result, $labels);
        // dd($dataWithFrequency);

        return view('pages.product_analyze.report', compact('result', 'labels', 'dataWithFrequency', 'startYear', 'endYear'));
    }
}
