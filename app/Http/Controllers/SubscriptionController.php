<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function plans()
    {
        $plans = Plan::all();

        return view('subscriptions.plans', compact('plans'));
    }

    public function checkout(Plan $plan, Request $request)
    {
        $activeSubscription = auth()->user()->activeSubscription()->first();

        if ($activeSubscription) {
            return redirect()
                ->route('subscriptions.my')
                ->with('error', 'Anda masih memiliki subscription aktif.');
        }

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $subscription = Subscription::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5)),
            'amount' => $plan->price,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('subscriptions.payment', $subscription);
    }

    public function payment(Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403, 'Anda tidak boleh mengakses invoice milik user lain.');
        }

        return view('subscriptions.payment', compact('subscription'));
    }

    public function pay(Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403, 'Anda tidak boleh membayar invoice milik user lain.');
        }

        if ($subscription->status === 'paid') {
            return redirect()
                ->route('subscriptions.my')
                ->with('error', 'Invoice ini sudah dibayar.');
        }

        $subscription->update([
            'status' => 'paid',
            'paid_at' => now(),
            'started_at' => now(),
            'expired_at' => now()->addDays($subscription->plan->duration_days),
        ]);

        return redirect()
            ->route('subscriptions.my')
            ->with('success', 'Pembayaran berhasil disimulasikan. Membership Anda aktif.');
    }

    public function my()
    {
        $subscriptions = Subscription::with('plan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('subscriptions.my', compact('subscriptions'));
    }

    public function status()
    {
        $subscription = auth()->user()
            ->activeSubscription()
            ->with('plan')
            ->first();

        return view('subscriptions.status', compact('subscription'));
    }

    public function premiumContent()
    {
        if (!auth()->user()->isPremium()) {
            abort(403, 'Anda harus menjadi Premium Member untuk mengakses konten ini.');
        }

        return view('subscriptions.premium-content');
    }
}