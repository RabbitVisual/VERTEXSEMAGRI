<?php

namespace Modules\Homepage\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;

class HomepageAdminController extends Controller
{
    /**
     * Display homepage configuration dashboard
     */
    public function index()
    {
        $carouselEnabled = (bool) SystemConfig::get('carousel_enabled', true);
        $carouselSlides = CarouselSlide::ordered()->get();

        // Configurações da homepage - garantir valores booleanos corretos
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
            // Vertex Solutions
            'footer_vertex_company' => SystemConfig::get('homepage_footer_vertex_company', 'Vertex Solutions LTDA'),
            'footer_vertex_ceo' => SystemConfig::get('homepage_footer_vertex_ceo', 'Reinan Rodrigues'),
            'footer_vertex_email' => SystemConfig::get('homepage_footer_vertex_email', 'r.rodriguesjs@gmail.com'),
            'footer_vertex_phone' => SystemConfig::get('homepage_footer_vertex_phone', '75992034656'),
        ];

        return view('homepage::admin.index', compact('carouselEnabled', 'carouselSlides', 'configs'));
    }

    /**
     * Update homepage configuration
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_enabled' => 'nullable|boolean',
            'servicos_enabled' => 'nullable|boolean',
            'sobre_enabled' => 'nullable|boolean',
            'servicos_publicos_enabled' => 'nullable|boolean',
            'contato_enabled' => 'nullable|boolean',
            'telefone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            // Navbar
            'navbar_inicio_enabled' => 'nullable|boolean',
            'navbar_servicos_enabled' => 'nullable|boolean',
            'navbar_sobre_enabled' => 'nullable|boolean',
            'navbar_consulta_enabled' => 'nullable|boolean',
            'navbar_contato_enabled' => 'nullable|boolean',
            // Footer
            'footer_descricao' => 'nullable|string|max:500',
            'footer_facebook_url' => 'nullable|url|max:255',
            'footer_instagram_url' => 'nullable|url|max:255',
            'footer_whatsapp' => 'nullable|string|max:20',
            'footer_site_prefeitura' => 'nullable|url|max:255',
            // Vertex Solutions
            'footer_vertex_company' => 'nullable|string|max:255',
            'footer_vertex_ceo' => 'nullable|string|max:255',
            'footer_vertex_email' => 'nullable|email|max:255',
            'footer_vertex_phone' => 'nullable|string|max:20',
        ]);

        // Salvar configurações - tratar valores booleanos corretamente
        $booleanFields = [
            'hero_enabled', 'servicos_enabled', 'sobre_enabled', 'servicos_publicos_enabled', 'contato_enabled',
            'navbar_inicio_enabled', 'navbar_servicos_enabled', 'navbar_sobre_enabled', 'navbar_consulta_enabled', 'navbar_contato_enabled'
        ];

        foreach ($validated as $key => $value) {
            // Para campos booleanos, verificar se existe no request
            if (in_array($key, $booleanFields)) {
                $value = $request->has($key) ? (bool) $request->input($key) : false;
            }

            SystemConfig::set(
                'homepage_' . $key,
                $value,
                in_array($key, $booleanFields) ? 'boolean' : 'string',
                'homepage',
                'Configuração da homepage'
            );
        }

        return redirect()->route('admin.homepage.index')
            ->with('success', 'Configurações da homepage atualizadas com sucesso!');
    }

    /**
     * Toggle section visibility
     */
    public function toggleSection(Request $request)
    {
        $request->validate([
            'section' => 'required|string|in:hero,servicos,sobre,servicos_publicos,contato,carousel,navbar_inicio,navbar_servicos,navbar_sobre,navbar_consulta,navbar_contato',
            'enabled' => 'required|boolean',
        ]);

        $section = $request->input('section');
        // Garantir que enabled seja boolean
        $enabled = filter_var($request->input('enabled'), FILTER_VALIDATE_BOOLEAN);

        // Para carousel, usar a chave específica
        // Para navbar, já vem com prefixo navbar_
        if ($section === 'carousel') {
            $configKey = 'carousel_enabled';
        } elseif (str_starts_with($section, 'navbar_')) {
            $configKey = 'homepage_' . $section . '_enabled';
        } else {
            $configKey = 'homepage_' . $section . '_enabled';
        }

        try {
            SystemConfig::set(
                $configKey,
                $enabled,
                'boolean',
                $section === 'carousel' ? 'carousel' : 'homepage',
                'Habilita ou desabilita a seção ' . $section . ' na homepage'
            );

            return response()->json([
                'success' => true,
                'enabled' => $enabled,
                'message' => $enabled ? 'Seção ativada com sucesso!' : 'Seção desativada com sucesso!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos: ' . implode(', ', array_map(fn($errors) => implode(', ', $errors), $e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar seção homepage', [
                'section' => $section,
                'enabled' => $enabled,
                'configKey' => $configKey,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar seção. Tente novamente.'
            ], 500);
        }
    }
}

