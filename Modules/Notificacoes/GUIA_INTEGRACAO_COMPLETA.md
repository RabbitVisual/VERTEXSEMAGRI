# Guia Completo de Integração - Módulo Notificações

## 🎯 Visão Geral

O módulo de Notificações do VERTEXSEMAGRI foi completamente aprimorado com:

- ✅ **Broadcasting em Tempo Real**: Suporte a WebSockets (Pusher/Redis) com fallback automático para polling
- ✅ **Sistema de Eventos**: Eventos Laravel para notificações em tempo real
- ✅ **Email**: Suporte completo a envio de emails
- ✅ **API RESTful**: Endpoints completos para integração
- ✅ **Interface Admin**: Gerenciamento completo de notificações
- ✅ **Integração Total**: Pronto para integração com todos os módulos

## 🚀 Como Integrar em um Módulo

### Método 1: Usar o Trait `SendsNotifications` (Recomendado)

```php
<?php

namespace Modules\SeuModulo\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Notificacoes\App\Traits\SendsNotifications;

class SeuController extends Controller
{
    use SendsNotifications;

    public function criarAlgo(Request $request)
    {
        $entidade = SeuModel::create($request->validated());

        // Notificar usuário específico
        $this->notifyUser(
            auth()->user(),
            'success',
            'Entidade Criada',
            "A entidade #{$entidade->id} foi criada com sucesso.",
            route('seu-modulo.show', $entidade->id),
            ['entidade_id' => $entidade->id],
            'SeuModulo',
            SeuModel::class,
            $entidade->id
        );

        // Ou notificar uma role
        $this->notifyRole(
            'admin',
            'info',
            'Nova Entidade',
            "Uma nova entidade foi criada.",
            route('admin.seu-modulo.index')
        );

        return redirect()->route('seu-modulo.show', $entidade->id);
    }
}
```

### Método 2: Usar o Service Diretamente

```php
<?php

use Modules\Notificacoes\App\Services\NotificacaoService;

class SeuController extends Controller
{
    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    public function criarAlgo(Request $request)
    {
        $entidade = SeuModel::create($request->validated());

        $this->notificacaoService->sendFromModule(
            'SeuModulo',
            'success',
            'Entidade Criada',
            "A entidade #{$entidade->id} foi criada.",
            auth()->user(), // ou 'admin', ou Collection de Users, ou 'all'
            route('seu-modulo.show', $entidade->id),
            ['entidade_id' => $entidade->id],
            SeuModel::class,
            $entidade->id
        );
    }
}
```

### Método 3: Usar Observers (Para Notificações Automáticas)

```php
<?php

namespace Modules\SeuModulo\App\Observers;

use Modules\SeuModulo\App\Models\SeuModel;
use Modules\Notificacoes\App\Services\NotificacaoService;
use App\Models\User;

class SeuModelObserver
{
    protected NotificacaoService $notificacaoService;

    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    public function created(SeuModel $model)
    {
        // Notificar admins quando uma nova entidade é criada
        $this->notificacaoService->sendToRole(
            'admin',
            'info',
            'Nova Entidade Criada',
            "Uma nova entidade foi criada: {$model->nome}",
            route('admin.seu-modulo.show', $model->id),
            ['entidade_id' => $model->id],
            'SeuModulo',
            SeuModel::class,
            $model->id
        );
    }

    public function updated(SeuModel $model)
    {
        // Notificar quando status muda
        if ($model->wasChanged('status')) {
            $this->notificacaoService->sendToUser(
                $model->user_id,
                'alert',
                'Status Atualizado',
                "O status da entidade #{$model->id} foi atualizado.",
                route('seu-modulo.show', $model->id),
                ['entidade_id' => $model->id, 'status' => $model->status],
                'SeuModulo',
                SeuModel::class,
                $model->id
            );
        }
    }
}
```

**Registrar o Observer no ServiceProvider:**

```php
<?php

namespace Modules\SeuModulo\Providers;

use Modules\SeuModulo\App\Models\SeuModel;
use Modules\SeuModulo\App\Observers\SeuModelObserver;

class SeuModuloServiceProvider extends ServiceProvider
{
    public function boot()
    {
        SeuModel::observe(SeuModelObserver::class);
    }
}
```

