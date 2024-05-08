<?php

namespace App\Services;

use App\Models\Transaction;
use EnzoMC\PhpFPGrowth\FPGrowth;

class FPGrowthService
{
    private function frequency($transactions)
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

    public function algoritma($id_dataset)
    {
        //nilai support yang ditentukan
        $support = 3;
        $confidence = 0.7;

        //inisialisasi class FPGrowth
        $fpgrowth = new FPGrowth($support, $confidence);

        //ambil data transaksi
        $transaction = Transaction::where('dataset_id', $id_dataset)->get();

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

        // // tampilkan 10 item yang paling sering muncul
        // echo "10 item yang paling sering muncul : <br>";
        // foreach ($frequent as $key => $value) {
        //     echo $key . " : " . $value . "<br>";
        // }

        //jalankan algoritma FP-Growth
        $fpgrowth->run($transactions);

        // masukan pattern ke variabel patterns
        $patterns = $fpgrowth->getPatterns();

        // // tampilkan hasil pattern fp-growth
        // echo "<br> Patterns : <br>";
        // foreach ($patterns as $key => $value) {
        //     echo $key . " : " . $value . "<br>";
        // }

        // masukan rule ke variabel rules
        $rules = $fpgrowth->getRules();
        $rules_text = [];

        // tampilkan hasil rule fp-growth
        // echo "<br> Rules : <br>";
        foreach ($rules as $rule) {
            $rules_text[] = "Jika membeli <strong>" . $rule[0] . "</strong> maka akan membeli <strong>" . $rule[1] . "</strong> dengan nilai kepercayaan <strong>" . $rule[2] . "</strong>";
        }


        $data = [
            'frequent_1' => array_slice($frequencies, 0, 1),
            'frequent' => $frequent,
            'patterns' => $patterns,
            'rules' => $rules_text
        ];

        return $data;
    }
}
