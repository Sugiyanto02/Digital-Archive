<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Document::query();

        // Search berdasarkan judul atau pihak terkait
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('related_party', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest()->paginate(10);

        // Ambil semua kategori unik untuk dropdown filter
        $categories = Document::select('category')->distinct()->pluck('category');

        //total document
        $totalDocuments = Document::count();

        //dokumen per kategori
        $documentsPerCategory = Document::select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')    //key=>value (category=>total)
            ->toArray();

        //dokumen hampir expired 30 hari
        $almostExpired = Document::whereNotNull('expired_date')
            ->whereDate('expired_date', '<=', Carbon::now()->addDays(30))
            ->get();

        return view('documents.index', compact('documents', 'categories', 'totalDocuments', 'documentsPerCategory', 'almostExpired'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'related_party' => 'nullable|string|max:255',
            'date' => 'required|date',
            'expired_duration' => 'required|integer', // ambil dari select
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        // Hitung tanggal expired otomatis
        $expiredDate = Carbon::parse($request->date)->addMonths($request->expired_duration);

        Document::create([
            'title' => $request->title,
            'category' => $request->category,
            'related_party' => $request->related_party,
            'date' => $request->date,
            'expired_date' => $expiredDate, // simpan hasil hitungan
            'file_path' => $path,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupload!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Download the specified document file.
     */
    public function download(Document $document)
    {
        return Storage::disk('public')->download($document->file_path);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function byCategory($category)
    {
        // Ambil semua dokumen berdasarkan kategori
        $documents = Document::where('category', $category)->get();

        return view('documents.by-category', compact('category', 'documents'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'nik' => 'required|string',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'related_party' => 'nullable|string|max:255',
            'date' => 'required|date',
            'expired_duration' => 'required|integer',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        // Jika ada file baru, replace file lama
        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $path = $request->file('file')->store('documents', 'public');
            $document->file_path = $path;
        }

        // Hitung ulang tanggal expired
        $expiredDate = Carbon::parse($request->date)->addMonths($request->expired_duration);

        $document->update([
            'title' => $request->title,
            'category' => $request->category,
            'related_party' => $request->related_party,
            'date' => $request->date,
            'expired_date' => $expiredDate,
            'file_path' => $document->file_path,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}
