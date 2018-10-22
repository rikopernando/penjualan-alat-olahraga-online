<?php

use Illuminate\Database\Seeder;
use App\Bank;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = new Bank();
        $bank->name = "BNI SYARIAH";
        $bank->atas_nama = "Admin";
        $bank->no_rek = "235 873 525 99";
        $bank->default = "0";
        $bank->save();
    }
}
