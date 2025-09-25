<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-blue-900 shadow sm:rounded-lg p-8">

                <!-- Statistik Cepat -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-600 font-extrabold text-white rounded-xl shadow p-6 flex flex-col items-center">
                        <h4 class="text-lg font-semibold mb-2">Total Dokumen</h4>
                        <p class="text-3xl font-bold">{{ $totalDocuments }}</p>
                    </div>
                    <div class="bg-red-500 font-extrabold text-white rounded-xl shadow p-6 flex flex-col items-center">
                        <h4 class="text-lg font-semibold mb-2">Hampir Expired</h4>
                        <p class="text-3xl font-bold">{{ $almostExpired->count() }}</p>
                    </div>
                    <div class="bg-orange-600 font-extrabold text-white rounded-xl shadow p-6 flex flex-col items-center">
                        <h4 class="text-lg font-semibold mb-4">Upload Baru</h4>
                        <a href="{{ route('documents.create') }}"
                            class="px-4 py-2 bg-white text-orange-700 rounded-lg shadow hover:bg-gray-100 transition">
                            Upload
                        </a>
                    </div>
                </div>

                <!-- Dokumen Per Kategori -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">📂 Dokumen Per Kategori</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($documentsPerCategory as $cat => $count)
                            <li class="bg-gray-100 dark:bg-blue-500 rounded-lg px-4 py-3 flex justify-between">
                                <!-- Ubah bagian span jadi link -->
                                <a href="{{ route('documents.byCategory', $cat) }}"
                                    class="font-bold text-grey-600 hover:underline">
                                    {{ $cat }}
                                </a>
                                <span class="text-sm text-gray-600 dark:text-gray-100 font-bold">{{ $count }}
                                    dokumen</span>
                            </li>
                        @endforeach
                    </ul>

                </div>

                <!-- Daftar Dokumen dengan Expired -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">📑 Semua Dokumen & Tanggal
                        Expired</h3>
                    <table class="w-full border-collapse bg-white dark:bg-grey-100 shadow rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-900 dark:bg-blue-500 text-gray-700 dark:text-gray-900">
                                <th class="px-4 py-2 text-left">Judul</th>
                                <th class="px-4 py-2 text-left">Kategori</th>
                                <th class="px-4 py-2 text-left">Pihak Terkait</th>
                                <th class="px-4 py-2 text-left">Tanggal Upload</th>
                                <th class="px-4 py-2 text-left">Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $doc)
                                <tr class="border-b dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $doc->title }}</td>
                                    <td class="px-4 py-2">{{ $doc->category }}</td>
                                    <td class="px-4 py-2">{{ $doc->related_party ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $doc->date }}</td>
                                    <td
                                        class="px-4 py-2
                                        @if ($doc->expired_date <= now()) text-red-600 font-semibold
                                        @elseif($doc->expired_date <= now()->addDays(30)) text-red-600 font-semibold
                                        @else text-green-600 font-semibold @endif">
                                        {{ $doc->expired_date }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Notifikasi -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">🔔 Notifikasi Dokumen Hampir
                        Expired</h3>
                    @if ($almostExpired->count() > 0)
                        <ul class="space-y-3">
                            @foreach ($almostExpired as $doc)
                                <li class="p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded">
                                    <span class="font-semibold">{{ $doc->title }}</span>
                                    <span class="ml-2 text-sm">(Expired: {{ $doc->expired_date }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600 dark:text-gray-300">✅ Tidak ada dokumen hampir expired.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
