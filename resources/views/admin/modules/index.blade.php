@extends('admin.layouts.app')
@section('title', 'Módulos')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold dark:text-white">Módulos do Sistema</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($modules as $module)
            <div class="bg-white dark:bg-gray-800 rounded shadow p-6 border-l-4 {{ $module['enabled'] ? 'border-green-500' : 'border-gray-500' }}">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-bold dark:text-white">{{ $module['name'] }}</h3>
                    <span class="px-2 py-1 text-xs rounded {{ $module['enabled'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $module['enabled'] ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ $module['description'] }}</p>
                <div class="flex justify-end">
                    @if($module['enabled'])
                        <form action="{{ route('admin.modules.disable', $module['name']) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Desabilitar</button>
                        </form>
                    @else
                        <form action="{{ route('admin.modules.enable', $module['name']) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">Habilitar</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">Nenhum módulo encontrado.</div>
        @endforelse
    </div>
</div>
@endsection
