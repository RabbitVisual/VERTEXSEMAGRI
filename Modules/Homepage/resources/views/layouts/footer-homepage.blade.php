<footer class="bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 text-gray-600 dark:text-gray-300 mt-20 border-t border-gray-200 dark:border-slate-700">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8">
            <!-- Logo e Descrição -->
            <div class="space-y-4">
                <img src="{{ asset('images/logo-vertex-semagri.svg') }}" alt="SEMAGRI - Secretaria Municipal de Agricultura" class="h-12 mb-4">
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm">
                    @php
                        $footerDescricao = \App\Models\SystemConfig::get('homepage_footer_descricao', 'Secretaria Municipal de Agricultura de Coração de Maria - BA. Trabalhando pelo desenvolvimento rural sustentável e o fortalecimento da agricultura familiar.');
                    @endphp
                    {{ $footerDescricao }}
                </p>
                <div class="flex gap-4 pt-2">
                    @php
                        $facebookUrl = \App\Models\SystemConfig::get('homepage_footer_facebook_url', 'https://www.facebook.com/prefeituradecoracaodemaria');
                        $instagramUrl = \App\Models\SystemConfig::get('homepage_footer_instagram_url', 'https://www.instagram.com/prefeituradecoracaodemaria');
                        $whatsapp = \App\Models\SystemConfig::get('homepage_footer_whatsapp', '557532482489');
                    @endphp
                    @if($facebookUrl)
                    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-200 dark:bg-slate-700 hover:bg-emerald-600 dark:hover:bg-emerald-600 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg text-gray-700 dark:text-gray-300" aria-label="Facebook">
                        <x-icon name="facebook" style="brands" class="w-5 h-5" />
                    </a>
                    @endif
                    @if($instagramUrl)
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-200 dark:bg-slate-700 hover:bg-emerald-600 dark:hover:bg-emerald-600 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg text-gray-700 dark:text-gray-300" aria-label="Instagram">
                        <x-icon name="instagram" style="brands" class="w-5 h-5" />
                    </a>
                    @endif
                    @if($whatsapp)
                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-200 dark:bg-slate-700 hover:bg-emerald-600 dark:hover:bg-emerald-600 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg text-gray-700 dark:text-gray-300" aria-label="WhatsApp">
                        <x-icon name="whatsapp" style="brands" class="w-5 h-5" />
                    </a>
                    @endif
                </div>
            </div>

            <!-- Links Úteis -->
            <div>
                <h5 class="text-gray-900 dark:text-white font-bold text-lg mb-4 flex items-center gap-2">
                    <x-icon name="link" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400" />
                    Links Úteis
                </h5>
                <ul class="space-y-3">
                    <li><a href="#inicio" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="house" style="duotone" class="w-4 h-4" />
                        Início
                    </a></li>
                    <li><a href="#servicos" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="grid-2" style="duotone" class="w-4 h-4" />
                        Nossos Serviços
                    </a></li>
                    <li><a href="{{ route('homepage') }}#servicos-publicos" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="globe" style="duotone" class="w-4 h-4" />
                        Serviços Públicos
                    </a></li>
                    <li><a href="#contato" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="paper-plane" style="duotone" class="w-4 h-4" />
                        Contato
                    </a></li>
                    @php
                        $sitePrefeitura = \App\Models\SystemConfig::get('homepage_footer_site_prefeitura', 'https://www.coracaodemaria.ba.gov.br');
                    @endphp
                    @if($sitePrefeitura)
                    <li><a href="{{ $sitePrefeitura }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="building-columns" style="duotone" class="w-4 h-4" />
                        Site da Prefeitura
                    </a></li>
                    @endif
                </ul>
            </div>

            <!-- Links Legais -->
            <div>
                <h5 class="text-gray-900 dark:text-white font-bold text-lg mb-4 flex items-center gap-2">
                    <x-icon name="scale-balanced" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400" />
                    Informações Legais
                </h5>
                <ul class="space-y-3">
                    <li><a href="{{ route('termos') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="file-contract" style="duotone" class="w-4 h-4" />
                        Termos de Uso
                    </a></li>
                    <li><a href="{{ route('privacidade') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="shield-halved" style="duotone" class="w-4 h-4" />
                        Política de Privacidade
                    </a></li>
                    <li><a href="{{ route('sobre') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="circle-info" style="duotone" class="w-4 h-4" />
                        Sobre Nós
                    </a></li>
                    <li><a href="{{ route('desenvolvedor') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        <x-icon name="user-gear" style="duotone" class="w-4 h-4" />
                        Desenvolvedor
                    </a></li>
                </ul>
            </div>

            <!-- Serviços -->
            <div>
                <h5 class="text-gray-900 dark:text-white font-bold text-lg mb-4 flex items-center gap-2">
                    <x-icon name="grid-2" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400" />
                    Nossos Serviços
                </h5>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2 text-gray-600 dark:text-gray-400 text-sm">
                        <x-icon name="check-circle" style="duotone" class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                        <span>Atendimento de Demandas</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-600 dark:text-gray-400 text-sm">
                        <x-icon name="check-circle" style="duotone" class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                        <span>Infraestrutura Rural</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-600 dark:text-gray-400 text-sm">
                        <x-icon name="check-circle" style="duotone" class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                        <span>Apoio à Agricultura Familiar</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-600 dark:text-gray-400 text-sm">
                        <x-icon name="check-circle" style="duotone" class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                        <span>Desenvolvimento Rural Sustentável</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-600 dark:text-gray-400 text-sm">
                        <x-icon name="check-circle" style="duotone" class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" />
                        <span>Cadastros e Documentação</span>
                    </li>
                </ul>
            </div>

            <!-- Contato -->
            <div>
                <h5 class="text-gray-900 dark:text-white font-bold text-lg mb-4 flex items-center gap-2">
                    <x-icon name="headset" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400" />
                    Contato
                </h5>
                <ul class="space-y-4">
                    @php
                        $email = \App\Models\SystemConfig::get('homepage_email', 'gabinete@coracaodemaria.ba.gov.br');
                        $telefone = \App\Models\SystemConfig::get('homepage_telefone', '(75) 3248-2489');
                        $endereco = \App\Models\SystemConfig::get('homepage_endereco', 'Praça Dr. Araújo Pinho, Centro - CEP 44250-000');
                    @endphp
                    @if($email)
                    <li class="flex items-start gap-3">
                        <x-icon name="envelope" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                        <a href="mailto:{{ $email }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors break-all text-sm">
                            {{ $email }}
                        </a>
                    </li>
                    @endif
                    @if($telefone)
                    <li class="flex items-start gap-3">
                        <x-icon name="phone-volume" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $telefone) }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors text-sm">
                            {{ $telefone }}
                        </a>
                    </li>
                    @endif
                    @if($endereco)
                    <li class="flex items-start gap-3">
                        <x-icon name="map-location-dot" style="duotone" class="w-5 h-5 text-emerald-500 dark:text-emerald-400 flex-shrink-0 mt-0.5" />
                        <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $endereco }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="border-t border-gray-200 dark:border-slate-700">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <p class="flex items-center gap-2 text-center">
                        <x-icon name="copyright" style="duotone" class="w-4 h-4" />
                        {{ date('Y') }} Prefeitura Municipal de Coração de Maria - BA. Todos os direitos reservados.
                    </p>
                    <p class="text-center md:text-right">
                        Secretaria Municipal de Agricultura - SEMAGRI
                    </p>
                </div>
                <div class="flex flex-col md:flex-row justify-center items-center gap-2 pt-4 border-t border-gray-200 dark:border-slate-700 text-xs text-gray-400 dark:text-gray-500">
                    @php
                        $vertexCompany = \App\Models\SystemConfig::get('homepage_footer_vertex_company', 'Vertex Solutions LTDA');
                        $vertexCeo = \App\Models\SystemConfig::get('homepage_footer_vertex_ceo', 'Reinan Rodrigues');
                        $vertexEmail = \App\Models\SystemConfig::get('homepage_footer_vertex_email', 'r.rodriguesjs@gmail.com');
                        $vertexPhone = \App\Models\SystemConfig::get('homepage_footer_vertex_phone', '75992034656');
                    @endphp
                    <p class="text-center">
                        © {{ date('Y') }} <span class="text-gray-600 dark:text-gray-400 font-semibold">{{ $vertexCompany }}</span>
                    </p>
                    <span class="hidden md:inline">•</span>
                    <p class="text-center">
                        CEO: <span class="text-gray-600 dark:text-gray-400 font-semibold">{{ $vertexCeo }}</span>
                    </p>
                    <span class="hidden md:inline">•</span>
                    <p class="text-center">
                        <a href="mailto:{{ $vertexEmail }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ $vertexEmail }}</a>
                    </p>
                    <span class="hidden md:inline">•</span>
                    <p class="text-center">
                        <a href="tel:{{ $vertexPhone }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ $vertexPhone }}</a>
                    </p>
                    <span class="hidden md:inline">•</span>
                    <p class="text-center">
                        Todos os direitos reservados
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
