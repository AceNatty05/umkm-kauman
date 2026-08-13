<x-app-layout>
    <x-slot name="title">Edit Tutorial - Admin</x-slot>

    <!-- Trix Editor CSS -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Tutorial</h1>
                <p class="text-sm text-gray-500 mt-1">Perbarui data tutorial yang sudah ada.</p>
            </div>
            <a href="{{ route('manage.tutorials.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                Batal & Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 sm:p-8">
            <form action="{{ route('manage.tutorials.update', $tutorial->slug) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Tutorial <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $tutorial->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kauman-primary focus:ring-kauman-primary sm:text-sm">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Target Role -->
                    <div>
                        <label for="target_role" class="block text-sm font-medium text-gray-700">Akses / Target Audiens <span class="text-red-500">*</span></label>
                        <select name="target_role" id="target_role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kauman-primary focus:ring-kauman-primary sm:text-sm">
                            <option value="all" {{ old('target_role', $tutorial->target_role) == 'all' ? 'selected' : '' }}>Semua Orang (Umum)</option>
                            <option value="user" {{ old('target_role', $tutorial->target_role) == 'user' ? 'selected' : '' }}>Pelaku UMKM (Harus Login)</option>
                            <option value="admin" {{ old('target_role', $tutorial->target_role) == 'admin' ? 'selected' : '' }}>Khusus Admin</option>
                        </select>
                        @error('target_role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Tentukan siapa yang dapat melihat tutorial ini di daftar maupun detailnya.</p>
                    </div>

                    <!-- Video URL -->
                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700">URL Video (Opsional)</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $tutorial->video_url) }}" placeholder="Contoh: https://www.youtube.com/watch?v=..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kauman-primary focus:ring-kauman-primary sm:text-sm">
                        @error('video_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Link video YouTube yang akan di-embed di bagian atas konten.</p>
                    </div>

                    <!-- Konten -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Tutorial</label>
                        <input id="x_content" type="hidden" name="content" value="{{ old('content', $tutorial->content) }}">
                        <trix-editor input="x_content" class="trix-content min-h-[300px] border-gray-300 shadow-sm focus:ring-kauman-primary focus:border-kauman-primary rounded-md"></trix-editor>
                        @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_published" name="is_published" type="checkbox" value="1" {{ old('is_published', $tutorial->is_published) ? 'checked' : '' }} class="focus:ring-kauman-primary h-4 w-4 text-kauman-primary border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_published" class="font-medium text-gray-700">Publikasikan</label>
                            <p class="text-gray-500">Jika dicentang, tutorial akan langsung dapat dilihat sesuai akses.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-kauman-primary hover:bg-kauman-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kauman-primary transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Trix Editor JS -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener("trix-attachment-add", function(event) {
            if (event.attachment.file) {
                uploadFileAttachment(event.attachment);
            }
        });

        function uploadFileAttachment(attachment) {
            var file = attachment.file;
            var formData = new FormData();
            formData.append("file", file);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ route('manage.tutorials.upload-image') }}", true);
            xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

            xhr.upload.onprogress = function(event) {
                var progress = event.loaded / event.total * 100;
                attachment.setUploadProgress(progress);
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    attachment.setAttributes({
                        url: response.url,
                        href: response.url
                    });
                } else {
                    console.error("Upload failed");
                }
            };

            xhr.send(formData);
        }
    </script>
</x-app-layout>
