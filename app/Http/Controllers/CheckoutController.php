<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    protected function generatePaymentGateway($paymentMethod, Order $order) : string
    {
        $method = new \App\PaymentMethods\MercadoPago;

        return $method->setupPaymentAndGetRedirectURL($order);
    }



    public function createOrder($order_id, Request $request)
    {
        $order = Order::with('productos')->find($order_id);
        $allowedPaymentMethods = config('payment-methods.enabled');
    
        $request->validate([
            // 'payment_method' => [
            //     'required',
            //     // Rule::in($allowedPaymentMethods),
            // ],
            // 'terms' => 'accepted',
        ]);
    
        
    
        $url = $this->generatePaymentGateway($allowedPaymentMethods,$order);
        return redirect()->to($url);
    }

}
