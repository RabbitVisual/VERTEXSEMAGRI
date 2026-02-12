@extends('consulta.layouts.consulta')

@section('title', 'Notificações - Consulta')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="bell" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                </div>
                Notificações
            </h1>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">
                Acompanhe as atualizações e alertas do sistema.
            </p>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Título</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Mensagem</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($notifications as $notification)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors {{ $notification->read_at ? '' : 'bg-orange-50 dark:bg-orange-900/10' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full {{ $notification->read_at ? 'bg-gray-100 dark:bg-slate-700 text-gray-500' : 'bg-orange-100 dark:bg-orange-900/30 text-orange-600' }}">
                                        <x-icon name="{{ $notification->data['icon'] ?? 'bell' }}" class="w-4 h-4" />
                                    </span>
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $notification->data['title'] ?? 'Notificação' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">
                            {{ Str::limit($notification->data['message'] ?? '', 60) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('consulta.notificacoes.show', $notification->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-icon name="bell-slash" class="w-8 h-8 md:w-10 md:h-10 text-gray-400 dark:text-gray-500" />
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhuma notificação</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Você não tem novas notificações no momento.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($notifications, 'links'))
        <div class="bg-gray-50 dark:bg-slate-900/50 px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
