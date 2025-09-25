<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;   // <- sebelumnya kamu pakai Dashboard, harus Document
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
{
    $totalDocuments = Document::count();

    // dokumen per kategori
    $categories = Document::select('category')->distinct()->pluck('category');
    $documentsPerCategory = [];
    foreach ($categories as $cat) {
        $documentsPerCategory[$cat] = Document::where('category', $cat)->count();
    }

    // dokumen hampir expired (30 hari)
    $almostExpired = Document::whereNotNull('expired_date')
        ->whereDate('expired_date', '<=', Carbon::now()->addDays(30))
        ->get();

    // <-- TAMBAHKAN INI: data documents untuk tabel di view
    $documents = Document::latest()->paginate(10); // atau ->get() jika tidak mau pagination

    return view('documents.index', compact(
        'totalDocuments',
        'documentsPerCategory',
        'almostExpired',
        'documents'   // pastikan dikirim ke view
    ));
}

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
