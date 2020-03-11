<?php

use Illuminate\Database\Seeder;

class Users_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json= File::get('database/data/users.json');
        $data= json_decode($json);

        $jsonUser= File::get('database/data/customers.json');
        $dataUser= json_decode($jsonUser);
        
        foreach ($data as $campo) {

            foreach ($dataUser as $item) {

                if($campo->idClient == $item->id){
                    $cliente = $item;
                    break;
                };
            };

            if($cliente->idstatus == 2){
                $status = "DIS";
            }else{
                $status = "ACT";
            };
            

            $name = $campo->name;
            $user = new App\User([
                
                'id' => $campo->id,
                'name' => $campo->name,
                'lastname' => $cliente->lastName,
                'email' => $campo->email,
                'email_verified_at' => now(),
                'password' => $campo->password, // password
                'discount'=> null, 
                'company'=> null, 
                'ci'=> null, 
                'rut'=> null, 
                'city'=> null, 
                'state'=> null, 
                'status'=> $status, 
                'address'=> null,
                'role'=> "USER",
                'phone'=> $cliente->movile." / ".$cliente->phone,
                'id_cliente_cobrosya'=> $cliente->id_cliente_cobrosya,
                                
            ]);
            $user->save();

            
           }

        $user = new App\User([

            
            'name' => "Emir",
            'lastname' => "Mendez",
            'email' => "mvdcreativo@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt('dan23608'), // password
            'discount'=> null, 
            'company'=> null, 
            'ci'=> null, 
            'rut'=> null, 
            'city'=> "Montevideo", 
            'state'=> "Montevideo", 
            'status'=> "ACT", 
            'address'=> null,
            'role'=> "ADM",
            'phone'=> "092987661",
            'id_cliente_cobrosya'=> null,
                            
        ]);
        $user->save();
    }
}
