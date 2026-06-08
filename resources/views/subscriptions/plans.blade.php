<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pilih Paket Membership
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="text-xl font-bold">{{ $plan->name }}</h3>

                        <p class="mt-2 text-gray-600">
                            {{ $plan->description }}
                        </p>

                        <p class="mt-4 text-2xl font-bold">
                            Rp {{ number_format($plan->price, 0, ',', '.') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Durasi: {{ $plan->duration_days }} hari
                        </p>

                        <form action="{{ route('subscriptions.checkout', $plan) }}" method="POST" class="mt-4">
                            @csrf

                            <label class="block mb-2 font-medium">Metode Pembayaran</label>
                            <select name="payment_method" class="w-full border rounded px-3 py-2 mb-3">
                                <option value="QRIS">QRIS</option>
                                <option value="Virtual Account">Virtual Account</option>
                                <option value="E-Wallet">E-Wallet</option>
                            </select>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Checkout
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>