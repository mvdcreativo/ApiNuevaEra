<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductFacebookExport;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('category','brand')->where('status','!=','DIS')->orderBy('id', 'desc')->get();

    }

    public function all()
    {
        return Product::with('category','brand')->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->file('picture');
        $this->validate($request, [
            'name' => ['required'],
            'price' => ['required'],
            'name_concat' => ['required'],
            'stock' => ['required'],
        ]);

        $name = $request->name;
        $slug = Str::slug($name);


        $validateProduct = Product::where('slug', $slug)->get();

                if(count($validateProduct)>=1){
                    return response()->json(["message" => "Producto ".$name." ya existe!!!"], 400);
                }else{
                    
            $product = new Product;
            $product->name = $name;
            $product->slug = $slug;
            $product->name_concat = $request->name_concat;
            $product->price = $request->price;
            $product->price_mayorista = $request->price_mayorista;
            $product->discount = $request->discount;
            $product->stock = $request->stock;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->save();

            ///relacionamos la marca con categoria
            $brand = Brand::find($product->brand_id);
            $brand->categories()->sync($product->category_id);
            

            
            if($request->file('picture')){
                $img = $request->file('picture');

                $path = Storage::disk('public')->put('images/productos',  $img);
                // $product->fill(['file' => asset($path)])->save();
                // return $path;
                $product->fill(['picture' => $path])->save();
                
                // return $product;
            }

            return response()->json($product, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('brand', 'category')->find($id);
        return response()->json($product, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
       // return $request->file('picture');


    $name = $request->name;
    $slug = Str::slug($name);


    $validateProduct = Product::where('slug', $slug)->where('id', '!=', $id)->get();

            if(count($validateProduct)>=1){
                return response()->json(["message" => "Producto ".$name." ya existe!!!"], 400);
            }else{
                
        $product = Product::find($id);
        if($request->name) $product->name = $name;
        if($request->slug) $product->slug = $slug;
        if($request->name_concat) $product->name_concat = $request->name_concat;
        if($request->price) $product->price = $request->price;
       if($request->price_mayorista or $request->price_mayorista==0 ) $product->price_mayorista = $request->price_mayorista;
       if($request->discount or $request->discount==0 ) $product->discount = $request->discount;
       if($request->stock) $product->stock = $request->stock;
       if($request->brand_id) $product->brand_id = $request->brand_id;
       if($request->category_id) $product->category_id = $request->category_id;
       if($request->status) $product->status = $request->status;
       if($request->description) $product->description = $request->description;
        $product->save();


        ///relacionamos la marca con categoria

        $brand = Brand::find($product->brand_id);
        $brand->categories()->sync($product->category_id);
        

        if($request->file('picture')){
            $img = $request->file('picture');

            $path = Storage::disk('public')->put('images/productos',  $img);
            // $product->fill(['file' => asset($path)])->save();
            // return $path;
            $product->fill(['picture' => $path])->save();
            
            // return $product;
        }

        return response()->json($product, 200);
    }    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json($product, 200);
    }




    public function exportFaceboock(){
        // Storage::disk('public')->put('images/productos',  $img);
        return Excel::store(new ProductFacebookExport, 'da_catalog_commerce_commented_template.csv', storage_path('storage/excel/exports'));//'da_catalog_commerce_commented_template.csv'

    }


////////////////////////
    public function bySlug($slug)
    {
        $product = Product::with('category','brand')->where('slug', $slug)->first();
        $product->visits = $product->visits + 1;
        $product->save();

        return $product;
    }
////////////////////////////

////////////////////////////
    public function byCategoryID($category_id){
        $product = Product::with('category','brand')
        ->where('category_id', $category_id)
        ->where('status','!=','DIS')
        ->orderBy('id', 'desc')
        ->paginate(14);

        $category = Category::find($category_id);
        // return $category;  
        $category->visits = $category->visits + 1;
        $category->save();

        return response()->json($product, 200);
    }
    ///////////////////////////

    ////////////////////////////
    public function byBrandID($brand_id){
        $product = Product::with('category','brand')->where('brand_id', $brand_id)->orderBy('id', 'desc')->paginate(14);

        $brand = Brand::find($brand_id);
        // return $brand;  
        $brand->visits = $brand->visits + 1;
        $brand->save();

        return response()->json($product, 200);
    }
    ///////////////////////////
    public function findByIds(Request $request)
    {
        return $request->get('ids');
        $ids_sep_coma = $request->get('ids');
        $ids = explode(",", $ids_sep_coma);
        $products= Product::with('brand', 'category')->whereIn('id',$ids)->get();
        return response()->json($products, 200);
    }
}
