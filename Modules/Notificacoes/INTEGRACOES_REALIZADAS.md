# Integrações de Notificações Realizadas

## ✅ Integrações Completas

### 1. Módulo Demandas ✅

**Arquivo**: `Modules/Demandas/app/Http/Controllers/DemandasController.php`

**Integração**: 
- Notificação quando demanda é criada no método `store()`
- Notifica role `admin` sobre nova demanda
- Notifica role `co-admin` se demanda é urgente
- Tipo de notificação varia conforme prioridade (urgente = alert, alta = warning, outras = info)

**Código**:
```php
use Modules\Notificacoes\App\Traits\SendsNotifications;

class DemandasController extends Controller
{
    use SendsNotifications;
    
    // No método store(), após criar demanda:
    $this->notifyRole('admin', $tipoNotificacao, 'Nova Demanda Criada', ...);
    if ($demanda->prioridade === 'urgente') {
        $this->notifyRole('co-admin', 'alert', 'Demanda Urgente Criada', ...);
    }
}
```

### 2. Módulo Materiais ✅

**Arquivos**:
- `Modules/Materiais/app/Http/Controllers/MateriaisController.php`
- `Modules/Materiais/app/Observers/MaterialObserver.php` (NOVO)

**Integração**:
- Observer criado para verificar estoque baixo automaticamente
- Notificação quando estoque fica baixo (quantidade <= quantidade_minima)
- Notificação quando estoque zera (tipo 'error')
- Verificação no método `update()`, `create()`, `adicionarEstoque()` e `removerEstoque()`
- Evita spam: só notifica se não estava baixo antes OU se último alerta foi há mais de 24h
- Atualiza campo `ultimo_alerta_estoque` para controle

**Código**:
```php
// Observer registrado em MateriaisServiceProvider
Material::observe(MaterialObserver::class);

// Método verificarEstoqueBaixo() no Controller e Observer
protected function verificarEstoqueBaixo(Material $material, float $oldEstoque): void
{
    if ($estaBaixoAgora && (!$estavaBaixoAntes || !$material->ultimo_alerta_estoque || ...)) {
        $this->notifyRole('admin', $tipoNotificacao, 'Material com Estoque Baixo', ...);
        $material->update(['ultimo_alerta_estoque' => now()]);
    }
}
```

### 3. Módulo Equipes ✅

**Arquivo**: `Modules/Ordens/app/Observers/OrdemServicoObserver.php`

**Integração**:
- Notificação quando equipe é atribuída a uma ordem de serviço
- Notifica líder da equipe (tipo 'alert')
- Notifica todos os funcionários da equipe que têm usuário no sistema (tipo 'info')
- Funciona tanto na criação (`created`) quanto na atualização (`updated`) da ordem
- Evita duplicação: não notifica líder duas vezes

**Código**:
```php
// No método created() e updated()
if ($ordemServico->equipe_id) {
    $equipe = $ordemServico->equipe;
    
    // Notificar líder
    if ($equipe->lider_id) {
        $this->notificacaoService->sendFromModule('Equipes', 'alert', ...);
    }
    
    // Notificar funcionários
    foreach ($equipe->funcionarios as $funcionario) {
        if ($funcionario->email) {
            $user = User::where('email', $funcionario->email)->first();
            if ($user && $user->id !== $equipe->lider_id) {
                $this->notificacaoService->sendFromModule('Equipes', 'info', ...);
            }
        }
    }
}
```

## 📊 Resumo das Notificações

### Demandas
- **Quando**: Demanda criada
- **Destinatários**: Admins (sempre), Co-Admins (se urgente)
- **Tipo**: alert (urgente), warning (alta), info (outras)

### Materiais
- **Quando**: Estoque fica baixo ou zera
- **Destinatários**: Admins
- **Tipo**: error (sem estoque), warning (baixo estoque)
- **Frequência**: Máximo 1 por 24h por material

### Equipes
- **Quando**: Equipe atribuída a ordem de serviço
- **Destinatários**: Líder da equipe + Funcionários da equipe
- **Tipo**: alert (líder), info (funcionários)

## 🔧 Arquivos Modificados

1. ✅ `Modules/Demandas/app/Http/Controllers/DemandasController.php`
   - Adicionado trait `SendsNotifications`
   - Notificações no método `store()`

2. ✅ `Modules/Materiais/app/Http/Controllers/MateriaisController.php`
   - Adicionado trait `SendsNotifications`
   - Método `verificarEstoqueBaixo()` criado
   - Integrado em `create()`, `update()`, `adicionarEstoque()`, `removerEstoque()`

3. ✅ `Modules/Materiais/app/Observers/MaterialObserver.php` (NOVO)
   - Observer criado para verificação automática de estoque baixo
   - Registrado em `MateriaisServiceProvider`

4. ✅ `Modules/Ordens/app/Observers/OrdemServicoObserver.php`
   - Notificações de equipe adicionadas em `created()` e `updated()`

## ✅ Status Final

- ✅ **Demandas**: Integrado e funcionando
- ✅ **Materiais**: Integrado com Observer e funcionando
- ✅ **Equipes**: Integrado e funcionando

Todas as integrações estão completas e prontas para uso em produção!

