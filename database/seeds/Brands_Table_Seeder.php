<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class Brands_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json= File::get('database/data/brands.json');
        $data= json_decode($json);

        foreach ($data as $campo) {
            $brandSlug = Str::slug($campo->name);
            $brand = App\Brand::where('slug', $brandSlug)->first();
            if($brand){
                $brand->categories()->sync($campo->idCategory);
                $brand->save();
            }else{

                if($campo->idStatus == 2){
                    $status = "DIS";
                }else{
                    $status = "ACT";
                };

                $name = $campo->name;
                $brandNew = new App\Brand([
                    'id' => $campo->id,
                    'name'=> $name,
                    'slug'=> Str::slug($name),
                    'destaca'=> rand(0,1),
                    "status" => $status,
                ]);
                $brandNew->save();
                $brandNew->categories()->sync($campo->idCategory);
                $brandNew->save();
                
            }

            // $category->vehicle_categories()->sync(1);
        }
    }
}
