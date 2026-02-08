@extends('homepage::layouts.homepage')

@section('title', 'Política de Privacidade - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                            9. Atualizações desta Política
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Esta Política de Privacidade pode ser atualizada periodicamente. Recomendamos que você revise
                                esta página regularmente para se manter informado sobre como protegemos seus dados pessoais.
                                A data da última atualização será sempre indicada no início deste documento.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                                <strong>Última atualização:</strong> {{ date('d/m/Y') }}
                            </p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Links de Navegação -->
            <div class="text-center mt-8 space-y-4">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                    Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection

