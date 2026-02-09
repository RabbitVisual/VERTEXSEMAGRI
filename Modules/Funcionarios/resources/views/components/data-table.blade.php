@props(['headers', 'exportRoute' => null, 'showActions' => true, 'title' => 'Listagem Operacional'])

<div class="premium-card overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between bg-gray-50/30 dark:bg-slate-900/30">
        <div>
            <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $title }}</h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 italic">Arquivo de registros do sistema de efetivos</p>
        </div>

        @if($exportRoute)
            <div class="relative group" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="h-12 px-6 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-emerald-600 hover:border-emerald-300 transition-all flex items-center gap-3">
                    <x-icon name="file-export" style="duotone" class="w-4 h-4" />
                    Extrair Dados
                </button>

                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-3 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 z-50 overflow-hidden py-2 animate-scale-in">
                    <a href="{{ $exportRoute }}?format=csv" class="flex items-center gap-3 px-6 py-3 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:text-emerald-600 transition-colors">
                        <x-icon name="file-csv" style="duotone" class="w-4 h-4" />
                        Formato CSV
                    </a>
                    <a href="{{ $exportRoute }}?format=excel" class="flex items-center gap-3 px-6 py-3 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:text-emerald-600 transition-colors">
                        <x-icon name="file-excel" style="duotone" class="w-4 h-4" />
                        Formato EXCEL
                    </a>
                    <a href="{{ $exportRoute }}?format=pdf" class="flex items-center gap-3 px-6 py-3 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:text-emerald-600 transition-colors">
                        <x-icon name="file-pdf" style="duotone" class="w-4 h-4" />
                        Formato PDF (HQ)
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-0">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-slate-900/50">
                    @foreach($headers as $header)
                        <th class="px-10 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">
                            {{ $header }}
                        </th>
                    @endforeach
                    @if($showActions)
                        <th class="px-10 py-5 text-right text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] border-b border-gray-100 dark:border-slate-800 italic">
                            Ações
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if(isset($data) && $data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->hasPages())
        <div class="px-10 py-6 bg-gray-50/30 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-800">
            {{ $data->links() }}
        </div>
    @endif
</div>
