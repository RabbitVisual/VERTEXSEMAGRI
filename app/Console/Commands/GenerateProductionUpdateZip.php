<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class GenerateProductionUpdateZip extends Command
{
    protected $signature = 'update:generate-production-zip';
    protected $description = 'Gera arquivo ZIP completo com todas as melhorias do PWA Campo para atualização em produção';

    public function handle()
    {
        $this->info('🚀 Gerando arquivo ZIP de atualização PWA Campo para produção...');
        $this->newLine();

        $zipFileName = 'pwa-campo-update-' . date('Y-m-d-His') . '.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            $this->error('❌ Não foi possível criar o arquivo ZIP.');
            return 1;
        }

        // Arquivos criados/modificados nesta sessão - PWA Campo v2.0.0
        $filesToInclude = [
            // === NOVOS ARQUIVOS ===
            // View Composer para ordens pendentes
            ['source' => 'app/View/Composers/CampoOrdensComposer.php', 'dest' => 'app/View/Composers/CampoOrdensComposer.php', 'type' => 'file'],

            // Controller de perfil do campo
            ['source' => 'app/Http/Controllers/Funcionario/CampoProfileController.php', 'dest' => 'app/Http/Controllers/Funcionario/CampoProfileController.php', 'type' => 'file'],

            // View de perfil
            ['source' => 'resources/views/campo/profile', 'dest' => 'resources/views/campo/profile', 'type' => 'dir'],

            // Ícone SVG do PWA
            ['source' => 'public/icons/icon.svg', 'dest' => 'public/icons/icon.svg', 'type' => 'file'],

            // Página offline customizada
            ['source' => 'public/offline.html', 'dest' => 'public/offline.html', 'type' => 'file'],

            // Changelog e documentação
            ['source' => 'CHANGELOG.md', 'dest' => 'CHANGELOG.md', 'type' => 'file'],
            ['source' => 'SOLUCAO_ERROS_CORS.md', 'dest' => 'SOLUCAO_ERROS_CORS.md', 'type' => 'file'],

            // === ARQUIVOS MODIFICADOS - BACKEND ===
            // AppServiceProvider (registro do View Composer)
            ['source' => 'app/Providers/AppServiceProvider.php', 'dest' => 'app/Providers/AppServiceProvider.php', 'type' => 'file'],

            // Rotas do campo (perfil adicionado)
            ['source' => 'routes/campo.php', 'dest' => 'routes/campo.php', 'type' => 'file'],

            // Dashboard Controller (ordem em execução)
            ['source' => 'app/Http/Controllers/Funcionario/CampoDashboardController.php', 'dest' => 'app/Http/Controllers/Funcionario/CampoDashboardController.php', 'type' => 'file'],

            // === ARQUIVOS MODIFICADOS - FRONTEND VIEWS ===
            // Layout principal do campo
            ['source' => 'resources/views/campo/layouts/app.blade.php', 'dest' => 'resources/views/campo/layouts/app.blade.php', 'type' => 'file'],

            // Navbar do campo
            ['source' => 'resources/views/campo/layouts/navbar.blade.php', 'dest' => 'resources/views/campo/layouts/navbar.blade.php', 'type' => 'file'],

            // Sidebar do campo
            ['source' => 'resources/views/campo/layouts/sidebar.blade.php', 'dest' => 'resources/views/campo/layouts/sidebar.blade.php', 'type' => 'file'],

            // Dashboard do campo
            ['source' => 'resources/views/campo/dashboard.blade.php', 'dest' => 'resources/views/campo/dashboard.blade.php', 'type' => 'file'],

            // Index de ordens
            ['source' => 'resources/views/campo/ordens/index.blade.php', 'dest' => 'resources/views/campo/ordens/index.blade.php', 'type' => 'file'],

            // Show de ordem
            ['source' => 'resources/views/campo/ordens/show.blade.php', 'dest' => 'resources/views/campo/ordens/show.blade.php', 'type' => 'file'],

            // Componente loading overlay (correção crítica)
            ['source' => 'resources/views/components/loading-overlay.blade.php', 'dest' => 'resources/views/components/loading-overlay.blade.php', 'type' => 'file'],

            // === ARQUIVOS MODIFICADOS - PWA ASSETS ===
            // Service Worker
            ['source' => 'public/sw.js', 'dest' => 'public/sw.js', 'type' => 'file'],

            // JavaScript offline
            ['source' => 'public/js/campo-offline.js', 'dest' => 'public/js/campo-offline.js', 'type' => 'file'],

            // Manifest PWA
            ['source' => 'public/manifest.json', 'dest' => 'public/manifest.json', 'type' => 'file'],

            // === CONFIGURAÇÃO ===
            // package.json (correção de chave duplicada e remoção do Capacitor)
            ['source' => 'package.json', 'dest' => 'package.json', 'type' => 'file'],

            // vite.config.js (configuração CORS e servidor)
            ['source' => 'vite.config.js', 'dest' => 'vite.config.js', 'type' => 'file'],
        ];

        $this->info('📦 Adicionando arquivos ao ZIP...');
        $addedCount = 0;

        foreach ($filesToInclude as $item) {
            $source = $item['source'];
            $destination = $item['dest'];
            $type = $item['type'];

            if ($type === 'file') {
                $filePath = base_path($source);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $destination);
                    $addedCount++;
                    $this->line("  ✓ {$destination}");
                } else {
                    $this->warn("  ⚠ Arquivo não encontrado: {$source}");
                }
            } else {
                // É um diretório
                $dirPath = base_path($source);
                if (is_dir($dirPath)) {
                    $this->addDirectoryToZip($zip, $dirPath, $destination);
                    $addedCount++;
                    $this->line("  ✓ {$destination}/");
                } else {
                    $this->warn("  ⚠ Diretório não encontrado: {$source}");
                }
            }
        }

        // Adicionar arquivo de instruções
        $instructions = $this->getInstructions();
        $zip->addFromString('INSTRUCOES_INSTALACAO.txt', $instructions);
        $this->line("  ✓ INSTRUCOES_INSTALACAO.txt");

        // Adicionar changelog completo se existir
        if (file_exists(base_path('CHANGELOG.md'))) {
            $changelog = file_get_contents(base_path('CHANGELOG.md'));
            $zip->addFromString('CHANGELOG.md', $changelog);
            $this->line("  ✓ CHANGELOG.md");
        }

        $zip->close();

        $this->newLine();
        $this->info("✅ ZIP gerado com sucesso!");
        $this->info("📁 Localização: {$zipPath}");
        $this->info("📊 Total de arquivos/diretórios: " . ($addedCount + 2));
        $this->newLine();
        $this->comment("💡 Versão: PWA Campo v2.0.0");
        $this->comment("💡 Execute: php artisan update:generate-production-zip");

        return 0;
    }

    private function addDirectoryToZip($zip, $dirPath, $zipPath)
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                // Converter barras invertidas para barras normais (compatibilidade Linux)
                $relativePath = $zipPath . '/' . substr($filePath, strlen($dirPath) + 1);
                $relativePath = str_replace('\\', '/', $relativePath);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    private function getInstructions(): string
    {
        return <<<'INSTRUCTIONS'
===========================================
INSTRUÇÕES DE INSTALAÇÃO - PWA CAMPO v2.0.0
===========================================

Este pacote contém todas as melhorias e implementações do PWA Campo.

PASSO 1: BACKUP
---------------
⚠️ IMPORTANTE: Faça backup completo antes de prosseguir:
- Banco de dados completo
- Arquivos do projeto (especialmente .env)
- Arquivos de upload (storage/app/public)

PASSO 2: EXTRAIR ARQUIVOS
-------------------------
1. Extraia todos os arquivos do ZIP mantendo a estrutura de diretórios
2. Copie os arquivos para o diretório raiz do projeto Laravel
3. Mantenha a estrutura de pastas original
4. ⚠️ IMPORTANTE: Certifique-se de que todos os arquivos foram copiados

PASSO 3: REMOVER ARQUIVO HOT (CRÍTICO PARA CORS) ⚠️
----------------------------------------------------
⚠️ IMPORTANTE: Remova o arquivo que causa 21+ erros de CORS:

Linux/Mac:
rm public/hot

Windows:
del public\hot

Este arquivo contém referência a localhost:5173 e causa múltiplos erros de CORS
em produção. Se o arquivo não existir, o Laravel usará os assets compilados.

PASSO 4: LIMPAR CACHE
---------------------
Execute os seguintes comandos no servidor:

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear

PASSO 5: VERIFICAR PERMISSÕES
-----------------------------
Certifique-se de que as permissões estão corretas:

chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

PASSO 6: INSTALAR DEPENDÊNCIAS
-------------------------------
⚠️ IMPORTANTE: Execute este comando para instalar as dependências atualizadas:

npm install

Isso irá:
- Remover dependências do Capacitor (não utilizadas)
- Instalar apenas as dependências necessárias
- Garantir que não há pacotes faltando ou inválidos

PASSO 7: COMPILAR ASSETS PARA PRODUÇÃO ⚠️ CRÍTICO
-------------------------------------------------
⚠️ IMPORTANTE: Este passo é OBRIGATÓRIO para evitar erros de CORS!

Compile os assets do frontend para produção:

npm run build

Isso irá:
- Compilar CSS e JavaScript
- Gerar o manifest.json do Vite em public/build/.vite/
- Otimizar e minificar os assets
- Resolver o erro de CORS ao tentar acessar servidor de desenvolvimento

Após compilar, verifique se o diretório existe:
ls -la public/build/.vite/manifest.json

Se o arquivo não existir, o Laravel tentará usar o servidor de desenvolvimento
e causará erros de CORS em produção.

⚠️ IMPORTANTE: Após compilar, certifique-se de que o arquivo public/hot NÃO existe!

PASSO 8: VERIFICAR ROTAS
-------------------------
Verifique se as rotas estão registradas:

php artisan route:list | grep campo

PASSO 9: TESTAR SISTEMA
-----------------------
1. Acesse o sistema como funcionário de campo
2. Teste o PWA instalando no dispositivo
3. Verifique funcionalidade offline
4. Teste sincronização de dados
5. Verifique página de perfil
6. Teste sistema de alertas

MELHORIAS IMPLEMENTADAS
-----------------------
✅ PWA completo e instalável
✅ Funcionalidade 100% offline
✅ Sincronização automática segura
✅ Página de perfil do funcionário
✅ Sistema de alertas globais
✅ Design moderno com Tailwind CSS v4.1 e HyperUI
✅ View Composer para dados compartilhados
✅ Logging condicional (console limpo em produção)
✅ Correção crítica do loading overlay
✅ Ícones SVG exclusivos
✅ Service Worker avançado
✅ Cache de perfil do usuário
✅ IndexedDB para armazenamento offline

CORREÇÕES APLICADAS
-------------------
✅ Overlay não bloqueia mais formulários
✅ Ícones PNG removidos (apenas SVG)
✅ package.json corrigido (chave duplicada removida)
✅ Capacitor removido completamente (não utilizado)
✅ Redeclaração de variáveis globais corrigida
✅ Console limpo em produção
✅ Build funcionando sem erros

ARQUIVOS PRINCIPAIS
-------------------
📱 PWA:
   - public/sw.js (Service Worker)
   - public/manifest.json (Manifest PWA)
   - public/js/campo-offline.js (Sistema offline)
   - public/icons/icon.svg (Ícone SVG)
   - public/offline.html (Página offline)

👤 Perfil:
   - app/Http/Controllers/Funcionario/CampoProfileController.php
   - resources/views/campo/profile/index.blade.php

🔔 Alertas:
   - app/View/Composers/CampoOrdensComposer.php
   - app/Providers/AppServiceProvider.php

🎨 Design:
   - resources/views/campo/layouts/* (todos os layouts)
   - resources/views/campo/dashboard.blade.php
   - resources/views/campo/ordens/* (todas as views)

NOTAS IMPORTANTES
----------------
- O PWA agora funciona 100% offline
- Sincronização automática quando voltar online
- Sistema de alertas aparece em todas as páginas
- Perfil do funcionário totalmente funcional offline
- Design moderno e totalmente responsivo
- Dark mode suportado

PROBLEMAS COMUNS E SOLUÇÕES
----------------------------

❌ Erro de CORS: "Access to script at 'http://[::1]:5173/@vite/client'"
   ✅ SOLUÇÃO 1: Remova o arquivo public/hot (rm public/hot ou del public\hot)
   ✅ SOLUÇÃO 2: Execute `npm run build` para compilar os assets
   ✅ SOLUÇÃO 3: Verifique se public/build/.vite/manifest.json existe
   ✅ SOLUÇÃO 4: Limpe o cache: php artisan optimize:clear

❌ 21 erros de "Ensure that local network requests are compatible"
   ✅ CAUSA: Arquivo public/hot contém referência a localhost:5173
   ✅ SOLUÇÃO: Delete o arquivo public/hot completamente
   ✅ VERIFICAÇÃO: Certifique-se de que o arquivo não existe após deploy

❌ Assets não carregam em produção
   ✅ Verifique se APP_ENV=production no .env
   ✅ Execute npm run build
   ✅ Verifique permissões: chmod -R 755 public/build

❌ Service Worker não atualiza
   ✅ Desregistre o SW antigo no DevTools
   ✅ Limpe o cache do navegador
   ✅ Force refresh: Ctrl+Shift+R (ou Cmd+Shift+R no Mac)

SUPORTE
-------
Em caso de problemas, verifique:
- Logs do Laravel: storage/logs/laravel.log
- Console do navegador (modo desenvolvimento)
- Permissões de arquivos e diretórios
- Configuração do banco de dados
- Cache do navegador e Service Worker
- Se os assets foram compilados (public/build/.vite/manifest.json)

Para limpar o Service Worker:
1. Abra DevTools (F12)
2. Vá em Application > Service Workers
3. Clique em "Unregister"
4. Limpe o cache do navegador

===========================================
INSTRUCTIONS;
    }
}
