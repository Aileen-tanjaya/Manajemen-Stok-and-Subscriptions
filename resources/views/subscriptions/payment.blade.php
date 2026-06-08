<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Simulasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <h3 class="text-lg font-bold mb-4">Invoice Pembayaran</h3>

                <table class="w-full border">
                    <tr>
                        <td class="border p-2 font-semibold">Invoice</td>
                        <td class="border p-2">{{ $subscription->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td class="border p-2 font-semibold">Paket</td>
                        <td class="border p-2">{{ $subscription->plan->name }}</td>
                    </tr>
                    <tr>
                        <td class="border p-2 font-semibold">Metode</td>
                        <td class="border p-2">{{ $subscription->payment_method }}</td>
                    </tr>
                    <tr>
                        <td class="border p-2 font-semibold">Total</td>
                        <td class="border p-2">
                            Rp {{ number_format($subscription->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border p-2 font-semibold">Status</td>
                        <td class="border p-2">{{ strtoupper($subscription->status) }}</td>
                    </tr>
                </table>

                <br>

                <form action="{{ route('subscriptions.pay', $subscription) }}" method="POST">
                    @csrf

                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        bayar sekarang
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>