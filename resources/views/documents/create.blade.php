<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Upload Dokumen
        </h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-blue-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
          @if ($errors->any())
            <div class="mb-4 text-red-600">
              <ul>
                @foreach ($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-100">Judul</label>
              <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-100">Kategori</label>
              <input type="text" name="category" value="{{ old('category') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-100">Pihak Terkait</label>
              <input type="text" name="related_party" value="{{ old('related_party') }}" class="mt-1 block w-full rounded-md border-gray-300">
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-100">Tanggal</label>
              <input type="date" name="date" value="{{ old('date') }}" class="mt-1 block w-full rounded-md border-gray-300">
            </div>

            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-100">Masa Berlaku</label>
                <select name="expired_duration" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value='1'>1 Bulan</option>
                    <option value="6">6 Bulan</option>
                    <option value="12">1 Tahun</option>
                    <option value="24">2 Tahun</option>
                </select>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-100">File (pdf/doc)</label>
              <input type="file" name="file" class="mt-1 block w-full" required>
            </div>

            <div>
              <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md">Upload</button>
            </div>
          </form>

        </div>
      </div>
    </div>
</x-app-layout>
