<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Carousel;
use App\Image;
use Illuminate\Support\Facades\Storage;


class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousel = Carousel::with('images')->get();
        return response()->json($carousel, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);

        $carousel = new Carousel;
        $carousel->name = $request->name;
        $carousel->platform = $request->platform;
        $carousel->save();


        // Images
        $this->validate($request, [

            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048000'

        ]);
        if($request->hasFile('images')){
            foreach($request->file('images') as $image)
            {

                $path = Storage::disk('public')->put('images/carousel',  $image);
                $image = new Image;
                $image->fill(['url' => asset('storage/'.$path)])->save();
                $image->carousels()->sync($carousel->id);
                $image->save();

            }
         }
        
        return response()->json($carousel, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carousel = Carousel::with('images')->findOrFail($id);
        return response()->json($carousel, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carousel = Carousel::with('images')->findOrFail($id);
        if($request->name)$carousel->name = $request->name;
        if($request->platform)$carousel->platform = $request->platform;


        // Images
        $this->validate($request, [

            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048000'

        ]);
        if($request->hasFile('images')){
            foreach($request->file('images') as $image)
            {

                // echo $image->path();

                $path = Storage::disk('public')->put('images/carousel',  $image);
                // $product->fill(['file' => asset($path)])->save();
                $image = new Image;
                $image->fill(['url' => asset('storage/'.$path)])->save();
                $image->carousels()->sync($id);
                $image->save();
 

            }
            $carousel = Carousel::with('images')->find($id);
            return response()->json($carousel, 200);
         }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carousel = Carousel::with('images')->findOrFail($id);
        foreach ($carousel->images as $image) {
            $img = Image::find($image->id);
            $imgName = explode("/", $image->url);
            Storage::disk('public')->delete('images/carousel/'.$imgName[6]);
            $img->delete();
            
        }
        $carousel->delete();

        return response()->json($carousel, 200);
    }
}

