@extends('layouts.app')

@section('content')
    <h1>Detail Dokumen</h1>

    <p><strong>Judul:</strong> {{ $document->title }}</p>
    <p><strong>Kategori:</strong> {{ $document->category }}</p>
    <p><strong>Pihak Terkait:</strong> {{ $document->related_party }}</p>
    <p><strong>Tanggal:</strong> {{ $document->date }}</p>

    <a href="{{ route('documents.download', $document->id) }}" class="btn btn-success">Download</a>
    <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
