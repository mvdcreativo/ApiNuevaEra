<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json= File::get('database/data/categories.json');
        $data= json_decode($json);

        foreach ($data as $campo) {
                if($campo->idStatus == 2){
                    $status = "DIS";
                }else{
                    $status = "ACT";
                };

                $name = $campo->name;
                $category = new App\Category([
                    'id' => $campo->id,
                    'name'=> $name,
                    'slug'=> Str::slug($name),
                    'status' => $status
                ]);
                $category->save();
            
            // $category->vehicle_categories()->sync(1);
        }
    }
}
