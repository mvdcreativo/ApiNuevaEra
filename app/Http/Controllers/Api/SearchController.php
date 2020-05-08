<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class SearchController extends Controller
{
    //
    public function search(Request $request){
        $searcher = $request->buscando;

        $result = Product::with('category')->searcher($searcher)->get();
        return response()->json($result, 200);
    }

    public function search_paginate(Request $request){
        $searcher = $request->buscando;

        $result = Product::with('category','brand')->searcher($searcher)->paginate(14);

        return response()->json($result, 200);
    }
}
