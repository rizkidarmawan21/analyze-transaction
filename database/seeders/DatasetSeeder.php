<?php

namespace Database\Seeders;

use App\Models\Dataset;
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

        // $transaction = Transaction::create([

        // ]);
        //  $table->id();
        // $table->foreignIdFor(Dataset::class)->constrained('datasets')->cascadeOnDelete()->cascadeOnUpdate();
        // $table->string('no_transaction');
        // $table->date('transaction_date');
        // $table->string('customer_name');
        // $table->integer('total_price');
        // $table->timestamps();
    }
}
