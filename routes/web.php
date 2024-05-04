<?php

use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;
use EnzoMC\PhpFPGrowth\FPGrowth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::resource('datasets', DatasetController::class);
});

Route::get('import-users', [UserController::class, 'import'])->name('import-users');

require __DIR__ . '/auth.php';

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

Route::get('fp-growth', function () {
    //nilai support yang ditentukan
    $support = 3;
    $confidence = 0.7;

    //inisialisasi class FPGrowth
    $fpgrowth = new FPGrowth($support, $confidence);

    //ambil data transaksi
    $transaction = Transaction::all();

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
