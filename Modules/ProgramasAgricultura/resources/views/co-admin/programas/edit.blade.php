@extends('admin.layouts.admin')

@section('title', 'Editar Programa - Admin')

@section('content')
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="pencil" class="w-8 h-8 text-amber-600 dark:text-amber-500" />
                Editar Programa
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.programas.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Programas</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Editar</span>
            </nav>
        </div>
        <a href="{{ route('admin.programas.show', $programa->id) }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>
</div>

<x-admin.card title="Editar Programa">
    <form action="{{ route('admin.programas.update', $programa->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('programasagricultura::admin.programas._form', ['programa' => $programa])
    </form>
</x-admin.card>
@endsection

