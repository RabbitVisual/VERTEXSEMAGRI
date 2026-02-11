@extends('admin.layouts.admin')

@section('title', 'Editar Agendamento - Agricultura')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans italic">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans italic text-xs uppercase">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans italic tracking-tighter uppercase uppercase">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg font-sans italic text-xs uppercase">
                    <x-icon name="calendar-pen" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans italic text-xs uppercase" style="duotone" />
                </div>
                <span>Reprogramar Evento</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic text-xs uppercase">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="hover:text-amber-600 font-sans italic text-xs uppercase">Eventos</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic text-xs uppercase" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans italic text-xs uppercase">{{ $evento->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans italic text-xs uppercase">
            <a href="{{ route('admin.programas-agricultura.eventos.show', $evento->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic text-xs uppercase">
                <x-icon name="eye" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Visualizar
            </a>
            <a href="{{ route('admin.programas-agricultura.eventos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-colors font-sans italic text-xs uppercase">
                <x-icon name="arrow-left" class="w-4 h-4 font-sans italic text-xs uppercase" style="duotone" />
                Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-100 text-red-800 rounded-2xl flex items-start gap-3 shadow-sm animate-shake font-sans italic text-xs uppercase">
        <x-icon name="circle-exclamation" class="w-5 h-5 text-red-500 mt-1 font-sans italic text-xs uppercase" style="duotone" />
        <div class="font-sans italic text-xs uppercase text-xs uppercase">
            <p class="font-black text-[10px] uppercase tracking-widest mb-1 italic text-xs uppercase">Consistir Dados do Agendamento:</p>
            <ul class="list-disc list-inside text-[11px] font-bold italic tracking-tight font-sans italic text-xs uppercase text-xs uppercase">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.programas-agricultura.eventos.update', $evento->id) }}" method="POST" class="font-sans italic text-xs uppercase">
        @csrf
        @method('PUT')
        @include('programasagricultura::admin.eventos._form', ['evento' => $evento])

        <div class="mt-8 flex justify-end font-sans italic text-xs uppercase">
            <button type="submit" class="inline-flex items-center gap-3 px-8 py-4 bg-slate-900 dark:bg-blue-600 text-white rounded-2xl hover:bg-slate-800 transition-all shadow-xl active:scale-95 font-black uppercase tracking-widest text-xs italic font-sans italic text-xs uppercase">
                <x-icon name="floppy-disk" class="w-5 h-5 font-sans italic text-xs uppercase" style="duotone" />
                Consolidar Reprogramação
            </button>
        </div>
    </form>
</div>
@endsection
