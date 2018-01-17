<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Order;
use Request;
use App\Product;
use Redirect;
use Mail;
use Auth;


/**
 * Class OrdersController
 * @package App\Http\Controllers
 */
class OrdersController extends Controller
{


    public function __construct()
    {
        $this->middleware('redirects');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdd()
    {
        $request = Request::all();
        unset($request['_token']);

        $order = Order::getInstance($request['type']);
        $result = $order->add($request);

        if (!$result) {
            return Redirect::back()->with('emptyCartError', 1);
        }

        if (!Auth::check() || Auth::user()->role == 'retail') {
            $emails = Consts::EMAILS;

            if ($request['type']) { // быстрый
                Mail::send('emails.orderFast', ['name' => $request['name'], 'phone' => $request['phone']], function ($message) use ($emails) {
                    foreach ($emails as $email) {
                        $message->to($email, 'Kaleydoskop')->subject('На сайте новый заказ');
                    }
                });
            } else {
                Mail::send('emails.order', ['name' => $request['name'], 'phone' => $request['phone'], 'email' => $request['email'], 'dt' => $request['delivery_dt']], function ($message) use ($emails) {
                    foreach ($emails as $email) {
                        $message->to($email, 'Kaleydoskop')->subject('На сайте новый заказ');
                    }
                });
            }
        }

        if (isset($request['email'])) {
            $email = $request['email'];
            $order = Order::getLast();

            $order = Order::changePaymentAndDelivery($order);
            $products = Order::getItemProducts($order->id);
            $namesCount = Order::getNamesCount($order->id);


            $showDeliveryDt = $order->delivery_dt != '0000-00-00 00:00:00';

            Mail::send('print.order', ['order' => $order, 'products' => $products, 'namesCount' => $namesCount, 'showDeliveryDt' => $showDeliveryDt], function ($message) use ($email) {
                $message->to($email, 'Калейдоскоп Вышивки')->subject('Ваш заказ на сайте Калейдоскоп Вышивки');
            });
        }


        return Redirect::to('/')->with('orderSuccess', true);
    }

}