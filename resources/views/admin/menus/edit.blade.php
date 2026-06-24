@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center text-sm text-stone-500 hover:text-stone-700 dark:text-stone-400 dark:hover:text-stone-200 mb-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Menu
        </a>
        <h1 class="text-3xl font-bold text-stone-800 dark:text-stone-100">Edit Menu</h1>
        <p class="text-stone-500 dark:text-stone-400 mt-1">Perbarui informasi menu</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-stone-900 rounded-lg shadow-sm border border-stone-200 dark:border-stone-800 p-6">
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                    Nama Menu <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $menu->name) }}" required
                    class="w-full px-4 py-2 border border-stone-300 dark:border-stone-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-stone-800 dark:text-stone-100"
                    placeholder="Contoh: Cappuccino, Nasi Goreng">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category_id" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id" required
                    class="w-full px-4 py-2 border border-stone-300 dark:border-stone-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-stone-800 dark:text-stone-100">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-6">
                <label for="price" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                    Harga (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" id="price" name="price" value="{{ old('price', $menu->price) }}" required min="0" step="1000"
                    class="w-full px-4 py-2 border border-stone-300 dark:border-stone-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-stone-800 dark:text-stone-100"
                    placeholder="25000">
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border border-stone-300 dark:border-stone-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-stone-800 dark:text-stone-100"
                    placeholder="Deskripsi singkat tentang menu ini...">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                    Gambar Menu
                </label>
                
                <div class="relative w-full h-48 sm:h-56 rounded-2xl overflow-hidden border-2 border-stone-300 dark:border-stone-600 border-dashed hover:border-amber-500 transition-colors group bg-stone-50 dark:bg-stone-800/50">
                    
                    <!-- Upload State -->
                    <div id="upload-state" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none {{ $menu->image ? 'hidden' : '' }}">
                        <svg class="mx-auto h-12 w-12 text-stone-400 group-hover:text-amber-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-stone-600 dark:text-stone-400">
                            <span class="font-medium text-amber-600">Pilih gambar baru</span> atau drag & drop
                        </p>
                        <p class="mt-1 text-xs text-stone-500">PNG, JPG, WEBP hingga 2MB</p>
                    </div>

                    <!-- Preview State -->
                    <div id="preview-state" class="absolute inset-0 bg-white dark:bg-stone-900 z-10 {{ $menu->image ? '' : 'hidden' }}">
                        <img id="image-preview" src="{{ $menu->image ? (str_starts_with($menu->image, 'http') ? $menu->image : asset('storage/' . $menu->image)) : '#' }}" alt="Preview" class="w-full h-full object-contain p-4">
                        
                        <!-- Overlay controls -->
                        <div class="absolute inset-0 bg-stone-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3 backdrop-blur-[2px]">
                            <button type="button" id="btn-change-image" class="px-5 py-2.5 bg-white text-stone-900 rounded-xl text-xs font-bold uppercase tracking-widest shadow-xl hover:scale-105 transition-transform border-2 border-stone-900">
                                Ganti
                            </button>
                            <button type="button" id="btn-remove-image" class="px-5 py-2.5 bg-red-500 text-white rounded-xl text-xs font-bold uppercase tracking-widest shadow-xl hover:scale-105 hover:bg-red-600 transition-transform border-2 border-red-500">
                                Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Input -->
                    <input id="image" name="image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50 {{ $menu->image ? 'hidden' : '' }}" accept="image/*">
                    <input type="hidden" name="remove_image" id="remove_image" value="0">
                </div>
                <p class="text-xs text-amber-600 dark:text-amber-400 mt-2">Biarkan kosong untuk menyimpan gambar saat ini</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Availability -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', $menu->is_available) ? 'checked' : '' }}
                        class="w-4 h-4 text-amber-600 bg-stone-100 border-stone-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-stone-800 focus:ring-2 dark:bg-stone-700 dark:border-stone-600">
                    <label for="is_available" class="ml-2 text-sm font-medium text-stone-700 dark:text-stone-300">
                        Tersedia untuk dipesan
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-3 pt-4 border-t border-stone-200 dark:border-stone-700">
                <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                    Perbarui Menu
                </button>
                <a href="{{ route('admin.menus.index') }}" class="flex-1 bg-stone-200 hover:bg-stone-300 dark:bg-stone-700 dark:hover:bg-stone-600 text-stone-700 dark:text-stone-200 font-medium py-2.5 px-4 rounded-lg transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const imageInput = document.getElementById('image');
    const uploadState = document.getElementById('upload-state');
    const previewState = document.getElementById('preview-state');
    const imagePreview = document.getElementById('image-preview');
    const btnChange = document.getElementById('btn-change-image');
    const btnRemove = document.getElementById('btn-remove-image');
    
    const originalImage = "{{ $menu->image ? (str_starts_with($menu->image, 'http') ? $menu->image : asset('storage/' . $menu->image)) : '' }}";

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                uploadState.classList.add('hidden');
                previewState.classList.remove('hidden');
                
                // Hide input so buttons are clickable
                imageInput.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    btnChange.addEventListener('click', function() {
        imageInput.click();
    });

    btnRemove.addEventListener('click', function() {
        imageInput.value = '';
        
        if (originalImage) {
            imagePreview.src = originalImage;
            // Keep preview state visible, just reverted
            imageInput.classList.add('hidden');
        } else {
            imagePreview.src = '#';
            uploadState.classList.remove('hidden');
            previewState.classList.add('hidden');
            
            // Show input again
            imageInput.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection
