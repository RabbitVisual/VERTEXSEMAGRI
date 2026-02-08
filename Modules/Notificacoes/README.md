# Módulo de Notificações - VERTEXSEMAGRI

## 📋 Visão Geral

O módulo **Notificacoes** é um sistema completo de notificações em tempo real integrado ao VERTEXSEMAGRI. Ele permite enviar notificações para usuários, roles específicas ou todos os usuários do sistema, com suporte a diferentes tipos de notificações e integração com email.

## ✨ Funcionalidades

- ✅ **Notificações em Tempo Real**: Sistema completo com WebSockets (Pusher/Redis) e fallback automático para polling
- ✅ **Broadcasting Laravel**: Eventos Laravel para broadcasting em tempo real
- ✅ **Múltiplos Tipos**: info, success, warning, error, alert, system
- ✅ **Destinatários Flexíveis**: Usuário específico, role ou todos os usuários
- ✅ **Integração com Módulos**: Fácil integração com todos os módulos do sistema
- ✅ **Integração com Email**: Envio automático de emails com templates HTML (configurável)
- ✅ **API RESTful**: Endpoints completos para integração via API
- ✅ **Interface Admin**: Gerenciamento completo de notificações
- ✅ **Badge de Contador**: Contador de notificações não lidas em tempo real
- ✅ **Marcação de Lidas**: Marcar individual ou todas como lidas
- ✅ **Eventos Automáticos**: Sistema de eventos para notificações automáticas
- ✅ **Observers**: Suporte completo a Observers para notificações automáticas

## 🏗️ Estrutura

```
Modules/Notificacoes/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── NotificacoesAdminController.php
│   │   │   ├── Api/
│   │   │   │   └── NotificacoesApiController.php
│   │   │   └── NotificacoesController.php
│   ├── Models/
│   │   └── Notificacao.php
│   ├── Providers/
│   │   ├── EventServiceProvider.php
│   │   ├── NotificacoesServiceProvider.php
│   │   └── RouteServiceProvider.php
│   ├── Services/
│   │   └── NotificacaoService.php
│   └── Traits/
│       └── SendsNotifications.php (Helper para outros módulos)
├── database/
│   └── migrations/
│       └── 2025_11_19_205911_add_module_fields_to_notifications_table.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       └── index.blade.php
└── routes/
    ├── web.php
    └── api.php
```

## 🚀 Como Usar

### 1. Usando o Trait `SendsNotifications` (Recomendado)

O trait facilita o envio de notificações em controllers, observers e services:

```php
use Modules\Notificacoes\App\Traits\SendsNotifications;

class MeuController extends Controller
{
    use SendsNotifications;

    public function criarDemanda()
    {
        // Criar demanda...
        
        // Notificar usuário específico
        $this->notifyUser(
            $user,
            'success',
            'Demanda Criada',
            "A demanda #{$demanda->codigo} foi criada com sucesso.",
            route('demandas.show', $demanda->id),
            ['demanda_id' => $demanda->id],
            'Demandas',
            Demanda::class,
            $demanda->id
        );
        
        // Ou notificar uma role
        $this->notifyRole(
            'admin',
            'info',
            'Nova Demanda',
            "Uma nova demanda foi criada.",
            route('admin.demandas.index')
        );
    }
}
```

### 2. Usando o Service Diretamente

```php
use Modules\Notificacoes\App\Services\NotificacaoService;

class MeuController extends Controller
{
    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    public function minhaAcao()
    {
        // Enviar para usuário
        $this->notificacaoService->sendToUser(
            $userId,
            'alert',
            'Título',
            'Mensagem',
            route('minha.rota'),
            ['dados' => 'extras'],
            'MeuModulo',
            MinhaEntidade::class,
            $entidadeId
        );
        
        // Enviar para role
        $this->notificacaoService->sendToRole(
            'campo',
            'info',
            'Título',
            'Mensagem'
        );
        
        // Enviar para todos
        $this->notificacaoService->sendToAll(
            'system',
            'Manutenção',
            'O sistema passará por manutenção.'
        );
        
        // Método flexível
        $this->notificacaoService->sendFromModule(
            'MeuModulo',
            'success',
            'Título',
            'Mensagem',
            $recipients, // User, Collection, role name ou 'all'
            route('minha.rota'),
            ['dados' => 'extras'],
            MinhaEntidade::class,
            $entidadeId
        );
    }
}
```

