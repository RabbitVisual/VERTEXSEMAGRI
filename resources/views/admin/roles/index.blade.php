@extends('admin.layouts.app')
@section('title', 'Papéis e Permissões')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold dark:text-white">Papéis de Usuário</h1>
        <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Novo Papel</a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Permissões</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($roles as $role)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white font-bold">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $role->permissions->count() }} permissões
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Nenhum papel encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
