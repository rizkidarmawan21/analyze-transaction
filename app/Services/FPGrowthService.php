<?php

namespace App\Services;

use App\Models\Transaction;
// use EnzoMC\PhpFPGrowth\FPGrowth;
use App\Libraries\FPGrowth\FPGrowth;

class FPGrowthService
{
    // private function frequency($transactions)
    // {
    //     $frequency = [];

    //     foreach ($transactions as $transaction) {
    //         foreach ($transaction as $item) {
    //             if (!isset($frequency[$item])) {
    //                 $frequency[$item] = 1;
    //             } else {
    //                 $frequency[$item]++;
    //             }
    //         }
    //     }

    //     return $frequency;
    // }



    /*
    * Fungsi ini untuk menghitung frekuensi item yaitu berapa kali item tersebut muncul
    * dalam transaksi. Jika item tersebut muncul lebih dari threshold maka item tersebut (threshold adalah nilai support)
    * akan dianggap sebagai item yang sering muncul.
    */
    private function frequency2($transactions, $threshold)
    {
        $frequentItems = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $item) {
                if (array_key_exists($item, $frequentItems)) {
                    $frequentItems[$item] += 1;
                } else {
                    $frequentItems[$item] = 1;
                }
            }
        }

        foreach (array_keys($frequentItems) as $key) {
            if ($frequentItems[$key] < $threshold) {
                unset($frequentItems[$key]);
            }
        }

        arsort($frequentItems);
        return $frequentItems;
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
        $frequencies = $this->frequency2($transactions, $support);

        //urutkan dari yang terbanyak dan ambil 10 data teratas
        $frequent = array_slice($frequencies, 0, 10);

        //jalankan algoritma FP-Growth
        $fpgrowth->run($transactions);

        // masukan pattern ke variabel patterns
        $patterns = $fpgrowth->getPatterns();


        // masukan rule ke variabel rules
        $rules = $fpgrowth->getRules();
        $rules_text = [];

        // tampilkan hasil rule fp-growth
        // echo "<br> Rules : <br>";
        foreach ($rules as $rule) {
            $rules_text[] = "Jika membeli <strong>" . $rule[0] . "</strong> maka akan membeli <strong>" . $rule[1] . "</strong> dengan nilai kepercayaan <strong>" . $rule[2] * 100 . "%</strong>";
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
