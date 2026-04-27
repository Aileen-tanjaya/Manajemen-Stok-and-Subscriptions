<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Stok</label>
                        <input type="number" name="stok" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Harga</label>
                        <input type="number" name="harga" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>