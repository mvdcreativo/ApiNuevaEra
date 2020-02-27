<?php

use Illuminate\Database\Seeder;

class Products_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json= File::get('database/data/products.json');
        $data= json_decode($json);

        $jsonBrands= File::get('database/data/brands.json');
        $dataBrands= json_decode($jsonBrands);

        $jsonImage= File::get('database/data/images_products.json');
        $dataImage= json_decode($jsonImage);
        
        foreach ($data as $campo) {

            $brand = App\Brand::find($campo->marca);

            if($brand){
                $marca = $campo->marca;
            }else{
                foreach ($dataBrands as $item_brand) {
                    if($item_brand->id == $campo->marca){
                        $slugBrand = str_slug($item_brand->name);

                        $brandBySlug = App\Brand::where('slug', $slugBrand)->first();
                        $marca = $brandBySlug->id;
                    }
                }
            }



            if($campo->status != 2){
                $status = "ACT";
                foreach ($dataImage as $item) {
                    if($item->idProduct == $campo->id){
                        $image = $item->image;
                        break;
                    };
                };
                
                
                $name = trim($campo->name);
                $product = new App\Product([
            
                'id' => $campo->id,
                'name'=> $name,
                'slug'=> str_slug($name),
                'name_concat'=> $name,
                'brand_id'=> $marca,
                'category_id' => $campo->category,
                'description' => trim(str_replace("\r\n", " ", $campo->description)),
                'picture' => "images/productos/".$image,
                'price' => intval($campo->price),
                'status'=> $status,
                'stock' => 100,
                ]);
                $product->save();
            }
                        
           }
    }
}
