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
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Proteção de Dados
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75M3.75 6.75h16.5M3.75 9.75h16.5m-16.5 3h16.5M3.75 15.75h16.5" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.645-5.963-1.88A13.07 13.07 0 016.5 15.5m12 0a13.07 13.07 0 00-1.537-3.62M6.5 15.5a13.07 13.07 0 01-1.537-3.62m0 0A13.07 13.07 0 0112 8.5c2.17 0 4.207.645 5.963 1.88M6.5 15.5l-3.5 3.5m3.5-3.5l3.5 3.5m-3.5-3.5v-7m0 0l-3.5-3.5m3.5 3.5l3.5-3.5" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            8. Contato e Exercício de Direitos
                        </h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                Para exercer seus direitos ou esclarecer dúvidas sobre o tratamento de seus dados pessoais,
                                entre em contato conosco:
                            </p>
                            <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                    <div>
                                        <strong>E-mail:</strong>
                                        <a href="mailto:gabinete@coracaodemaria.ba.gov.br" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                            gabinete@coracaodemaria.ba.gov.br
                                        </a>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                    <div>
                                        <strong>Telefone:</strong>
                                        <a href="tel:557532482489" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                            (75) 3248-2489
                                        </a>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
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

