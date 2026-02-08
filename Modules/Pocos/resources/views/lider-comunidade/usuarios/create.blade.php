@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Cadastrar Usuário')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.usuarios.index') }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Novo Morador</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Cadastre um novo usuário no sistema do poço</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('lider-comunidade.usuarios.store') }}" class="premium-card p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3">Vincular Registro Existente</h2>
                <div class="relative">
                    <label for="pessoa_search" class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                        Busca no CadÚnico (Opcional)
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

            <div class="md:col-span-2">
                <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3 pt-4">Dados de Contato e Localização</h2>
            </div>

            <div class="md:col-span-2 lg:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Nome Completo *</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">CPF (Apenas Números)</label>
                <input type="text" name="cpf" value="{{ old('cpf') }}" maxlength="11" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Telefone / WhatsApp</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">E-mail para Notificações</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div class="md:col-span-2 lg:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Endereço / Rua *</label>
                <input type="text" name="endereco" value="{{ old('endereco') }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Número</label>
                <input type="text" name="numero_casa" value="{{ old('numero_casa') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Status Inicial *</label>
                <select name="status" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="ativo" {{ old('status', 'ativo') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ old('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    <option value="suspenso" {{ old('status') === 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Observações Internas</label>
                <textarea name="observacoes" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-10 pt-8 border-t border-gray-100 dark:border-slate-800">
            <a href="{{ route('lider-comunidade.usuarios.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200 uppercase tracking-widest">
                Cancelar
            </a>
            <button type="submit" class="px-10 py-3 text-sm font-black text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest">
                Finalizar Cadastro
            </button>
        </div>
    </form>
</div>

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

            // Preencher campos do formulário
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

            // Feedback visual de preenchimento
            const prefillToast = document.createElement('div');
            prefillToast.className = 'fixed bottom-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-bounce font-bold';
            prefillToast.textContent = 'Dados preenchidos com sucesso!';
            document.body.appendChild(prefillToast);
            setTimeout(() => prefillToast.remove(), 3000);
        })
        .catch(error => {
            console.error('Erro ao buscar pessoa:', error);
            alert('Erro ao carregar dados da pessoa');
        });
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    const pessoaSearchInput = document.getElementById('pessoa_search');
    if (pessoaSearchInput) {
        pessoaSearchInput.addEventListener('input', buscarPessoas);
    }


    // Fechar resultados ao clicar fora
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#pessoa_search') && !e.target.closest('#pessoa_results')) {
            const resultsDiv = document.getElementById('pessoa_results');
            if (resultsDiv) {
                resultsDiv.classList.add('hidden');
            }
        }
    });
});
</script>
@endpush
@endsection
