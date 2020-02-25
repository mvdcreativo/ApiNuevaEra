<?php

use Illuminate\Database\Seeder;

class Status_Table_Seeder extends Seeder
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
            'name' => "Procesando",
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Pendiente de Pago",
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Pago",
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Enviado",
        ]);
        $status->save();
        $status = new App\Status([
            'name' => "Finalizado",
        ]);
        $status->save();
    }
}
