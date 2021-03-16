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
    SDK::setAccessToken(
          config("payment-methods.mercadopago.access_token")
     );
    // SDK::setClientSecret(
    //       config("payment-methods.mercadopago.secret")
    //  );
  }

  public function setupPaymentAndGetRedirectURL(Order $order): string
  {
     # Create a preference object
     $preference = new Preference();
    // dd($order);
    
    


      # Create an item object
      // $items = Array();

      foreach ($order->productos as $value) {
        $item = new Item();
        $item->id = $value->id;
        $item->title = $value->name;
        $item->quantity = $value->pivot->quantity;
        $item->currency_id = 'UYU';
        $item->unit_price = $this->calculoDesc($value->pivot->price, $value->pivot->discount_product, $value->pivot->discount_user );
        $item->picture_url = asset("storage/".$value->picture);

        $items[] = $item;
      }
      
        // $item = new Item();
        // $item->id = 12456;
        // $item->title = "NOMBRE";
        // $item->quantity = 1;
        // $item->currency_id = 'UYU';
        // $item->unit_price = 5200;
        // $item->picture_url = asset("storage/");

    

      # Create a payer object
      $payer = new Payer();
      $payer->email = $order->email;
      $payer->name = $order->name;
      $payer->surname = $order->lastname;
      $payer->phone = array(
        "area_code" => "598",
        "number" => $order->phone
      );
      
      $payer->identification = array(
        "type" => "CI",
        "number" => $order->ci
      );
      

      # Setting preference properties
      $preference->items = $items;
      $preference->payer = $payer;
      

      # Save External Reference
      $preference->external_reference = $order->id;
      $preference->back_urls = [
        "success" => env('MP_URL_SUCCESS'),
        "pending" => env('MP_URL_PENDING'),
        "failure" => env('MP_URL_FAILURE'),
      ];
        
      $preference->auto_return = "all";
      $preference->notification_url = env('MP_URL_NOTIFICACION', 'https://api.nuevaerauruguay.com/api/notification-cobro');
      // $preference->notification_url = 'http://mvdcreativo.servehttp.com/apiNuevaEra/public/api/notification-cobro';
      # Save and POST preference
      // dd($preference);
      $preference->save();

      if (config('payment-methods.use_sandbox')) {
        return $preference->sandbox_init_point;
      }

      return $preference->init_point;
  }


  private function calculoDesc($price , $descuentoProduct, $dMayorista = 0){
    $descuentoP = ($price * $descuentoProduct) / 100;
    $pricePublico = $price - $descuentoP;
  
    if($dMayorista){
      $descuentMayorista = ($pricePublico * $dMayorista) / 100;
      return $pricePublico - $descuentMayorista;
    }
  
    return $pricePublico;
  }
}