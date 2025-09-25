<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dokumen Kategori: {{ $category }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-blue-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($documents->count() > 0)
                    <table class="w-full border-collapse bg-white dark:bg-gray-100 shadow rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-blue-500 text-gray-900 dark:text-gray-900">
                                <th class="px-4 py-2 text-left">Judul</th>
                                <th class="px-4 py-2 text-left">Pihak Terkait</th>
                                <th class="px-4 py-2 text-left">Tanggal Upload</th>
                                <th class="px-4 py-2 text-left">Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $doc)
                                <tr class="border-b dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $doc->title }}</td>
                                    <td class="px-4 py-2">{{ $doc->related_party ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $doc->date }}</td>
                                    <td class="px-4 py-2
                                        @if($doc->expired_date <= now()) text-red-600 font-semibold
                                        @elseif($doc->expired_date <= now()->addDays(30)) text-red-600 font-semibold
                                        @else text-green-600 font-semibold
                                        @endif">
                                        {{ $doc->expired_date }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600 dark:text-gray-300">Tidak ada dokumen di kategori ini.</p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="text-blue-100 hover:underline, font-bold">← Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
