# 🚀 Instruções de Deploy - Sistema de Monitoramento em Tempo Real

## ✅ Checklist de Instalação

### 1. Executar Migration

```bash
php artisan migrate
```

Esta migration criará os seguintes campos na tabela `funcionarios`:
- `status_campo` (disponivel, em_atendimento, pausado, offline)
- `ordem_servico_atual_id` (FK para ordens_servico)
- `atendimento_iniciado_em` (timestamp)
- `ultima_atualizacao_status` (timestamp)

### 2. Limpar Cache

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Verificar Rotas

```bash
php artisan route:list --path=funcionarios/status
```

**Rotas Esperadas:**

✅ Admin:
- `GET /admin/funcionarios/status`
- `GET /admin/funcionarios/status/atualizar`
- `POST /admin/funcionarios/status/{id}/forcar-liberacao`
- `POST /admin/funcionarios/status/{id}/status`
- `GET /admin/funcionarios/status/{id}/detalhes`

✅ Co-Admin:
- `GET /co-admin/funcionarios/status`
- `GET /co-admin/funcionarios/status/atualizar`
- `GET /co-admin/funcionarios/status/{id}/detalhes`

### 4. Verificar Observer

Confirme que o Observer está registrado:

```php
// Modules/Ordens/app/Providers/OrdensServiceProvider.php
\Modules\Ordens\App\Models\OrdemServico::observe(
    \Modules\Ordens\App\Observers\OrdemServicoStatusObserver::class
);
```

### 5. Testar o Sistema

#### Teste 1: Acesso ao Painel

1. Login como Admin
2. Acesse: `/admin/funcionarios/status`
3. Deve ver dashboard com estatísticas

#### Teste 2: Iniciar Atendimento

1. Login como funcionário de campo
2. Acesse uma ordem pendente
3. Clique "Iniciar Atendimento"
4. Verifique no painel admin: status mudou para "Em Atendimento" ✅

#### Teste 3: Bloqueio de Atribuição

1. Com funcionário em atendimento
2. Tente atribuir nova ordem ao mesmo funcionário
3. Deve receber mensagem: "Funcionário está em atendimento da OS #XXX" ✅

#### Teste 4: Conclusão Automática

1. Funcionário conclui a ordem
2. Verifique no painel: status voltou para "Disponível" ✅

#### Teste 5: Forçar Liberação

1. No painel admin, funcionário em atendimento
2. Clique "Forçar Liberação"
3. Informe motivo
4. Funcionário liberado, ordem volta para "Pendente" ✅

#### Teste 6: Atualização em Tempo Real

1. Abra o painel em duas abas
2. Em uma, inicie um atendimento
3. Na outra, aguarde 15s
4. Status deve atualizar automaticamente ✅

## 🎯 Como Usar no Dia a Dia

### Para Admin/Co-Admin

1. **Monitorar Equipe:**
   - Acesse `/admin/funcionarios/status`
   - Veja quem está disponível/ocupado
   - Monitore tempo de atendimento

2. **Atribuir Ordens:**
   - Ao criar ordem, escolha funcionário disponível (verde)
   - Sistema bloqueia funcionários ocupados
   - Se necessário, force liberação

3. **Emergências:**
   - Use "Forçar Liberação" para emergências
   - Sempre informe o motivo

### Para Funcionário de Campo

1. **Iniciar Atendimento:**
   - Entre na ordem atribuída
   - Clique "Iniciar Atendimento"
   - Status muda automaticamente

2. **Durante Atendimento:**
   - Upload de fotos
   - Adicionar materiais
   - Preencher relatório

3. **Concluir:**
   - Clique "Concluir Ordem"
   - Status volta para disponível automaticamente

## 🔧 Configurações Opcionais

### Alterar Intervalo de Atualização

Edite `Modules/Funcionarios/resources/views/admin/status/index.blade.php`:

```javascript
// Linha ~350
updateInterval = setInterval(() => {
    atualizarDados();
}, 15000); // 15 segundos (altere conforme necessário)
```

