<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Bagian Header Tabel & Tombol Tambah --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Pengguna</h3>
                        <a href="{{ url('users/create') }}" style="background: blue !important; color: white !important; padding: 10px; display: block; width: 120px; text-align: center; border-radius: 5px;">
                            Tambah User
                        </a>
                    </div>                 

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border border-gray-200 px-4 py-2 text-left">No</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Nama</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Email</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Role</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2 text-center">{{ $users->firstItem() + $key }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                                    <td class="border border-gray-200 px-4 py-2 capitalize">{{ $user->role }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            {{-- Tombol Edit Kuning --}}
                                            <a href="{{ url('users/'.$user->id.'/edit') }}" style="background: orange !important; color: white !important; padding: 5px 10px; border-radius: 3px; text-decoration: none; display: inline-block; font-size: 14px; font-weight: bold;">
                                                Edit
                                            </a>
                                            {{-- Tombol Hapus Merah (Disesuaikan agar ukurannya sama dengan Manajemen Barang) --}}
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white rounded font-bold hover:bg-red-700" style="background-color: #dc2626 !important; padding: 5px 10px; border: none; font-size: 14px;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>