<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new App\Status([
            'name' => "Finalizado",
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Pago en Proceso",
            'code' => "payment_in_process"
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Pendiente de Pago",
            'code' => "payment_required"
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Pago",
            'code' => 'paid'
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Enviado",
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Reintegrado",
            'code' => "reverted"
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Reintegrado Parcial",
            'code' => "partially_reverted"
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Pago Parcial",
            'code' => "partially_paid"
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Indefinido",
            'code' => "undefined"
        ]);
        $status->save();

    }
}


