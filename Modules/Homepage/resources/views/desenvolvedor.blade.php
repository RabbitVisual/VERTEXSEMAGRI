@extends('homepage::layouts.homepage')

@section('title', 'Sobre o Desenvolvedor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Desenvolvedor do Sistema
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Sobre o Desenvolvedor
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Conheça quem desenvolveu o sistema Vertex SEMAGRI e a paixão por tecnologia aplicada ao serviço público.
                </p>
            </div>

            <!-- Conteúdo Principal -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Foto e Informações Básicas -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden sticky top-8">
                        <div class="p-6">
                            <div class="relative mb-6">
                                <div class="w-48 h-48 mx-auto rounded-2xl overflow-hidden ring-4 ring-emerald-500/20 shadow-xl">
                                    <img src="{{ asset('storage/dev/reinanrodrigues.jpg') }}" alt="Reinan Rodrigues" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center hidden">
                                        <svg class="w-24 h-24 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Reinan Rodrigues</h2>
                                <p class="text-emerald-600 dark:text-emerald-400 font-semibold mb-4">Desenvolvedor & CEO</p>
                                <div class="flex justify-center mb-6">
                                    <img src="{{ asset('storage/dev/vertex-logo.png') }}" alt="Vertex Solutions LTDA" class="h-12" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="h-12 w-32 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center hidden">
                                        <span class="text-white font-bold text-sm">VERTEX</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold">Vertex Solutions LTDA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações Detalhadas -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Sobre o Sistema -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                Sobre o Sistema Vertex SEMAGRI
                            </h3>
                            <div class="prose prose-gray dark:prose-invert max-w-none">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                    O <strong>Vertex SEMAGRI</strong> é um sistema completo de gestão desenvolvido especificamente para a
                                    Secretaria Municipal de Agricultura de Coração de Maria - BA. O sistema foi criado com o objetivo
                                    de modernizar e otimizar os processos administrativos, facilitando o atendimento à população e
                                    melhorando a eficiência dos serviços públicos.
                                </p>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                    Desenvolvido com as mais modernas tecnologias web, o sistema oferece:
                                </p>
                                <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mb-4">
                                    <li>Gestão completa de demandas e ordens de serviço</li>
                                    <li>Portal público para consulta de solicitações</li>
                                    <li>Sistema PWA (Progressive Web App) para funcionários de campo</li>
                                    <li>Funcionalidade offline completa</li>
                                    <li>Gestão de programas e eventos agrícolas</li>
                                    <li>Portal do Agricultor com informações e cadastros</li>
                                    <li>Painel administrativo completo e intuitivo</li>
                                </ul>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    Tudo desenvolvido com foco em <strong>usabilidade, segurança e performance</strong>, garantindo uma
                                    experiência excelente tanto para os servidores públicos quanto para os cidadãos.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sobre o Desenvolvedor -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Sobre o Desenvolvedor
                            </h3>
                            <div class="prose prose-gray dark:prose-invert max-w-none">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                    <strong>Reinan Rodrigues</strong> é um profissional dedicado que atualmente trabalha no setor de
                                    infraestrutura da agricultura na Prefeitura Municipal de Coração de Maria - BA. Com uma paixão
                                    genuína por tecnologia e inovação, ele desenvolveu o sistema Vertex SEMAGRI com o objetivo de
                                    facilitar a vida das pessoas e melhorar o serviço público.
                                </p>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                    Sua visão é utilizar a tecnologia como uma ferramenta poderosa para <strong>servir a população</strong>,
                                    tornando os processos mais ágeis, transparentes e acessíveis. Cada linha de código foi escrita com
                                    dedicação e atenção aos detalhes, sempre pensando na experiência do usuário final.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Trajetória Profissional -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .414-.336.75-.75.75h-4.5a.75.75 0 01-.75-.75v-4.25m0 0h4.5m-4.5 0l-1.5-1.5m1.5 1.5l1.5-1.5m-1.5 1.5v-4.25m0 4.25h-4.5m4.5 0v-4.25m0 4.25h-4.5m-4.5 0l1.5 1.5m-1.5-1.5l-1.5 1.5m1.5-1.5v-4.25m0 4.25h4.5v-4.25m0 4.25l-1.5-1.5" />
                                </svg>
                                Trajetória Profissional
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex-shrink-0 w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Setor de Infraestrutura da Agricultura</h4>
                                        <p class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold mb-2">Prefeitura Municipal de Coração de Maria - BA</p>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                            Atualmente atuando no setor de infraestrutura da agricultura, trabalhando diretamente com
                                            as necessidades do campo e da população rural, o que proporciona uma visão única e prática
                                            dos desafios enfrentados no dia a dia.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                                    <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">CEO & Desenvolvedor</h4>
                                        <p class="text-sm text-blue-600 dark:text-blue-400 font-semibold mb-2">Vertex Solutions LTDA</p>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                            Fundador e CEO da Vertex Solutions LTDA, empresa especializada em desenvolvimento de soluções
                                            tecnológicas para o setor público, com foco em sistemas de gestão e aplicações web modernas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Valores e Princípios -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl shadow-xl border-2 border-emerald-200 dark:border-emerald-800 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                </svg>
                                Valores e Princípios
                            </h3>
                            <div class="space-y-4">
                                <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Fé e Caráter</h4>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-3">
                                                <strong>Cristão</strong>, congrega na <strong>Igreja Batista Avenida de Coração de Maria - BA</strong>.
                                                Servo de Deus, Pai, Filho e Espírito Santo. A fé é a base que orienta todos os valores e princípios,
                                                refletindo em um trabalho pautado pela <strong>honestidade, integridade e compromisso</strong> com a
                                                excelência.
                                            </p>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                Acredita que o <strong>caráter e a índole</strong> são fundamentais em qualquer área da vida,
                                                especialmente quando se trabalha com tecnologia que impacta diretamente a vida das pessoas.
                                                Cada decisão técnica e cada linha de código são feitas com responsabilidade e dedicação.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Paixão por Tecnologia</h4>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                <strong>Apaixonado por tecnologia</strong> e pelo uso dela para <strong>facilitar a vida e servir a população</strong>.
                                                Acredita que a tecnologia deve ser uma ferramenta de inclusão e melhoria, não uma barreira.
                                                Por isso, o sistema Vertex SEMAGRI foi desenvolvido com foco em <strong>usabilidade, acessibilidade
                                                e experiência do usuário</strong>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Compromisso com o Serviço Público</h4>
                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                Trabalhar no setor público proporciona uma visão única das necessidades reais da população.
                                                Este conhecimento prático é aplicado diretamente no desenvolvimento de soluções que realmente
                                                fazem diferença no dia a dia das pessoas. O objetivo é sempre <strong>servir com excelência</strong>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tecnologias Utilizadas -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                </svg>
                                Tecnologias Utilizadas
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600">
                                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">Laravel</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">Framework PHP</div>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600">
                                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">Tailwind</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">CSS Framework</div>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600">
                                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">PWA</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">Progressive Web App</div>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600">
                                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">MySQL</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">Banco de Dados</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contato -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                Entre em Contato
                            </h3>
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                    Para mais informações sobre o sistema ou sobre desenvolvimento de soluções tecnológicas para o setor público,
                                    entre em contato:
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                        <div>
                                            <strong>E-mail:</strong>
                                            <a href="mailto:r.rodriguesjs@gmail.com" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                                r.rodriguesjs@gmail.com
                                            </a>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                        <div>
                                            <strong>Telefone:</strong>
                                            <a href="tel:75992034656" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                                (75) 99203-4656
                                            </a>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <div>
                                            <strong>Localização:</strong> Coração de Maria - BA, Brasil
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Links de Navegação -->
            <div class="text-center mt-8 space-y-4">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection

