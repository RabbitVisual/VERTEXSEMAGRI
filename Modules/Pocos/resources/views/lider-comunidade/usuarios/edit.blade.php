@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.usuarios.show', $usuario->id) }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Editar Perfil</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Atualize as informações de {{ $usuario->nome }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('lider-comunidade.usuarios.update', $usuario->id) }}" class="premium-card p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3">Preencher via CadÚnico (Vínculo Visual)</h2>
                <div class="relative">
                    <label for="pessoa_search" class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                        Busca no CadÚnico (Apenas para preenchimento)
                    </label>
                    <div class="relative group">
                        <input type="text" id="pessoa_search" name="pessoa_search"
                            placeholder="Digite nome, NIS ou CPF para buscar..."
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none group-focus-within:text-blue-500 text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        </div>
                    </div>
                    <div id="pessoa_results" class="hidden absolute z-10 w-full mt-2 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl shadow-2xl max-h-60 overflow-y-auto premium-card"></div>
                </div>
            </div>

            <div class="md:col-span-2 lg:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Nome Completo *</label>
                <input type="text" name="nome" value="{{ old('nome', $usuario->nome) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">CPF (Apenas Números)</label>
                <input type="text" name="cpf" value="{{ old('cpf', $usuario->cpf) }}" maxlength="11" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Telefone / WhatsApp</label>
                <input type="text" name="telefone" value="{{ old('telefone', $usuario->telefone) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">E-mail para Notificações</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div class="md:col-span-2 lg:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Endereço / Rua *</label>
                <input type="text" name="endereco" value="{{ old('endereco', $usuario->endereco) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Número</label>
                <input type="text" name="numero_casa" value="{{ old('numero_casa', $usuario->numero_casa) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Status do Registro *</label>
                <select name="status" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="ativo" {{ old('status', $usuario->status) === 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ old('status', $usuario->status) === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    <option value="suspenso" {{ old('status', $usuario->status) === 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Observações Internas</label>
                <textarea name="observacoes" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('observacoes', $usuario->observacoes) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-10 pt-8 border-t border-gray-100 dark:border-slate-800">
            <a href="{{ route('lider-comunidade.usuarios.show', $usuario->id) }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200 uppercase tracking-widest">
                Cancelar
            </a>
            <button type="submit" class="px-10 py-3 text-sm font-black text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let pessoaSearchTimeout;

function buscarPessoas() {
    const search = document.getElementById('pessoa_search').value;
    const resultsDiv = document.getElementById('pessoa_results');

    if (search.length < 3) {
        resultsDiv.classList.add('hidden');
        return;
    }

    clearTimeout(pessoaSearchTimeout);
    pessoaSearchTimeout = setTimeout(() => {
        fetch(`{{ route('lider-comunidade.usuarios.pessoas.buscar') }}?search=${encodeURIComponent(search)}`)
            .then(response => response.json())
            .then(pessoas => {
                if (pessoas.length === 0) {
                    resultsDiv.innerHTML = '<div class="p-4 text-sm text-gray-500 dark:text-gray-400">Nenhuma pessoa encontrada</div>';
                    resultsDiv.classList.remove('hidden');
                    return;
                }

                resultsDiv.innerHTML = pessoas.map(pessoa => `
                    <div class="p-3 hover:bg-gray-100 dark:hover:bg-slate-700 cursor-pointer border-b border-gray-200 dark:border-slate-700 last:border-0"
                         onclick="selecionarPessoa(${pessoa.id})">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${pessoa.nome}${pessoa.apelido ? ' (' + pessoa.apelido + ')' : ''}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            ${pessoa.nis ? 'NIS: ' + pessoa.nis + ' • ' : ''}
                            ${pessoa.cpf_formatado ? 'CPF: ' + pessoa.cpf_formatado + ' • ' : ''}
                            ${pessoa.localidade || ''}
                        </p>
                    </div>
                `).join('');
                resultsDiv.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erro ao buscar pessoas:', error);
            });
    }, 300);
}

function selecionarPessoa(pessoaId) {
    const urlBase = '{{ url("/lider-comunidade/usuarios/pessoa") }}';
    fetch(`${urlBase}/${pessoaId}`)
        .then(response => response.json())
        .then(pessoa => {
            if (pessoa.error) {
                alert('Erro: ' + pessoa.error);
                return;
            }
            document.getElementById('pessoa_search').value = '';
            document.getElementById('pessoa_results').classList.add('hidden');

            // Preencher campos do formulário (apenas se estiverem vazios ou para atualizar)
            if (confirm('Deseja substituir os dados atuais pelos dados do CadÚnico?')) {
                document.querySelector('input[name="nome"]').value = pessoa.nome;

                if (pessoa.cpf) {
                    document.querySelector('input[name="cpf"]').value = pessoa.cpf.replace(/[^0-9]/g, '');
                }

                if (pessoa.telefone) {
                    document.querySelector('input[name="telefone"]').value = pessoa.telefone;
                }

                if (pessoa.endereco) {
                    document.querySelector('input[name="endereco"]').value = pessoa.endereco;
                }

                // Feedback visual
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-bounce font-bold';
                toast.textContent = 'Dados atualizados!';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        })
        .catch(error => {
            console.error('Erro ao buscar pessoa:', error);
            alert('Erro ao carregar dados da pessoa');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pessoa_search');
    if (searchInput) {
        searchInput.addEventListener('input', buscarPessoas);
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#pessoa_search') && !e.target.closest('#pessoa_results')) {
            const resultsDiv = document.getElementById('pessoa_results');
            if (resultsDiv) resultsDiv.classList.add('hidden');
        }
    });
});
</script>
@endpush
