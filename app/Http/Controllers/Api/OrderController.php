<?php

namespace App\Http\Controllers\Api;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $user = Auth::user();
        // return [$user];
        $filter = $request->filter;
        $sortOrder = $request->sortOrder;
        $pageSize = $request->pageSize;

        if($user->role === "ADM"){

            return Order::with('status','productos')->searcher($filter)->orderBy('id', 'DESC')->paginate($pageSize);
        }else{

            return Order::where('user_id', $user->id)->with('status','productos')->searcher($filter)->orderBy('id', 'DESC')->paginate($pageSize);
        }
        
        //
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//         $a=[16 =>['quantity' => 1, 'price'=> 2500]];

//         $b = $request->products;

//    return $b;
 
// return json_encode($request->products);

            $order = new Order;
            $order->user_id = $request->user_id;
            $order->name = $request->name;
            $order->lastname = $request->lastname;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->status_id = 2;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->phone = $request->phone;
            $order->ci = $request->ci;
            $order->rut = $request->rut;
            $order->company = $request->company;
            $order->total = $request->total;
            $order->save();


            foreach ($request->get('products') as $value) {
                $order->productos()->attach($value);
            }
            return response()->json($order, 200);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $order = Order::with('productos', 'status')->find($id);

        return response()->json($order, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        
        $order = Order::find($id);
        // $order->user_id = $request->user_id;
        // $order->name = $request->name;
        // $order->lastname = $request->lastname;
        // $order->email = $request->email;
        if($request->address) $order->address = $request->address;
        if($request->status_id) $order->status_id = 2;
        if($request->city) $order->city = $request->city;
        if($request->state) $order->state = $request->state;
        if($request->phone) $order->phone = $request->phone;
        if($request->rut) $order->rut = $request->rut;
        if($request->company) $order->company = $request->company;
        // if($request->total) $order->total = $request->total;
        $order->save();


        foreach ($request->get('products') as $value) {
            $order->productos()->attach($value);
        }
        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
