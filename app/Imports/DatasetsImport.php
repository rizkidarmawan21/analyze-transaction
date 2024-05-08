<?php

namespace App\Imports;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DatasetsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row[0] == 'NO.') {
                continue;
            }
            if ($row[1] == null) {
                $transaction = Transaction::latest()->first();
            } else {
                // dd($row[2]);
                // dd(gettype($row[2]));
                $date = Date::excelToDateTimeObject(intval($row[2]));
                $date = Carbon::instance($date);
                // dd($date);
                // dd($date);
                $transaction = Transaction::create([
                    'dataset_id' => $this->id,
                    'no_transaction' => $row[1],
                    'transaction_date' => $date,
                    'customer_name' => $row[3],
                    'total_price' => $row[7],
                ]);
            }
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_name' => $row[4],
                'quantity' => $row[5],
                'price' => $row[6],
            ]);
        }
    }
}
