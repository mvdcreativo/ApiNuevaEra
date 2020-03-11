<?php

use Illuminate\Database\Seeder;

class InstallmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_method = new App\Installment([
            'name' => "1 cuota",
            'quantity' => 1
        ]);
        $payment_method->save();
        $payment_method = new App\Installment([
            'name' => "2 cuotas",
            'quantity' => 2
        ]);
        $payment_method->save();
        $payment_method = new App\Installment([
            'name' => "3 cuotas",
            'quantity' => 3
        ]);
        $payment_method->save();
        $payment_method = new App\Installment([
            'name' => "6 cuotas",
            'quantity' => 6
        ]);
        $payment_method->save();
        $payment_method = new App\Installment([
            'name' => "12 cuotas",
            'quantity' => 12
        ]);
        $payment_method->save();
    }
}
