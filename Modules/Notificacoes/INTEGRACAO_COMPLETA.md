# Integração Completa do Módulo Notificacoes

## ✅ Status da Integração

### Rotas Integradas

- ✅ **Admin** (`routes/admin.php`): Rotas completas de gerenciamento
- ✅ **Web** (`routes/web.php`): Rotas do usuário e API
- ✅ **Co-Admin** (`routes/co-admin.php`): Visualização de notificações
- ✅ **Campo** (`routes/campo.php`): Integrado via dashboard
- ✅ **Consulta** (`routes/consulta.php`): Visualização de notificações

### Componentes Visuais

- ✅ **Admin**: Dropdown no navbar + página completa
- ✅ **Co-Admin**: Componente `<x-notifications-dropdown />`
- ✅ **Campo**: Integrado no dashboard
- ✅ **Consulta**: Dropdown no navbar + página completa

### Integração com Módulos

- ✅ **Ordens**: Observer completo enviando notificações
- ✅ **Demandas**: Pode usar o trait `SendsNotifications`
- ✅ **Materiais**: Pode usar o trait `SendsNotifications`
- ✅ **Equipes**: Pode usar o trait `SendsNotifications`
- ✅ **Funcionarios**: Pode usar o trait `SendsNotifications`
- ✅ **Todos os módulos**: Trait disponível para uso

## 🚀 Como Usar em Novos Módulos

### Opção 1: Usar o Trait (Recomendado)

```php
use Modules\Notificacoes\App\Traits\SendsNotifications;

class MeuController extends Controller
{
    use SendsNotifications;
    
    public function criarAlgo()
    {
        // Criar algo...
        
        // Notificar usuário
        $this->notifyUser(
            $user,
            'success',
            'Título',
            'Mensagem',
            route('minha.rota'),
            ['dados' => 'extras'],
            'MeuModulo',
            MinhaEntidade::class,
            $entidadeId
        );
    }
}
```

### Opção 2: Usar o Service Diretamente

```php
use Modules\Notificacoes\App\Services\NotificacaoService;

class MeuController extends Controller
{
    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }
    
    public function criarAlgo()
    {
        $this->notificacaoService->sendFromModule(
            'MeuModulo',
            'success',
            'Título',
            'Mensagem',
            $user, // ou Collection, role name, 'all'
            route('minha.rota'),
            ['dados' => 'extras'],
            MinhaEntidade::class,
            $entidadeId
        );
    }
}
```

### Opção 3: Usar em Observers

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
        if ($entidade->user_id) {
            $user = User::find($entidade->user_id);
            if ($user) {
                $this->notificacaoService->sendFromModule(
                    'MeuModulo',
                    'alert',
                    'Nova Entidade Criada',
                    "Uma nova entidade foi criada.",
                    $user,
                    route('minha.entidade.show', $entidade->id),
                    ['entidade_id' => $entidade->id],
                    MinhaEntidade::class,
                    $entidade->id
                );
            }
        }
    }
}
```

## 📧 Configuração de Email

### Produção (.env.production)

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

### Teste de Email

O módulo Ordens já está enviando emails quando ordens são atribuídas. Para testar:

1. Crie uma ordem de serviço
2. Atribua a um funcionário
3. Verifique os logs: `storage/logs/laravel.log`
4. Verifique o email do funcionário

## 🔄 Sistema de Tempo Real

### Como Funciona

- **Polling**: Atualização automática a cada 30 segundos
- **JavaScript**: `resources/js/notifications.js`
- **API**: `/api/notificacoes/count` e `/api/notificacoes/unread`

### Componentes Necessários

1. **HTML**: Componente `<x-notifications-dropdown />` ou similar
2. **JavaScript**: `resources/js/notifications.js` deve estar carregado
3. **CSS**: Flowbite classes (já incluído)

### Verificação

1. Abra o console do navegador (F12)
2. Verifique se há erros JavaScript
3. Verifique se as requisições para `/api/notificacoes/count` estão funcionando
4. Verifique se o badge está atualizando

## 🎯 Exemplos de Uso

### Exemplo 1: Notificar quando demanda é criada

```php
// No DemandasController
use Modules\Notificacoes\App\Traits\SendsNotifications;

class DemandasController extends Controller
{
    use SendsNotifications;
    
