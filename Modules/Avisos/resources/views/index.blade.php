<x-avisos::layouts.master>

    <!-- Navbar simples para navegação -->
    <div class="bg-white dark:bg-slate-800 shadow-sm border-b border-gray-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <x-icon module="avisos" name="bell" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Central de Avisos</span>
                </div>
                <nav class="flex gap-4">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Home
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Fique por dentro das novidades
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Confira nossos últimos comunicados, atualizações e avisos importantes.
                </p>
            </div>

            @if(isset($avisos) && $avisos->count() > 0)
                <div class="space-y-8">
                    @foreach($avisos as $aviso)
                        @include('avisos::components.banner', ['aviso' => $aviso])
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $avisos->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="bg-gray-100 dark:bg-slate-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-icon name="bell-slash" class="w-8 h-8 text-gray-400 dark:text-gray-500" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum aviso encontrado</h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        Não há avisos ativos no momento. Volte mais tarde!
                    </p>
                </div>
            @endif
        </div>
    </div>

</x-avisos::layouts.master>
