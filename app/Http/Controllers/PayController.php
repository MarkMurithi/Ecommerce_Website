<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpesa;
use App\Models\Cart;
use App\Models\Product;
use DB;


class PayController extends Controller
{
    public function stk()
    {
        $mpesa= new \Safaricom\Mpesa\Mpesa();
        $BusinessShortCode = '174379';
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = '1';
        $PartyA = '0714027134';
        $PartyB = '0714027134';
        $CallBackURL = 'https://yourdomain.com/mpesa/confirmation';
        $AccountReference = 'AccountReference';
        $TransactionDesc = 'TransactionDesc';
        $Remarks = 'Remarks';

        $stkPushSimulation=$mpesa->STKPushSimulation(
        $BusinessShortCode, 
        $LipaNaMpesaPasskey, 
        $TransactionType, 
        $Amount, 
        $PartyA, 
        $PartyB, 
        $PhoneNumber, 
        $CallBackURL, 
        $AccountReference, 
        $TransactionDesc, 
        $Remarks
        ); 
        dd($stkPushSimulation);
    }

    public function payment()
    {
        $cart = Cart::where('user_id',auth()->user()->id)->where('order_id',null)->get()->toArray();
        
        $data = [];
        
        // return $cart;
        $data['items'] = array_map(function ($item) use($cart) {
            $name=Product::where('id',$item['product_id'])->pluck('title');
            return [
                'name' =>$name ,
                'price' => $item['price'],
                'desc'  => 'Thank you for using Mpesa',
                'qty' => $item['quantity']
            ];
        }, $cart);

       
    }

}
