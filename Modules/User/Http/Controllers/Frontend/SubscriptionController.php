<?php

namespace Modules\User\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubscriptionController extends Controller
{

    public function index()
    {
        $subscriptions = auth()->user()->subscriptions->where('paid','paid')->load('package');
        $currentSubscription = auth()->user()->currentSubscription?->load('package');
        return view('user::frontend.subscriptions', compact('subscriptions', 'currentSubscription'));
    }

    public function update(Request $request)
    {
        return view('user::frontend.profile');
    }
}
