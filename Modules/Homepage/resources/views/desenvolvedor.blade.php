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
                    <x-icon name="code" style="duotone" class="w-4 h-4" />
                    Desenvolvedor do Sistema
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
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
                                        <x-icon name="user" style="duotone" class="w-24 h-24 text-white/50" />
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-2">Reinan Rodrigues</h2>
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
                            <h3 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <x-icon name="server" style="duotone" class="w-6 h-6 text-emerald-500" />
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
                            <h3 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <x-icon name="user-tie" style="duotone" class="w-6 h-6 text-emerald-500" />
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
                            <h3 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <x-icon name="briefcase" style="duotone" class="w-6 h-6 text-emerald-500" />
                                Trajetória Profissional
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex-shrink-0 w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                                        <x-icon name="building-columns" style="duotone" class="w-6 h-6 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-1">Setor de Infraestrutura da Agricultura</h4>
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
                                        <x-icon name="laptop-code" style="duotone" class="w-6 h-6 text-white" />
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-1">CEO & Desenvolvedor</h4>
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
                            <h3 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <x-icon name="scale-balanced" style="duotone" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                                Valores e Princípios
                            </h3>
                            <div class="space-y-4">
                                <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-emerald-200 dark:border-emerald-800">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                            <x-icon name="church" style="duotone" class="w-5 h-5 text-white" />
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-2">Fé e Caráter</h4>
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
                                            <x-icon name="heart" style="duotone" class="w-5 h-5 text-white" />
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-2">Paixão por Tecnologia</h4>
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
                                            <x-icon name="hand-holding-heart" style="duotone" class="w-5 h-5 text-white" />
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-2">Compromisso com o Serviço Público</h4>
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
                            <h3 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <x-icon name="microchip" style="duotone" class="w-6 h-6 text-emerald-500" />
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
                            <h3 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <x-icon name="envelope" style="duotone" class="w-6 h-6 text-emerald-500" />
                                Entre em Contato
                            </h3>
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                    Para mais informações sobre o sistema ou sobre desenvolvimento de soluções tecnológicas para o setor público,
                                    entre em contato:
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start gap-3">
                                        <x-icon name="envelope" style="duotone" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" />
                                        <div>
                                            <strong>E-mail:</strong>
                                            <a href="mailto:r.rodriguesjs@gmail.com" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                                r.rodriguesjs@gmail.com
                                            </a>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <x-icon name="phone" style="duotone" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" />
                                        <div>
                                            <strong>Telefone:</strong>
                                            <a href="tel:75992034656" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                                (75) 99203-4656
                                            </a>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" />
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
                    <x-icon name="arrow-left" style="duotone" class="w-4 h-4" />
                    Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
