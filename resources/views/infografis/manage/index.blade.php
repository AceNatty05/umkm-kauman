<x-app-layout>
    <x-slot name="title">Manajemen Infografis</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Infografis</h1>
            <a href="{{ route('manage.infografis.create') }}" class="bg-kauman-primary hover:bg-kauman-primary-dark text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                + Tambah Infografis
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($infografis as $info)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $info->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ is_array($info->foto) ? count($info->foto) : 0 }} Foto</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $info->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-3">
                                    <a href="{{ route('manage.infografis.edit', $info->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('manage.infografis.destroy', $info->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus infografis ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data infografis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $infografis->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
