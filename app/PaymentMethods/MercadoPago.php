<?php

namespace App\PaymentMethods;

use App\Order;

use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPago
{
  public function __construct()
  {
    SDK::setClientId(
          config("payment-methods.mercadopago.client")
     );
    SDK::setClientSecret(
          config("payment-methods.mercadopago.secret")
     );
  }

  private function map($v){
    $item = new Item();
    $item->id = $v->id;
    $item->title = $v->name;
    $item->quantity = $v->pivot->quantity;
    $item->currency_id = 'UYU';
    $item->unit_price = $v->pivot->price;
    $item->picture_url = assets("storage/".$v->picture);
    return $item;
  }
    
  public function setupPaymentAndGetRedirectURL(Order $order): string
  {
     # Create a preference object
     $preference = new Preference();
    // return($order);
    


      # Create an item object
      $items = Array();

      foreach ($order->productos as $value) {
        $item = new Item();
        $item->id = $value->id;
        $item->title = $value->name;
        $item->quantity = $value->pivot->quantity;
        $item->currency_id = 'UYU';
        $item->unit_price = $value->pivot->price;
        $item->picture_url = asset("storage/".$value->picture);

        $items[] = $item;
      }


    

      # Create a payer object
      $payer = new Payer();
      $payer->email = "email@cliente.com";

      # Setting preference properties
      $preference->items = $items;
      $preference->payer = $payer;

      # Save External Reference
      $preference->external_reference = "Nº de orden";
      $preference->back_urls = [
        "success" => 'http://nuevaerauruguay.tk',
        "pending" => 'http://nuevaerauruguay.tk',
        "failure" => 'http://nuevaerauruguay.tk',
      ];
        
      $preference->auto_return = "all";
      $preference->notification_url = 'http://nuevaerauruguay.tk';
      # Save and POST preference
      $preference->save();

      if (config('payment-methods.use_sandbox')) {
        return $preference->sandbox_init_point;
      }

      return $preference->init_point;
  }

}