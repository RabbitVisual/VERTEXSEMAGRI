@extends('homepage::layouts.homepage')

@section('title', 'Termos de Uso - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="file-contract" style="duotone" class="w-4 h-4" />
                    Termos e Condições
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
                    Termos de Uso
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Leia atentamente os termos e condições de uso dos serviços oferecidos pela Secretaria Municipal de Agricultura.
                </p>
            </div>

            <!-- Conteúdo -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="p-6 md:p-8 lg:p-10 space-y-8">
                    <!-- Introdução -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="check-double" style="duotone" class="w-6 h-6 text-emerald-500" />
                            1. Aceitação dos Termos
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Ao acessar e utilizar os serviços oferecidos pela Secretaria Municipal de Agricultura (SEMAGRI)
                                de Coração de Maria - BA, você concorda em cumprir e estar vinculado aos seguintes Termos de Uso.
                                Se você não concorda com algum destes termos, não deve utilizar nossos serviços.
                            </p>
                        </div>
                    </section>

                    <!-- Uso dos Serviços -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="handshake" style="duotone" class="w-6 h-6 text-emerald-500" />
                            2. Uso dos Serviços
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Os serviços oferecidos pela SEMAGRI incluem, mas não se limitam a:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Atendimento de demandas e solicitações de serviços</li>
                                <li>Consulta pública de demandas e ordens de serviço</li>
                                <li>Cadastro e gestão de beneficiários de programas</li>
                                <li>Informações sobre infraestrutura rural</li>
                                <li>Portal do Agricultor e programas de apoio</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                                Você concorda em utilizar estes serviços apenas para fins legais e de acordo com estes Termos de Uso.
                            </p>
                        </div>
                    </section>

                    <!-- Responsabilidades -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="user-check" style="duotone" class="w-6 h-6 text-emerald-500" />
                            3. Responsabilidades do Usuário
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Ao utilizar nossos serviços, você se compromete a:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Fornecer informações verdadeiras, precisas e atualizadas</li>
                                <li>Manter a confidencialidade de suas credenciais de acesso</li>
                                <li>Não utilizar os serviços para atividades ilegais ou não autorizadas</li>
                                <li>Não tentar acessar áreas restritas do sistema sem autorização</li>
                                <li>Respeitar os direitos de propriedade intelectual</li>
                                <li>Não transmitir vírus, malware ou código malicioso</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Propriedade Intelectual -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="copyright" style="duotone" class="w-6 h-6 text-emerald-500" />
                            4. Propriedade Intelectual
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Todo o conteúdo disponível neste sistema, incluindo textos, gráficos, logotipos, ícones, imagens,
                                clipes de áudio, downloads digitais e compilações de dados, é de propriedade da Prefeitura Municipal
                                de Coração de Maria - BA ou de seus fornecedores de conteúdo e está protegido pelas leis brasileiras
                                de direitos autorais e propriedade intelectual.
                            </p>
                        </div>
                    </section>

                    <!-- Limitação de Responsabilidade -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="triangle-exclamation" style="duotone" class="w-6 h-6 text-emerald-500" />
                            5. Limitação de Responsabilidade
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                A SEMAGRI não se responsabiliza por danos diretos, indiretos, incidentais, especiais ou consequenciais
                                resultantes do uso ou da incapacidade de usar nossos serviços, mesmo que tenhamos sido avisados da
                                possibilidade de tais danos.
                            </p>
                        </div>
                    </section>

                    <!-- Modificações -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="pen-to-square" style="duotone" class="w-6 h-6 text-emerald-500" />
                            6. Modificações dos Termos
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Reservamo-nos o direito de modificar estes Termos de Uso a qualquer momento. As alterações entrarão
                                em vigor imediatamente após sua publicação. É sua responsabilidade revisar periodicamente estes termos
                                para estar ciente de quaisquer alterações.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                                <strong>Última atualização:</strong> {{ date('d/m/Y') }}
                            </p>
                        </div>
                    </section>

                    <!-- Contato -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="envelope" style="duotone" class="w-6 h-6 text-emerald-500" />
                            7. Contato
                        </h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Para questões relacionadas a estes Termos de Uso, entre em contato conosco:
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
