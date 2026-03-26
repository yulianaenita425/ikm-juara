@extends('layouts.admin')

@section('title', 'Manajemen Statistik')

@section('content')
<div class="max-w-6xl">
    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="mb-8 p-5 bg-emerald-500 text-white rounded-[2rem] shadow-xl shadow-emerald-200 flex items-center gap-4 animate-bounce">
        <div class="bg-white/20 p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <span class="font-bold tracking-wide">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Card Utama --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
        <div class="flex justify-between items-start mb-10">
            <div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Update Data IKM Per Kecamatan</h3>
                <p class="text-slate-400 text-sm">Input jumlah IKM secara manual untuk memperbarui grafik dashboard.</p>
            </div>
            <div class="bg-indigo-50 px-4 py-2 rounded-xl text-indigo-600 font-bold text-xs uppercase tracking-tighter">
                Live Preview Mode
            </div>
        </div>

<form action="{{ route('admin.statistik.update') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        @foreach(DB::table('statistik_kecamatan')->get() as $item)
        <div class="space-y-4">
            <label class="flex items-center gap-2 font-bold text-slate-700 text-sm">
                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                Kecamatan {{ $item->kecamatan }}
            </label>
            <div class="relative group">
                <input type="number" 
                       name="stats[{{ $item->id }}]" 
                       value="{{ $item->jumlah_ikm }}" 
                       class="w-full p-6 bg-slate-50 border-2 border-transparent rounded-3xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 outline-none font-black text-3xl text-indigo-600 transition-all duration-300 group-hover:bg-slate-100"
                       required>
                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest group-focus-within:text-indigo-200 transition-colors">Unit</span>
            </div>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider pl-1">
                DIPERBARUI: {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
            </p>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
            SIMPAN PERUBAHAN
        </button>
    </div>
</form>
    </div>
</div>
@endsection