<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\Input;
use Redirect;
use URL;
use smrklive\paypal\src\Provider\PayPalServiceProvider;

class PaymentController extends Controller
{
    private $_api_context;


    // public function __construct()
    // {
    //      /** PayPal api context **/
    //      $paypal_conf = \Config::get('paypal');
    //      $this->_api_context = new ApiContext(new OAuthTokenCredential(
    //          $paypal_conf['client_id'],
    //          $paypal_conf['secret'])
    //      );
    //      $this->_api_context->setConfig($paypal_conf['settings']);
    // }

    public function paypalview()
    {
        return view('paypal');
    }

    public function capture(Request $request)
    {

        if ($order = Order::where('trans_id', $request->trans_id)->first()) {
            $order_id = $order->id;
        } else {
            $order = new Order;
            $order->user_id ='3';
            $order->name = 'hmm';
            $order->trans_id = $request->trans_id;
            $order->payment = $request->amount . '$';
            $order->save();
            $order_id = $order->id;

            return 'Pyament has been done and your payment id is : ' . $order_id;
        }
    }
}
