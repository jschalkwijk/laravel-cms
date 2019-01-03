<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use JornSchalkwijk\LaravelCMS\Models\Cart;
use JornSchalkwijk\LaravelCMS\Models\Order;

//PayPal
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException as PPConnectionException;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;



class PaymentController extends Controller
{
    protected $_api_context;
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = Config::get('paypal');
//        print_r($paypal_conf);
//        die('error');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function index($hash)
    {
//        if($this->order->refresh()) {
//            return back();
//        }
        $order = Order::where('hash',$hash)->first();
//        print_r($order);
//        die('rape');
        return view('JornSchalkwijk\LaravelCMS::admin.payment.payment')->with(['order' => $order,'template' => $this->adminTemplate()]);

    }
    public function payWithPaypal(Request $request,$hash)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
//        foreach ($this->order->items as $item ){
//            $item_1 = new Item();
//            $item_1->setName($item->name) /** item name **/
//                   ->setCurrency('EURO')
//                   ->setQuantity($item->quantity)
//                   ->setPrice($item->totalPrice); /** unit price **/
//        }
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
               ->setCurrency('EUR')
               ->setQuantity(1)
               ->setPrice(100); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('EUR')
               ->setTotal(100);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url()->route('payment.paypalstatus',$hash)) /** Specify return URL **/
                      ->setCancelUrl(url()->route('order.payment',$hash));
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (PPConnectionException $ex) {
            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');
                return redirect()->route('order.index');
            } else {
                Session::put('error', 'Some error occur, sorry for inconvenience');
                return redirect()->route('order.index');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return redirect()->away($redirect_url);
        }
        Session::put('error', 'Unknown error occurred');
        return redirect()->route('paywithpaypal');
    }

    public function getPaymentStatus(Request $r,$hash)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty($r->get('PayerID')) || empty($r->get('token'))) {
            Session::put('error', 'Payment failed');
            return redirect()->route('order.payment',$hash);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($r->get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            Session::put('success', 'Payment success');
            Order::where('hash',$hash)->first()->update(['paid' => true]);
        } else {
            Session::put('error', 'Payment failed');
        }
        return redirect()->route('order.payment',$hash);
    }
}
