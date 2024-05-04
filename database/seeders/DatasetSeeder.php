<?php

namespace Database\Seeders;

use App\Models\Dataset;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataset =      Dataset::create([
            'user_id' => 2,
            'file_name' => 'test.xlsx'
        ]);
        $transactions = [
            [
                'no_transaction' => 'TRX001',
                'transaction_date' => '2021-01-01',
                'customer_name' => 'John Doe',
                'total_price' => 100000,
                'details' => [
                    ['product_name' => 'Laptop Asus', 'quantity' => 1, 'price' => 100000],
                    ['product_name' => 'Laptop Axio', 'quantity' => 1, 'price' => 200000], ['product_name' => 'Laptop Axio', 'quantity' => 2, 'price' => 150000],
                    ['product_name' => 'Laptop HP', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Tuf', 'quantity' => 3, 'price' => 100000]
                ]
            ],
            [
                'no_transaction' => 'TRX002',
                'transaction_date' => '2021-01-02',
                'customer_name' => 'Jane Doe',
                'total_price' => 200000,
                'details' => [
                    ['product_name' => 'Laptop Tuf', 'quantity' => 1, 'price' => 100000], ['product_name' => 'Laptop Asus', 'quantity' => 1, 'price' => 100000],
                    ['product_name' => 'Laptop Axio', 'quantity' => 1, 'price' => 200000], ['product_name' => 'Laptop Axio', 'quantity' => 2, 'price' => 150000],
                    ['product_name' => 'Laptop HP', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 200000]
                ]
            ],  [
                'no_transaction' => 'TRX002',
                'transaction_date' => '2021-01-02',
                'customer_name' => 'Jane Doe',
                'total_price' => 200000,
                'details' => [
                    ['product_name' => 'Laptop Axio', 'quantity' => 1, 'price' => 100000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 200000]
                ]
            ],  [
                'no_transaction' => 'TRX002',
                'transaction_date' => '2021-01-02',
                'customer_name' => 'Jane Doe',
                'total_price' => 200000,
                'details' => [
                    ['product_name' => 'Laptop Tuf', 'quantity' => 1, 'price' => 100000],
                    ['product_name' => 'Laptop Asus', 'quantity' => 1, 'price' => 200000], ['product_name' => 'Laptop Axio', 'quantity' => 1, 'price' => 100000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 200000]
                ]
            ], [
                'no_transaction' => 'TRX003',
                'transaction_date' => '2021-01-03',
                'customer_name' => 'Alice Smith',
                'total_price' => 300000,
                'details' => [
                    ['product_name' => 'Laptop Dell', 'quantity' => 2, 'price' => 150000], ['product_name' => 'Laptop Axio', 'quantity' => 1, 'price' => 100000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 200000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Lenovo', 'quantity' => 3, 'price' => 100000]
                ]
            ], [
                'no_transaction' => 'TRX003',
                'transaction_date' => '2021-01-03',
                'customer_name' => 'Alice Smith',
                'total_price' => 300000,
                'details' => [
                    ['product_name' => 'Laptop Tuf', 'quantity' => 2, 'price' => 150000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Lenovo', 'quantity' => 3, 'price' => 100000],  ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 200000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Lenovo', 'quantity' => 3, 'price' => 100000]
                ]
            ], [
                'no_transaction' => 'TRX003',
                'transaction_date' => '2021-01-03',
                'customer_name' => 'Alice Smith',
                'total_price' => 300000,
                'details' => [
                    ['product_name' => 'Laptop Dell', 'quantity' => 2, 'price' => 150000],
                    ['product_name' => 'Laptop HP', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Rog', 'quantity' => 3, 'price' => 100000]
                ]
            ], [
                'no_transaction' => 'TRX003',
                'transaction_date' => '2021-01-03',
                'customer_name' => 'Alice Smith',
                'total_price' => 300000,
                'details' => [
                    ['product_name' => 'Laptop Tuf', 'quantity' => 2, 'price' => 150000],
                    ['product_name' => 'Laptop Axio', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Lenovo', 'quantity' => 3, 'price' => 100000]
                ]
            ], [
                'no_transaction' => 'TRX003',
                'transaction_date' => '2021-01-03',
                'customer_name' => 'Alice Smith',
                'total_price' => 300000,
                'details' => [
                    ['product_name' => 'Laptop Axio', 'quantity' => 2, 'price' => 150000],
                    ['product_name' => 'Laptop HP', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Tuf', 'quantity' => 3, 'price' => 100000], ['product_name' => 'Laptop HP', 'quantity' => 1, 'price' => 150000],
                    ['product_name' => 'Laptop Tuf', 'quantity' => 3, 'price' => 100000]
                ]
            ]
        ];
        $new_transaction = [
            'no_transaction' => 'TRX003',
            'transaction_date' => '2021-01-03',
            'customer_name' => 'Alice Smith',
            'total_price' => 300000,
            'details' => [
                ['product_name' => 'Laptop Dell', 'quantity' => 2, 'price' => 150000],
                ['product_name' => 'Laptop Axio HP', 'quantity' => 1, 'price' => 150000], ['product_name' => 'Laptop HP', 'quantity' => 1, 'price' => 150000],
                ['product_name' => 'Laptop Tuf', 'quantity' => 3, 'price' => 100000],
                ['product_name' => 'Laptop Lenovo', 'quantity' => 3, 'price' => 100000]
            ]
        ];

        array_push($transactions, $new_transaction);

        foreach ($transactions as $transactionData) {
            $transaction = Transaction::create([
                'dataset_id' => $dataset->id,
                'no_transaction' => $transactionData['no_transaction'],
                'transaction_date' => $transactionData['transaction_date'],
                'customer_name' => $transactionData['customer_name'],
                'total_price' => $transactionData['total_price']
            ]);

            foreach ($transactionData['details'] as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_name' => $detail['product_name'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price']
                ]);
            }
        }
    }
}
