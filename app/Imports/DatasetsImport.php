<?php

namespace App\Imports;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

        try {
            DB::beginTransaction();

            // hapus array yang pertama
            $rows->forget(0);

            $transaction = Transaction::latest()->first();

            foreach ($rows as $row) {
                if ($row[1] == null) {
                } else {

                    $date = Date::excelToDateTimeObject(intval($row[2]));
                    $date = Carbon::instance($date);
                    $transaction = Transaction::create([
                        'dataset_id' => $this->id,
                        'no_transaction' => $row[1],
                        'transaction_date' => $date,
                        'customer_name' => $row[3]
                    ]);
                }

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_name' => $row[4],
                    'quantity' => $row[5],
                    'price' => $row[6],
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->back()->with('failed', 'Gagal mengimport data' . $th->getMessage());
        }
    }
}
