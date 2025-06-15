@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<div class="text-center">
    <h2 class="text-2xl font-bold mb-4">Selamat Datang di ResikiApp!</h2>
    <p class="mb-6">Pesan jasa kebersihan rumah atau kantor dengan mudah.</p>
    <a href="{{ route('pesan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
        Pesan Sekarang
    </a>
</div>
@endsection
