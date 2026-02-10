@extends('admin.layouts.app')
@section('title', 'Backups')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold dark:text-white">Backups</h1>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Criar Backup</button>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
        <p class="text-center text-gray-500">Nenhum backup recente.</p>
    </div>
</div>
@endsection