### Personalizar Cores dos Status

Edite `Modules/Funcionarios/resources/views/components/status-badge.blade.php`:

```php
$statusClasses = [
    'disponivel' => 'bg-emerald-100 text-emerald-800',
    'em_atendimento' => 'bg-amber-100 text-amber-800',
    'pausado' => 'bg-blue-100 text-blue-800',
    'offline' => 'bg-gray-100 text-gray-800',
];
```

## 🚨 Troubleshooting

### Erro: "Table 'funcionarios' doesn't have column 'status_campo'"

**Solução:** Execute a migration:
```bash
php artisan migrate
```

### Erro: Status não atualiza

**Verificar:**
1. JavaScript está carregando?
2. Console do navegador tem erros?
3. Rota `/admin/funcionarios/status/atualizar` está acessível?

**Solução:**
```bash
php artisan route:clear
php artisan view:clear
```

### Erro: Funcionário travado em "Em Atendimento"

**Solução:** Forçar liberação via Admin Panel ou:

```php
$funcionario = \Modules\Funcionarios\App\Models\Funcionario::find($id);
$funcionario->finalizarAtendimento();
```

### Erro: Observer não está funcionando

**Verificar:** Observer registrado no ServiceProvider:

```php
// Modules/Ordens/app/Providers/OrdensServiceProvider.php
public function boot(): void
{
    // ...
    \Modules\Ordens\App\Models\OrdemServico::observe(
        \Modules\Ordens\App\Observers\OrdemServicoStatusObserver::class
    );
}
```

## 📊 Logs e Monitoramento

Todos os eventos são logados em `storage/logs/laravel.log`:

```
[2025-12-06 10:30:00] local.INFO: Atendimento iniciado {"funcionario_id":1,"ordem_servico_id":123}
[2025-12-06 11:15:00] local.INFO: Atendimento finalizado {"funcionario_id":1,"ordem_servico_id":123,"tempo_execucao":45}
```

Monitore regularmente para identificar problemas.

## 🔐 Permissões

Certifique-se que os papéis têm as permissões corretas:

- **Admin:** Acesso total (forçar liberação, atualizar status manualmente)
- **Co-Admin:** Acesso de visualização (sem forçar liberação)
- **Campo:** Apenas suas próprias ordens

## 📱 Responsividade

O painel é totalmente responsivo:
- Desktop: Grid completo com todas as informações
- Tablet: Grid adaptado com 2 colunas
- Mobile: Lista vertical otimizada

## 🎨 Componentes Disponíveis

Use nos seus Blade templates:

```blade
<!-- Badge de Status -->
<x-funcionarios::status-badge :funcionario="$funcionario" />

<!-- Alerta de Em Atendimento -->
<x-funcionarios::alerta-em-atendimento :funcionario="$funcionario" />
```

## 📈 Melhorias Futuras Sugeridas

1. **Notificações Push:** Avisar funcionário quando ordem é atribuída
2. **Histórico Detalhado:** Relatório de todos os atendimentos
3. **Mapa em Tempo Real:** Visualizar localização dos funcionários
4. **Dashboard para Funcionário:** Painel próprio com suas estatísticas
5. **Alertas de Tempo:** Avisar se atendimento está demorando muito

## ✅ Checklist Final

Antes de ir para produção:

- [ ] Migration executada
- [ ] Rotas verificadas
- [ ] Observer registrado
- [ ] Testes executados
- [ ] Cache limpo
- [ ] Logs monitorados
- [ ] Permissões configuradas
- [ ] Equipe treinada

## 📞 Suporte

Em caso de dúvidas ou problemas:

**Reinan Rodrigues**  
CEO - Vertex Solutions  
E-mail: r.rodriguesjs@gmail.com  
WhatsApp: +5575992034656

---

**VERTEXSEMAGRI** - Sistema de Gestão Municipal  
Desenvolvido com ❤️ por **Vertex Solutions LTDA**