## 📋 Integrações por Módulo

### 🌊 Módulo Agua

**Eventos que devem gerar notificações:**
- Nova rede de água cadastrada → Notificar admins
- Problema detectado na rede → Notificar equipe responsável
- Manutenção agendada → Notificar técnicos

**Exemplo:**

```php
// No AguaController ou AguaObserver
use Modules\Notificacoes\App\Traits\SendsNotifications;

class AguaController extends Controller
{
    use SendsNotifications;

    public function store(Request $request)
    {
        $rede = RedeAgua::create($request->validated());

        $this->notifyRole(
            'admin',
            'info',
            'Nova Rede de Água Cadastrada',
            "Uma nova rede de água foi cadastrada em {$rede->localidade->nome}.",
            route('admin.agua.show', $rede->id),
            ['rede_id' => $rede->id],
            'Agua',
            RedeAgua::class,
            $rede->id
        );
    }
}
```

### 🌾 Módulo CAF

**Eventos que devem gerar notificações:**
- Novo agricultor cadastrado → Notificar admins
- Documentação pendente → Notificar agricultor
- Certificado emitido → Notificar agricultor

### 💬 Módulo Chat

**Eventos que devem gerar notificações:**
- Nova mensagem recebida → Notificar destinatário
- Mensagem não lida → Notificar usuário

### 📋 Módulo Demandas

**Já integrado!** Ver `Modules/Demandas/app/Http/Controllers/DemandasController.php`

**Eventos:**
- Demanda criada → Notificar admins
- Demanda urgente → Notificar co-admins
- Demanda concluída → Notificar solicitante

### 👨‍👩‍👧‍👦 Módulo Equipes

**Já integrado!** Ver `Modules/Ordens/app/Observers/OrdemServicoObserver.php`

**Eventos:**
- Equipe atribuída a ordem → Notificar líder e membros
- Equipe deslocada → Notificar equipe

### 🛣️ Módulo Estradas

**Eventos que devem gerar notificações:**
- Novo trecho cadastrado → Notificar admins
- Condição crítica → Notificar equipe de manutenção
- Manutenção concluída → Notificar admins

### 👷 Módulo Funcionarios

**Já integrado!** Ver `Modules/Funcionarios/app/Observers/FuncionarioObserver.php`

**Eventos:**
- Novo funcionário cadastrado → Notificar RH
- Funcionário atribuído a equipe → Notificar funcionário

### 🏠 Módulo Homepage

**Eventos que devem gerar notificações:**
- Novo banner publicado → Notificar admins
- Banner expirado → Notificar admins

### 💡 Módulo Iluminacao

**Eventos que devem gerar notificações:**
- Novo ponto de luz cadastrado → Notificar admins
- Ponto com problema → Notificar equipe de manutenção
- Manutenção concluída → Notificar admins

### 📍 Módulo Localidades

**Eventos que devem gerar notificações:**
- Nova localidade cadastrada → Notificar admins
- Estatísticas atualizadas → Notificar admins

### 📦 Módulo Materiais

**Já integrado!** Ver `Modules/Materiais/app/Observers/MaterialObserver.php`

**Eventos:**
- Estoque baixo → Notificar admins
- Estoque zerado → Notificar admins
- Material recebido → Notificar admins

### 🔧 Módulo Ordens

**Já integrado!** Ver `Modules/Ordens/app/Observers/OrdemServicoObserver.php`

**Eventos:**
- Ordem criada → Notificar funcionário atribuído
- Ordem concluída → Notificar admins
- Ordem cancelada → Notificar equipe

### 👥 Módulo Pessoas

**Eventos que devem gerar notificações:**
- Nova pessoa cadastrada → Notificar admins
- Dados atualizados → Notificar admins
- Documentação pendente → Notificar pessoa

### 🕳️ Módulo Pocos

**Eventos que devem gerar notificações:**
- Novo poço cadastrado → Notificar admins
- Problema no poço → Notificar equipe responsável
- Manutenção agendada → Notificar técnicos

### 🌱 Módulo ProgramasAgricultura

