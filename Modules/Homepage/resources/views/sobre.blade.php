@extends('homepage::layouts.homepage')

@section('title', 'Sobre Nós - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="building-columns" style="duotone" class="w-4 h-4" />
                    Conheça a SEMAGRI
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
                    Sobre Nós
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Conheça a Secretaria Municipal de Agricultura e nossa missão de promover o desenvolvimento rural sustentável.
                </p>
            </div>

            <!-- Conteúdo -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="p-6 md:p-8 lg:p-10 space-y-8">
                    <!-- Missão -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="bullseye-arrow" style="duotone" class="w-6 h-6 text-emerald-500" />
                            Nossa Missão
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                A Secretaria Municipal de Agricultura (SEMAGRI) de Coração de Maria - BA tem como missão
                                promover o desenvolvimento rural sustentável, fortalecer a agricultura familiar e
                                garantir o bem-estar das comunidades rurais do município.
                            </p>
                        </div>
                    </section>

                    <!-- Visão -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="eye" style="duotone" class="w-6 h-6 text-emerald-500" />
                            Nossa Visão
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Ser referência em gestão pública rural, reconhecida pela excelência no atendimento, inovação tecnológica
                                e compromisso com a sustentabilidade ambiental e o desenvolvimento social das comunidades rurais.
                            </p>
                        </div>
                    </section>

                    <!-- Valores -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="scale-balanced" style="duotone" class="w-6 h-6 text-emerald-500" />
                            Nossos Valores
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li><strong>Transparência:</strong> Atuamos com transparência em todas as nossas ações e decisões</li>
                                <li><strong>Sustentabilidade:</strong> Promovemos práticas que garantem recursos para futuras gerações</li>
                                <li><strong>Inovação:</strong> Buscamos constantemente novas tecnologias e métodos para melhorar nossos serviços</li>
                                <li><strong>Compromisso Social:</strong> Trabalhamos para o bem-estar e desenvolvimento das comunidades rurais</li>
                                <li><strong>Excelência:</strong> Buscamos a excelência em todos os serviços prestados</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Serviços -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="briefcase" style="duotone" class="w-6 h-6 text-emerald-500" />
                            Nossos Serviços
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Oferecemos uma ampla gama de serviços para atender às necessidades da população rural:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Atendimento de demandas e solicitações de serviços</li>
                                <li>Infraestrutura rural (poços, estradas, energia, água)</li>
                                <li>Apoio à agricultura familiar e programas de desenvolvimento</li>
                                <li>Desenvolvimento rural sustentável</li>
                                <li>Cadastros e documentação rural</li>
                                <li>Consultoria técnica e extensão rural</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Contato -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="envelope" style="duotone" class="w-6 h-6 text-emerald-500" />
                            Entre em Contato
                        </h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Estamos à disposição para atendê-lo. Entre em contato conosco:
                            </p>
                            <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-3">
                                    <x-icon name="envelope" style="duotone" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" />
                                    <div>
                                        <strong>E-mail:</strong>
                                        <a href="mailto:gabinete@coracaodemaria.ba.gov.br" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                            gabinete@coracaodemaria.ba.gov.br
                                        </a>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-icon name="phone" style="duotone" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" />
                                    <div>
                                        <strong>Telefone:</strong>
                                        <a href="tel:557532482489" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                            (75) 3248-2489
                                        </a>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" />
                                    <div>
                                        <strong>Endereço:</strong> Praça Dr. Araújo Pinho, Centro - CEP 44250-000<br>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Coração de Maria - BA</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Links de Navegação -->
            <div class="text-center mt-8 space-y-4">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                    <x-icon name="arrow-left" style="duotone" class="w-4 h-4" />
                    Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
