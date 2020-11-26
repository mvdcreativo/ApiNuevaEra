<?php

namespace App\Exports;

use App\Product;
use App\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class UserExport implements WithMapping, WithHeadings, FromCollection
{



    public function collection()
    {
        return User::all();
    }

 
    public function map($user): array
    {


        return [
            $user->id,
            trim($user->name),
            trim($user->lastname), 
            $user->email, 
            trim($user->ci), 
            trim($user->company), 
            trim($user->rut), 
            trim($user->city), 
            trim($user->state), 
            trim($user->address),
            trim($user->phone),


        ];
    }


    // Headers columnas
    public function headings(): array
    {
        return [
            'id',
            'Nombre', 
            'Apellido', 
            'Email', 
            'Documento', 
            'Empresa', 
            'RUT', 
            'Ciudad', 
            'Departamento', 
            'Direccion',
            'Teléfono',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'id' => '',
            'Nombre' => '', 
            'Apellido' => '', 
            'Email' => '', 
            'Documento' => NumberFormat::FORMAT_NUMBER, 
            'Empresa' => '', 
            'RUT'=> NumberFormat::FORMAT_NUMBER, 
            'Ciudad' => '', 
            'Departamento' => '', 
            'Direccion' => '',
            'Teléfono' => '',
        ];
    }




}
