<?php

use App\Models\Dataset;
use App\Models\Transaction;
use EnzoMC\PhpFPGrowth\FPGrowth;
use Illuminate\Support\Facades\Route;

function frequency($transactions)
{
    $frequency = [];

    foreach ($transactions as $transaction) {
        foreach ($transaction as $item) {
            if (!isset($frequency[$item])) {
                $frequency[$item] = 1;
            } else {
                $frequency[$item]++;
            }
        }
    }

    return $frequency;
}

Route::get('fp-growth/{id_dataset}', function ($id_dataset) {

    $dataset = Dataset::findOrfail($id_dataset);

    //nilai support yang ditentukan
    $support = 3;
    $confidence = 0.7;

    //inisialisasi class FPGrowth
    $fpgrowth = new FPGrowth($support, $confidence);

    //ambil data transaksi
    $transaction = Transaction::where('dataset_id', $dataset->id)->get();

    //mengambil data transaksi
    $transactions = [];
    foreach ($transaction as $key => $value) {
        $transactions[] = $value->details->pluck('product_name')->toArray();
    }

    //menghitung frekuensi item
    $frequencies = frequency($transactions);

    //urutkan dari yang terbanyak dan ambil 10 data teratas
    arsort($frequencies);
    $frequent = array_slice($frequencies, 0, 10);

    // tampilkan 10 item yang paling sering muncul
    echo "10 item yang paling sering muncul : <br>";
    foreach ($frequent as $key => $value) {
        echo $key . " : " . $value . "<br>";
    }

    //jalankan algoritma FP-Growth
    $fpgrowth->run($transactions);

    // masukan pattern ke variabel patterns
    $patterns = $fpgrowth->getPatterns();

    // tampilkan hasil pattern fp-growth
    echo "<br> Patterns : <br>";
    foreach ($patterns as $key => $value) {
        echo $key . " : " . $value . "<br>";
    }

    // masukan rule ke variabel rules
    $rules = $fpgrowth->getRules();

    // tampilkan hasil rule fp-growth
    echo "<br> Rules : <br>";
    foreach ($rules as $rule) {
        echo "Jika membeli " . $rule[0] . " maka akan membeli " . $rule[1] . " dengan nilai kepercayaan " . $rule[2] . "<br>";
    }
});
