<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SystemConfigService;
use App\Models\SystemConfig;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    protected $configService;

    public function __construct(SystemConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function index()
    {
        $configs = $this->configService->getConfigsGrouped();
        $groups = ['general', 'email', 'security', 'backup', 'modules', 'pix', 'recaptcha'];
        
        // Garantir que as configurações PIX existam
        $this->configService->ensurePixConfigs();
        
        // Garantir que as configurações reCAPTCHA existam
        $this->configService->ensureRecaptchaConfigs();
        
        return view('admin.config.index', compact('configs', 'groups'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'configs' => 'required|array',
        ]);

        try {
            foreach ($validated['configs'] as $key => $value) {
                $config = SystemConfig::where('key', $key)->first();
                if ($config) {
                    $this->configService->updateConfigWithEnvSync(
                        $key,
                        $value,
                        $config->type,
                        $config->description
                    );
                } else {
                    $this->configService->updateConfig($key, $value);
                }
            }
            
            return redirect()->route('admin.config.index')
                ->with('success', 'Configurações atualizadas com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar configurações: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function initialize()
    {
        try {
            $this->configService->initializeDefaultConfigs();
            return redirect()->route('admin.config.index')
                ->with('success', 'Configurações padrão inicializadas com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao inicializar configurações: ' . $e->getMessage());
        }
    }
}
