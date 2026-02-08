@extends('admin.layouts.admin')

@section('title', 'Comentário - Blog Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Comentário
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.blog.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Blog</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.blog.comments.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Comentários</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900 dark:text-gray-100">Ver</li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.blog.comments.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Comment Details -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detalhes do Comentário</h3>

            <div class="space-y-6">
                <!-- Comment Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Conteúdo</label>
                    <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4 border border-gray-200 dark:border-slate-600">
                        <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $comment->content }}</p>
                    </div>
                </div>

                <!-- Comment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    @if($comment->status === 'approved')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Aprovado
                    </span>
                    @elseif($comment->status === 'pending')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pendente
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Rejeitado
                    </span>
                    @endif
                </div>

                <!-- Author Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Autor</label>
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4">
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $comment->author_display_name }}</p>
                            @if($comment->author_email)
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $comment->author_email }}</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Post Relacionado</label>
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4">
                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('admin.blog.show', $comment->post->id) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">
                                    {{ Str::limit($comment->post->title, 50) }}
                                </a>
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Status: {{ $comment->post->status === 'published' ? 'Publicado' : 'Rascunho' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Criação</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Última Atualização</label>
                        <p class="text-gray-900 dark:text-gray-100">{{ $comment->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ações Rápidas</h3>
            <div class="space-y-3">
                @if($comment->status === 'pending')
                <button onclick="approveComment({{ $comment->id }})"
                        class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aprovar Comentário
                </button>
                <button onclick="rejectComment({{ $comment->id }})"
                        class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Rejeitar Comentário
                </button>
                @endif

                <a href="{{ route('admin.blog.show', $comment->post->id) }}"
                   class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Ver Post Relacionado
                </a>

                <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este comentário? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Excluir Comentário
                    </button>
                </form>
            </div>
        </div>

        <!-- Comment Meta -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Metadados</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">ID:</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $comment->id }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">IP do Autor:</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $comment->author_ip ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">User Agent:</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $comment->user_agent ? Str::limit($comment->user_agent, 50) : 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function approveComment(commentId) {
    if (!confirm('Tem certeza que deseja aprovar este comentário?')) return;

    try {
        const response = await fetch(`/admin/blog/comentarios/${commentId}/aprovar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    } catch (error) {
        alert('Erro ao aprovar comentário: ' + error.message);
    }
}

async function rejectComment(commentId) {
    if (!confirm('Tem certeza que deseja rejeitar este comentário?')) return;

    try {
        const response = await fetch(`/admin/blog/comentarios/${commentId}/rejeitar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    } catch (error) {
        alert('Erro ao rejeitar comentário: ' + error.message);
    }
}
</script>
@endpush
