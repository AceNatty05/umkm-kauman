<x-app-layout>
    <x-slot name="title">Tambah Infografis</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6 flex items-center space-x-4">
            <a href="{{ route('manage.infografis.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Infografis</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('manage.infografis.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Judul Infografis</label>
                        <input type="text" name="nama" id="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kauman-primary focus:ring-kauman-primary sm:text-sm" required>
                    </div>

                    <div class="mb-6">
                        <label for="foto" class="block text-sm font-medium text-gray-700">Foto (Bisa banyak)</label>
                        <input type="file" name="foto[]" id="foto" multiple accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-olive-50 file:text-kauman-primary hover:file:bg-olive-100" required>
                        <p class="mt-1 text-xs text-gray-500">Pilih satu atau beberapa foto untuk infografis ini.</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-kauman-primary hover:bg-kauman-primary-dark text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Simpan Infografis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
