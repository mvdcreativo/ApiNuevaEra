<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Brand::all();
    }



    public function brand_by_slug($slug){
        $brand = Brand::with('products')->where('slug', $slug)->where('status', 'ACT')->first();
        $brand->visits = $brand->visits + 1;
        $brand->save();
        return response()->json($brand, 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
// return $request->all();
        $this->validate($request, [
            'name' => ['required']
        ]);
        $name = $request->name;
        $slug = Str::slug($name);
        if($request->destaca){
            $destaca = $request->destaca;
        }else{
            $destaca = 1;
        };
        $destaca = $request->destaca;
        $description= $request->description;

        $validateBrand = Brand::where('slug', $slug)->get();

        if(count($validateBrand)>=1){
            return response()->json(["message" => "Marca ".$name." ya existe!!!"], 400);
        }else{


            $brand = new Brand;
            $brand->name = $name;
            $brand->slug = $slug;
            $brand->destaca = $destaca;
            $brand->description = $description;
            $brand->save();

            if($request->file('image_url')){
                $img = $request->file('image_url');

                $path = Storage::disk('public')->put('images/logos-marcas',  $img);
                // $product->fill(['file' => asset($path)])->save();
                // return $path;
                $brand->fill(['image_url' => $path])->save();
                
                return $brand;
            }

            return response()->json($brand, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {


        $name = $request->name;
        $slug = Str::slug($name);
        $destaca = $request->destaca;
        $description= $request->description;
        $status = $request->status;

        $validateBrand = Brand::where('slug', $slug)->where('id', '!=', $id)->get();

        if(count($validateBrand)>=1){
            return response()->json(["message" => "Marca ".$name." ya existe!!!"], 400);
        }else{


            $brand = Brand::find($id);
            if($request->name) $brand->name = $name;
            if($request->slug) $brand->slug = $slug;
            // if($request->destaca or $request->destaca == 0 and $request->destaca != null) $brand->destaca = $destaca;
            if($request->destaca or $request->destaca == 0 ) $brand->destaca = $destaca;

            if($request->description) $brand->description = $description;
            if($request->status){
                $brand->status =  $status;
                /////AFECTAR ARTICULOS AL ACTIVAR O DESACTIVAR MARCA
                $product= Product::where('brand_id', $brand->id)->get();

                foreach ($product as $element) {
                    // return $element;
                    $element->status = $request->status;
                    $element->save();
                }

            } 

            $brand->save();



            if($request->hasFile('image_url')){
                $img = $request->file('image_url');

                $path = Storage::disk('public')->put('images/logos-marcas',  $img);
                // $product->fill(['file' => asset($path)])->save();

                $brand->fill(['image_url' => $path])->save();
                $brand->save();
            }

            return response()->json($brand, 200);
        }    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();

        return response()->json($brand, 200);    }
}