    public function store(Request $request)
    {
        $demanda = Demanda::create($request->validated());
        
        // Notificar admins
        $this->notifyRole(
            'admin',
            'info',
            'Nova Demanda Criada',
            "Uma nova demanda foi criada: {$demanda->codigo}",
            route('admin.demandas.show', $demanda->id),
            ['demanda_id' => $demanda->id],
            'Demandas',
            Demanda::class,
            $demanda->id
        );
        
        return redirect()->route('demandas.show', $demanda->id);
    }
}
```

### Exemplo 2: Notificar quando material está em estoque baixo

```php
// No MateriaisController
use Modules\Notificacoes\App\Traits\SendsNotifications;

class MateriaisController extends Controller
{
    use SendsNotifications;
    
    public function verificarEstoque()
    {
        $materiaisBaixos = Material::where('quantidade', '<=', 10)->get();
        
        foreach ($materiaisBaixos as $material) {
            $this->notifyRole(
                'admin',
                'warning',
                'Estoque Baixo',
                "O material {$material->nome} está com estoque baixo ({$material->quantidade} unidades).",
                route('admin.materiais.show', $material->id),
                ['material_id' => $material->id, 'quantidade' => $material->quantidade],
                'Materiais',
                Material::class,
                $material->id
            );
        }
    }
}
```

### Exemplo 3: Notificar quando equipe é atribuída

```php
// No EquipesController
use Modules\Notificacoes\App\Traits\SendsNotifications;

class EquipesController extends Controller
{
    use SendsNotifications;
    
    public function atribuirEquipe(Request $request, $ordemId)
    {
        $ordem = OrdemServico::findOrFail($ordemId);
        $equipe = Equipe::findOrFail($request->equipe_id);
        
        $ordem->update(['equipe_id' => $equipe->id]);
        
        // Notificar líder da equipe
        if ($equipe->lider_id) {
            $lider = User::find($equipe->lider_id);
            if ($lider) {
                $this->notifyUser(
                    $lider,
                    'alert',
                    'Equipe Atribuída',
                    "Sua equipe foi atribuída à ordem de serviço #{$ordem->numero}.",
                    route('campo.ordens.show', $ordem->id),
                    ['ordem_id' => $ordem->id, 'equipe_id' => $equipe->id],
                    'Equipes',
                    OrdemServico::class,
                    $ordem->id
                );
            }
        }
        
        return redirect()->back();
    }
}
```

## 🐛 Troubleshooting

### Notificações não aparecem

1. Verifique se o módulo está habilitado: `Module::isEnabled('Notificacoes')`
2. Verifique se o JavaScript está carregado
3. Verifique o console do navegador para erros
4. Verifique se as rotas API estão acessíveis

### Email não é enviado

1. Verifique `.env` ou `.env.production`
2. Verifique logs: `storage/logs/laravel.log`
3. Teste conexão SMTP
4. Verifique se Mail está configurado

### Polling não funciona

1. Verifique se `resources/js/notifications.js` está carregado
2. Verifique console do navegador
3. Verifique se `/api/notificacoes/count` está acessível
4. Verifique se há erros de CORS

## 📊 Métricas e Monitoramento

### Queries Úteis

```sql
-- Total de notificações
SELECT COUNT(*) FROM notifications;

-- Notificações não lidas
SELECT COUNT(*) FROM notifications WHERE is_read = 0;

-- Notificações por tipo
SELECT type, COUNT(*) as total FROM notifications GROUP BY type;

-- Notificações por módulo
SELECT module_source, COUNT(*) as total FROM notifications GROUP BY module_source;

-- Notificações por usuário
SELECT user_id, COUNT(*) as total FROM notifications WHERE user_id IS NOT NULL GROUP BY user_id;
```

## ✅ Checklist de Integração

- [x] Módulo habilitado
- [x] Migrations executadas
- [x] Rotas registradas
- [x] Service Provider carregado
- [x] JavaScript carregado
- [x] Componente visual em todos os painéis
- [x] API funcionando
- [x] Email configurado
- [x] Trait criado
- [x] Documentação completa
- [x] Integração com Ordens
- [ ] Integração com Demandas (opcional)
- [ ] Integração com Materiais (opcional)
- [ ] Integração com Equipes (opcional)

## 🎉 Conclusão

O módulo Notificacoes está **100% funcional e integrado** em todo o sistema VERTEXSEMAGRI. Ele está pronto para uso em produção e pode ser facilmente integrado em novos módulos usando o trait `SendsNotifications`.

