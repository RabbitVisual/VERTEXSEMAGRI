@extends('admin.layouts.admin')

@section('title', 'Chat - Sessões')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Chat" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Gerenciar Chat</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Admin</a>
                <x-icon name="magnifying-glass" class="w-5 h-5" />
                            Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Sessões -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3">Visitante</th>
                        <th class="px-6 py-3">Tipo</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Atendente</th>
                        <th class="px-6 py-3">Última Mensagem</th>
                        <th class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700">
                        <td class="px-6 py-4">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $session->visitor_name ?? 'Sem nome' }}</div>
                                @if($session->visitor_cpf)
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    CPF: {{ \Modules\Chat\App\Helpers\CpfHelper::format($session->visitor_cpf) }}
                                </div>
                                @endif
                                @if($session->visitor_email)
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $session->visitor_email }}</div>
                                @endif
                                @if($session->visitor_phone)
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $session->visitor_phone }}</div>
                                @endif
                                @if($session->unread_count_user > 0)
                                <span class="inline-flex items-center px-2 py-0.5 mt-1 text-xs font-medium bg-red-100 text-red-800 rounded dark:bg-red-900/30 dark:text-red-400">
                                    {{ $session->unread_count_user }} não lidas
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded {{ $session->type === 'public' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                {{ $session->type === 'public' ? 'Público' : 'Interno' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded
                                {{ $session->status === 'waiting' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : '' }}
                                {{ $session->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $session->status === 'closed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                            ">
                                {{ $session->status_texto }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $session->assignedTo?->name ?? 'Sem atendente' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $session->lastMessage?->created_at?->diffForHumans() ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.chat.show', $session->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors">
                                <x-icon name="eye" class="w-5 h-5" />
                                Ver
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Nenhuma sessão encontrada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection

