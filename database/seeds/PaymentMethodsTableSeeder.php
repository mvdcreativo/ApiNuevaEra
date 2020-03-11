<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_method = new App\PaymentMethod([
            'name' => "Abitab",
            'logo' => "abitab.png"
        ]);
        $payment_method->save();

        $payment_method = new App\PaymentMethod([
            'name' => "Brou",
            'logo' => "brou.png"
        ]);
        $payment_method->save();

        $payment_method = new App\PaymentMethod([
            'name' => "Santander",
            'logo' => "santander.png"
        ]);
        $payment_method->save();

        $payment_method = new App\PaymentMethod([
            'name' => "BBVA",
            'logo' => "bbva.png"
        ]);
        $payment_method->save();

        $payment_method = new App\PaymentMethod([
            'name' => "Paganza",
            'logo' => "paganza.png"
        ]);
        $payment_method->save();

        $payment_method = new App\PaymentMethod([
            'name' => "Redpagos",
            'logo' => "redpagos.png"
        ]);
        $payment_method->save();

        
        $payment_method = new App\PaymentMethod([
            'name' => "Visa",
            'logo' => "visa.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Mastercard",
            'logo' => "mastercard.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Diners",
            'logo' => "diners.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Discover",
            'logo' => "discover.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Lider",
            'logo' => "lider.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Oca",
            'logo' => "oca.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Banred",
            'logo' => "banred.png"
        ]);
        $payment_method->save();

        $payment_method = new App\PaymentMethod([
            'name' => "Creditel",
            'logo' => "creditel.png"
        ]);
        $payment_method->save();
        $payment_method->installments()->sync([1,2,3,4,5]);

        $payment_method = new App\PaymentMethod([
            'name' => "Cabal",
            'logo' => "cabal.png"
        ]);
        $payment_method->save();

    }
}