**Eventos que devem gerar notificações:**
- Novo programa criado → Notificar admins
- Inscrição realizada → Notificar agricultor
- Evento próximo → Notificar participantes

### 📊 Módulo Relatorios

**Eventos que devem gerar notificações:**
- Relatório gerado → Notificar solicitante
- Relatório disponível → Notificar usuário

## ⚙️ Configuração

### Variáveis de Ambiente (.env)

```env
# Broadcasting (opcional - para WebSockets)
BROADCAST_DRIVER=log
# Para usar Pusher:
# BROADCAST_DRIVER=pusher
# PUSHER_APP_ID=your-app-id
# PUSHER_APP_KEY=your-app-key
# PUSHER_APP_SECRET=your-app-secret
# PUSHER_APP_CLUSTER=mt1

# Notificações
NOTIFICACOES_EMAIL_ENABLED=false
NOTIFICACOES_POLLING_INTERVAL=30000
NOTIFICACOES_BROADCASTING_ENABLED=true
```

### Configurar Broadcasting (Opcional)

Para usar WebSockets em tempo real:

1. **Instalar Pusher** (recomendado para produção):
   ```bash
   composer require pusher/pusher-php-server
   ```

2. **Configurar no .env:**
   ```env
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your-app-id
   PUSHER_APP_KEY=your-app-key
   PUSHER_APP_SECRET=your-app-secret
   PUSHER_APP_CLUSTER=mt1
   ```

3. **Adicionar Pusher JS no layout:**
   ```html
   <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
   <script>
       window.PUSHER_APP_KEY = '{{ config('broadcasting.connections.pusher.key') }}';
       window.PUSHER_APP_CLUSTER = '{{ config('broadcasting.connections.pusher.options.cluster') }}';
       window.BROADCAST_DRIVER = '{{ config('broadcasting.default') }}';
       window.USER_ID = {{ auth()->id() ?? 'null' }};
   </script>
   ```

## 🎨 Tipos de Notificações

- **info**: Informação geral (azul)
- **success**: Sucesso/ação concluída (verde)
- **warning**: Aviso/atenção necessária (amarelo)
- **error**: Erro/problema (vermelho)
- **alert**: Alerta importante (laranja)
- **system**: Notificação do sistema (cinza)

## 📡 API Endpoints

### Web API

- `GET /api/notificacoes/unread` - Obter notificações não lidas
- `GET /api/notificacoes/count` - Obter contador de não lidas
- `GET /api/notificacoes` - Obter todas as notificações
- `POST /api/notificacoes/{id}/read` - Marcar como lida
- `POST /api/notificacoes/read-all` - Marcar todas como lidas

## ✅ Checklist de Integração

Para cada módulo:

- [ ] Identificar eventos que devem gerar notificações
- [ ] Escolher método de integração (Trait, Service ou Observer)
- [ ] Implementar notificações nos pontos identificados
- [ ] Testar notificações em tempo real
- [ ] Verificar se emails são enviados (se necessário)
- [ ] Documentar integração no README do módulo

## 🐛 Troubleshooting

### Notificações não aparecem

1. Verificar se o módulo Notificacoes está habilitado
2. Verificar se o JavaScript está carregado (`resources/js/notifications.js`)
3. Verificar console do navegador para erros
4. Verificar se as rotas API estão acessíveis

### WebSockets não funcionam

1. Verificar configuração do BROADCAST_DRIVER
2. Verificar se Pusher está configurado corretamente
3. Verificar se o JavaScript do Pusher está carregado
4. O sistema automaticamente usa polling como fallback

### Email não é enviado

1. Verificar `NOTIFICACOES_EMAIL_ENABLED=true` no .env
2. Verificar configurações de email do Laravel
3. Verificar logs: `storage/logs/laravel.log`

## 📚 Recursos Adicionais

- [Documentação Laravel Broadcasting](https://laravel.com/docs/broadcasting)
- [Documentação Pusher](https://pusher.com/docs)
- [README do Módulo Notificações](../Notificacoes/README.md)

---

**Desenvolvido por:** Vertex Solutions LTDA  
**Desenvolvedor:** Reinan Rodrigues  
**Data:** Janeiro 2025

