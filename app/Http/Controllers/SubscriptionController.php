<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Laravel\Cashier\Subscription;
use Stripe\Charge;

class SubscriptionController extends Controller
{
    public function subscribe()
    {
        return view('subscribe');
    }

    public function processSubscription(Request $request)
    {

        // dd($request->all());
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $token = $request->stripeToken;
        $customer = $stripe->customers->create(array(
            'source' => $request->stripeToken,
            'email' => auth()->user()->email,
            'name' => auth()->user()->first_name
        ));

        return $customer;
    }
    public function process()
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $charge = $stripe->charges->create([
            'amount' => 999999,
            'currency' => 'usd',
            'customer' => 'cus_Og4Wl3UQmPp5Hy',
        ]);
        return $charge;
    }
}
