<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                
                {{-- Pastikan mengarah ke route stok.update dan variabel $stok --}}
                <form action="{{ route('stok.update', $stok->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- 1. KODE BARANG (Wajib ada agar tidak kosong saat update) --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $stok->kode_barang }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                        <small class="text-gray-500">*Kode barang tidak dapat diubah</small>
                    </div>

                    {{-- 2. NAMA BARANG --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $stok->nama_barang }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                    </div>

                    {{-- 3. SATUAN (INI YANG TADI HILANG) --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Satuan</label>
                        <select name="satuan" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                            <option value="pcs" {{ $stok->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="gram" {{ $stok->satuan == 'gram' ? 'selected' : '' }}>gram</option>
                            <option value="ml" {{ $stok->satuan == 'ml' ? 'selected' : '' }}>ml</option>
                            <option value="pouch" {{ $stok->satuan == 'pouch' ? 'selected' : '' }}>pouch</option>
                            <option value="sisir" {{ $stok->satuan == 'sisir' ? 'selected' : '' }}>sisir</option>
                        </select>
                    </div>

                    {{-- 4. STOK --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Stok</label>
                        <input type="number" name="stok" value="{{ $stok->stok }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                    </div>

                    {{-- 5. HARGA --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Harga</label>
                        <input type="number" name="harga" value="{{ $stok->harga }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('stok.index') }}" style="background: #6b7280 !important; color: white !important; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px;">
                            Batal
                        </a>
                        <button type="submit" style="background: #f59e0b !important; color: white !important; padding: 10px 20px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; font-size: 14px;">
                            Update Stok
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>