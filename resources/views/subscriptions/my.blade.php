<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Subscription Saya
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Invoice</th>
                        <th class="border p-2">Paket</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td class="border p-2">{{ $subscription->invoice_number }}</td>
                            <td class="border p-2">{{ $subscription->plan->name }}</td>
                            <td class="border p-2">
                                Rp {{ number_format($subscription->amount, 0, ',', '.') }}
                            </td>
                            <td class="border p-2">{{ $subscription->status }}</td>
                            <td class="border p-2">
                                {{ $subscription->expired_at ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>