### 3. Usando em Observers

Exemplo do módulo Ordens:

```php
use Modules\Notificacoes\App\Services\NotificacaoService;

class OrdemServicoObserver
{
    protected $notificacaoService;

    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    public function created(OrdemServico $ordemServico)
    {
        if ($ordemServico->funcionario_id) {
            $user = User::where('email', $ordemServico->funcionario->email)->first();
            if ($user) {
                $this->notificacaoService->sendFromModule(
                    'Ordens',
                    'alert',
                    'Nova Ordem de Serviço Atribuída',
                    "A ordem de serviço #{$ordemServico->numero} foi atribuída a você.",
                    $user,
                    route('campo.ordens.show', $ordemServico->id),
                    ['ordem_id' => $ordemServico->id],
                    OrdemServico::class,
                    $ordemServico->id
                );
            }
        }
    }
}
```

## 📡 API Endpoints

### Web API (via `/api/notificacoes`)

- `GET /api/notificacoes/unread` - Obter notificações não lidas
- `GET /api/notificacoes/count` - Obter contador de não lidas
- `GET /api/notificacoes` - Obter todas as notificações
- `POST /api/notificacoes/{id}/read` - Marcar como lida
- `POST /api/notificacoes/read-all` - Marcar todas como lidas

### Rotas Web

- `GET /notificacoes` - Listar notificações do usuário
- `POST /notificacoes/{id}/read` - Marcar como lida
- `POST /notificacoes/read-all` - Marcar todas como lidas
- `DELETE /notificacoes/{id}` - Deletar notificação

### Rotas Admin

- `GET /admin/notificacoes` - Listar todas as notificações (admin)
- `GET /admin/notificacoes/create` - Criar notificação (admin)
- `POST /admin/notificacoes` - Salvar notificação (admin)
- `GET /admin/notificacoes/{id}` - Ver detalhes (admin)
- `DELETE /admin/notificacoes/{id}` - Deletar (admin)

## 🎨 Tipos de Notificações

- **info**: Informação geral (azul)
- **success**: Sucesso/ação concluída (verde)
- **warning**: Aviso/atenção necessária (amarelo)
- **error**: Erro/problema (vermelho)
- **alert**: Alerta importante (laranja)
- **system**: Notificação do sistema (cinza)

## ⚙️ Configuração

### Email (Produção)

O módulo está configurado para usar as configurações de email do Laravel. Em produção, configure no `.env.production`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=contato@semagricm.com
MAIL_PASSWORD=">4Cbc0D"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="contato@semagricm.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Tempo Real (JavaScript)

O sistema suporta **WebSockets** (Pusher/Redis) com **fallback automático** para polling:

**Com WebSockets (Recomendado para Produção):**
- Notificações instantâneas via WebSockets
- Atualização automática do contador em tempo real
- Carregamento de notificações quando o dropdown é aberto
- Marcação de lidas em tempo real

**Com Polling (Fallback):**
- Polling automático a cada 30 segundos (configurável)
- Atualização automática do contador
- Carregamento de notificações quando o dropdown é aberto
- Marcação de lidas
- Pausa quando a aba não está visível

O arquivo `resources/js/notifications.js` gerencia automaticamente a escolha entre WebSockets e polling.

## 🔗 Integração com Outros Módulos

### Módulos Integrados

- ✅ **Ordens**: Notifica quando ordem é atribuída ou concluída
- ✅ **Demandas**: (Pode ser integrado)
- ✅ **Materiais**: (Pode ser integrado)
- ✅ **Equipes**: (Pode ser integrado)
- ✅ **Funcionarios**: (Pode ser integrado)

