<?php

namespace Modules\Homepage\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use App\Models\CarouselSlide;

class HomepageController extends Controller
{
    /**
     * Exibe a página inicial
     */
    public function index()
    {
        $carouselEnabled = SystemConfig::get('carousel_enabled', true);
        $carouselSlides = $carouselEnabled
            ? CarouselSlide::active()->ordered()->get()
            : collect();

        // Check if ProgramasAgricultura module is enabled for the Portal do Agricultor link
        $programasAgriculturaEnabled = \Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura');

        // Configurações dinâmicas da homepage - garantir valores booleanos corretos
        $configs = [
            'hero_title' => SystemConfig::get('homepage_hero_title', 'Secretaria Municipal de Agricultura'),
            'hero_subtitle' => SystemConfig::get('homepage_hero_subtitle', 'Trabalhando pelo desenvolvimento rural sustentável e o fortalecimento da agricultura familiar em nosso município.'),
            'hero_enabled' => (bool) SystemConfig::get('homepage_hero_enabled', true),
            'servicos_enabled' => (bool) SystemConfig::get('homepage_servicos_enabled', true),
            'sobre_enabled' => (bool) SystemConfig::get('homepage_sobre_enabled', true),
            'servicos_publicos_enabled' => (bool) SystemConfig::get('homepage_servicos_publicos_enabled', true),
            'contato_enabled' => (bool) SystemConfig::get('homepage_contato_enabled', true),
            'telefone' => SystemConfig::get('homepage_telefone', '(75) 3248-2489'),
            'email' => SystemConfig::get('homepage_email', 'gabinete@coracaodemaria.ba.gov.br'),
            'endereco' => SystemConfig::get('homepage_endereco', 'Praça Dr. Araújo Pinho, Centro - CEP 44250-000'),
            // Navbar
            'navbar_inicio_enabled' => (bool) SystemConfig::get('homepage_navbar_inicio_enabled', true),
            'navbar_servicos_enabled' => (bool) SystemConfig::get('homepage_navbar_servicos_enabled', true),
            'navbar_sobre_enabled' => (bool) SystemConfig::get('homepage_navbar_sobre_enabled', true),
            'navbar_consulta_enabled' => (bool) SystemConfig::get('homepage_navbar_consulta_enabled', true),
            'navbar_contato_enabled' => (bool) SystemConfig::get('homepage_navbar_contato_enabled', true),
            // Footer
            'footer_descricao' => SystemConfig::get('homepage_footer_descricao', 'Secretaria Municipal de Agricultura de Coração de Maria - BA. Trabalhando pelo desenvolvimento rural sustentável e o fortalecimento da agricultura familiar.'),
            'footer_facebook_url' => SystemConfig::get('homepage_footer_facebook_url', 'https://www.facebook.com/prefeituradecoracaodemaria'),
            'footer_instagram_url' => SystemConfig::get('homepage_footer_instagram_url', 'https://www.instagram.com/prefeituradecoracaodemaria'),
            'footer_whatsapp' => SystemConfig::get('homepage_footer_whatsapp', '557532482489'),
            'footer_site_prefeitura' => SystemConfig::get('homepage_footer_site_prefeitura', 'https://www.coracaodemaria.ba.gov.br'),
        ];

        return view('homepage::index', compact('carouselSlides', 'carouselEnabled', 'programasAgriculturaEnabled', 'configs'));
    }

    /**
     * Exibe a página de Política de Privacidade
     */
    public function privacidade()
    {
        return view('homepage::privacidade');
    }

    /**
     * Exibe a página de Termos de Uso
     */
    public function termos()
    {
        return view('homepage::termos');
    }

    /**
     * Exibe a página Sobre Nós
     */
    public function sobre()
    {
        return view('homepage::sobre');
    }

    /**
     * Exibe a página do Desenvolvedor
     */
    public function desenvolvedor()
    {
        return view('homepage::desenvolvedor');
    }
}
