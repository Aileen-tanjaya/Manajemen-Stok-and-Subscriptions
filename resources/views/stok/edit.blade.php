<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('stok.update', $stok->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- TAMBAHAN: Input Kode Barang --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $stok->kode_barang }}" class="w-full border rounded px-3 py-2 bg-gray-50" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $stok->nama_barang }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Satuan</label>
                        <select name="satuan" class="w-full border rounded px-3 py-2" required>
                            <option value="kg" {{ $stok->satuan == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="pcs" {{ $stok->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="liter" {{ $stok->satuan == 'liter' ? 'selected' : '' }}>liter</option>
                            <option value="bungkus" {{ $stok->satuan == 'bungkus' ? 'selected' : '' }}>bungkus</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Stok</label>
                        <input type="number" name="stok" value="{{ $stok->stok }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Harga</label>
                        <input type="number" name="harga" value="{{ $stok->harga }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end gap-2">
                        {{-- Tombol Batal --}}
                        <a href="{{ route('stok.index') }}" style="background: gray !important; color: white !important; padding: 8px 15px; border-radius: 5px; text-decoration: none;">
                            Batal
                        </a>
                        {{-- Tombol Update --}}
                        <button type="submit" style="background: orange !important; color: white !important; padding: 8px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                            Update Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>