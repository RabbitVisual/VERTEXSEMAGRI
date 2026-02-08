@extends('homepage::layouts.homepage')

@section('title', 'Programas Disponíveis - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.index') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                Voltar ao Portal do Agricultor
            </a>
            <h1 class="text-3xl md:text-4xl font-bold font-poppins text-gray-900 dark:text-white mb-2">
                Programas Disponíveis
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Conheça todos os programas governamentais disponíveis para agricultores familiares
            </p>
        </div>

        @if($programas->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($programas as $programa)
                    <a href="{{ route('portal.agricultor.programa', $programa->id) }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <x-icon name="handshake-angle" style="duotone" class="w-6 h-6 text-white" />
                            </div>
                            <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-full">
                                {{ $programa->tipo_texto }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold font-poppins text-gray-900 dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                            {{ $programa->nome }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                            {{ Str::limit($programa->descricao ?? 'Programa governamental para agricultores', 120) }}
                        </p>
                        <div class="flex items-center justify-between text-sm">
                            @if($programa->tem_vagas !== null)
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <x-icon name="users" style="duotone" class="w-4 h-4" />
                                    <span>{{ $programa->vagas_restantes ?? 'Ilimitado' }} vagas</span>
                                </div>
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Vagas ilimitadas</span>
                            @endif
                            <span class="text-amber-600 dark:text-amber-400 font-medium group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                Ver detalhes
                                <x-icon name="arrow-right" style="duotone" class="w-4 h-4" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="mt-8">
                {{ $programas->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-12 border border-gray-200 dark:border-gray-700 text-center">
                <x-icon name="clipboard-list" style="duotone" class="w-16 h-16 text-gray-400 mx-auto mb-4 opacity-50" />
                <h3 class="text-xl font-bold font-poppins text-gray-900 dark:text-white mb-2">Nenhum programa disponível</h3>
                <p class="text-gray-600 dark:text-gray-400">Não há programas disponíveis no momento. Tente novamente mais tarde.</p>
            </div>
        @endif
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