### Como Integrar em um Novo Módulo

1. **Usar o Trait** (Recomendado):

```php
use Modules\Notificacoes\App\Traits\SendsNotifications;

class MeuController extends Controller
{
    use SendsNotifications;
    
    public function minhaAcao()
    {
        $this->notifyUser($user, 'success', 'Título', 'Mensagem');
    }
}
```

2. **Registrar Observer** (se necessário):

```php
// No ServiceProvider do módulo
public function boot()
{
    MinhaEntidade::observe(MinhaEntidadeObserver::class);
}
```

3. **No Observer**:

```php
use Modules\Notificacoes\App\Services\NotificacaoService;

class MinhaEntidadeObserver
{
    protected $notificacaoService;
    
    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }
    
    public function created(MinhaEntidade $entidade)
    {
        // Enviar notificação...
    }
}
```

## 📊 Estrutura do Banco de Dados

```sql
CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_id` bigint UNSIGNED NULL,
  `role` varchar(255) NULL,
  `module_source` varchar(255) NULL,
  `entity_type` varchar(255) NULL,
  `entity_id` bigint UNSIGNED NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL,
  `data` longtext NULL,
  `action_url` varchar(255) NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`),
  INDEX `notifications_user_id_is_read_index`(`user_id`, `is_read`),
  INDEX `notifications_module_source_is_read_index`(`module_source`, `is_read`),
  INDEX `notifications_entity_type_entity_id_index`(`entity_type`, `entity_id`)
);
```

## 🎯 Boas Práticas

1. **Sempre especifique o módulo**: Use `module_source` para rastreabilidade
2. **Use action_url**: Facilite o acesso direto à entidade relacionada
3. **Inclua dados extras**: Use `data` para informações adicionais
4. **Escolha o tipo correto**: Use o tipo apropriado para cada situação
5. **Trate erros**: Use try-catch ao enviar notificações
6. **Não abuse**: Não envie notificações desnecessárias

## 🐛 Troubleshooting

### Notificações não aparecem

1. Verifique se o módulo está habilitado
2. Verifique se o JavaScript está carregado (`resources/js/notifications.js`)
3. Verifique o console do navegador para erros
4. Verifique se as rotas API estão acessíveis

### Email não é enviado

1. Verifique as configurações de email no `.env`
2. Verifique os logs: `storage/logs/laravel.log`
3. Teste a conexão SMTP
4. Verifique se o Mail está configurado corretamente

### Polling não funciona

1. Verifique se o JavaScript está carregado
2. Verifique o console do navegador
3. Verifique se a rota `/api/notificacoes/count` está acessível
4. Verifique se há erros de CORS

## 📝 Changelog

### v2.0.0 (Janeiro 2025) - ATUALIZAÇÃO COMPLETA
- ✅ **Sistema de Broadcasting**: Suporte completo a WebSockets (Pusher/Redis) com fallback para polling
- ✅ **Eventos Laravel**: Eventos `NotificacaoCriada` e `NotificacaoLida` para broadcasting
- ✅ **Email Aprimorado**: Templates HTML profissionais para emails
- ✅ **JavaScript Melhorado**: Suporte a WebSockets com fallback automático
- ✅ **Configuração Completa**: Arquivo de configuração dedicado
- ✅ **Migration Completa**: Migration para garantir estrutura da tabela
- ✅ **Documentação Completa**: Guia de integração para todos os módulos
- ✅ **Integração Total**: Pronto para integração com todos os 17 módulos do sistema

### v1.0.0
- Sistema completo de notificações
- Integração com tempo real (polling)
- API RESTful
- Interface admin
- Trait helper para outros módulos
- Integração com email
- Integração com módulo Ordens

## 👨‍💻 Desenvolvedor

**Vertex Solutions LTDA**  
**Desenvolvedor**: Reinan Rodrigues

## 📄 Licença

Proprietário - Vertex Solutions LTDA

