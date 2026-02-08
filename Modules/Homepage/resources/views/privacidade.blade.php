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
                    <x-icon name="shield-check" style="duotone" class="w-4 h-4" />
                    Proteção de Dados
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
                    Política de Privacidade
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Conheça como tratamos e protegemos seus dados pessoais de acordo com a Lei Geral de Proteção de Dados (LGPD).
                </p>
            </div>

            <!-- Conteúdo -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="p-6 md:p-8 lg:p-10 space-y-8">
                    <!-- Introdução -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="file-contract" style="duotone" class="w-6 h-6 text-emerald-500" />
                            1. Introdução
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                A Secretaria Municipal de Agricultura (SEMAGRI) de Coração de Maria - BA,
                                comprometida com a transparência e a proteção dos dados pessoais, apresenta esta Política de
                                Privacidade em conformidade com a <strong>Lei Geral de Proteção de Dados (LGPD - Lei nº 13.709/2018)</strong>.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                                Esta política descreve como coletamos, utilizamos, armazenamos e protegemos as informações
                                pessoais dos cidadãos que utilizam nossos serviços e plataformas digitais.
                            </p>
                        </div>
                    </section>

                    <!-- Dados Coletados -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="database" style="duotone" class="w-6 h-6 text-emerald-500" />
                            2. Dados Coletados
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Coletamos os seguintes tipos de dados pessoais:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li><strong>Dados de Identificação:</strong> Nome completo, CPF, RG, data de nascimento</li>
                                <li><strong>Dados de Contato:</strong> Endereço, telefone, e-mail</li>
                                <li><strong>Dados de Localização:</strong> Endereço residencial, localidade, coordenadas geográficas</li>
                                <li><strong>Dados de Demandas:</strong> Informações sobre solicitações de serviços, protocolos, histórico de atendimento</li>
                                <li><strong>Dados de Navegação:</strong> Endereço IP, cookies, logs de acesso (quando aplicável)</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Finalidade -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="bullseye" style="duotone" class="w-6 h-6 text-emerald-500" />
                            3. Finalidade do Tratamento
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Utilizamos seus dados pessoais para as seguintes finalidades:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Atendimento e processamento de demandas e solicitações de serviços</li>
                                <li>Cadastro e gestão de beneficiários de programas e políticas públicas</li>
                                <li>Comunicação sobre o status de demandas e serviços solicitados</li>
                                <li>Melhoria contínua dos serviços prestados</li>
                                <li>Cumprimento de obrigações legais e regulatórias</li>
                                <li>Geração de estatísticas e relatórios (dados agregados e anonimizados)</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Compartilhamento -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="share-nodes" style="duotone" class="w-6 h-6 text-emerald-500" />
                            4. Compartilhamento de Dados
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Seus dados pessoais <strong>não são compartilhados</strong> com terceiros, exceto nas seguintes situações:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mt-4">
                                <li>Quando necessário para o cumprimento de obrigações legais</li>
                                <li>Com órgãos públicos competentes, mediante solicitação legal</li>
                                <li>Para prestação de serviços técnicos (com empresas que atuam como processadores de dados, sob contrato de confidencialidade)</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Segurança -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="lock" style="duotone" class="w-6 h-6 text-emerald-500" />
                            5. Segurança dos Dados
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Adotamos medidas técnicas e organizacionais adequadas para proteger seus dados pessoais contra
                                acesso não autorizado, alteração, divulgação ou destruição, incluindo:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mt-4">
                                <li>Criptografia de dados sensíveis</li>
                                <li>Controle de acesso baseado em permissões</li>
                                <li>Monitoramento e auditoria de acessos</li>
                                <li>Backups regulares e planos de recuperação</li>
                                <li>Treinamento contínuo de equipe sobre proteção de dados</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Direitos -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="user-shield" style="duotone" class="w-6 h-6 text-emerald-500" />
                            6. Seus Direitos
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                De acordo com a LGPD, você possui os seguintes direitos:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li><strong>Confirmação e Acesso:</strong> Saber se tratamos seus dados e acessá-los</li>
                                <li><strong>Correção:</strong> Solicitar a correção de dados incompletos, inexatos ou desatualizados</li>
                                <li><strong>Anonimização, Bloqueio ou Eliminação:</strong> Solicitar a remoção de dados desnecessários ou tratados em desconformidade</li>
                                <li><strong>Portabilidade:</strong> Receber seus dados em formato estruturado</li>
                                <li><strong>Eliminação:</strong> Solicitar a exclusão de dados tratados com seu consentimento</li>
                                <li><strong>Revogação de Consentimento:</strong> Retirar seu consentimento a qualquer momento</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Retenção -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="hourglass" style="duotone" class="w-6 h-6 text-emerald-500" />
                            7. Retenção de Dados
                        </h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                Mantemos seus dados pessoais apenas pelo tempo necessário para cumprir as finalidades para as
                                quais foram coletados, observando os prazos legais de guarda de documentos estabelecidos pela
                                legislação brasileira.
                            </p>
                        </div>
                    </section>

                    <!-- Contato -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="envelope" style="duotone" class="w-6 h-6 text-emerald-500" />
                            8. Contato e Exercício de Direitos
                        </h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Para exercer seus direitos ou esclarecer dúvidas sobre o tratamento de seus dados pessoais,
                                entre em contato conosco:
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

                    <!-- Atualizações -->
                    <section>
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="rotate" style="duotone" class="w-6 h-6 text-emerald-500" />
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
                    <x-icon name="arrow-left" style="duotone" class="w-4 h-4" />
                    Voltar para a página inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
