# Integração de Materiais com o Sistema

## Resumo das Correções Implementadas

Este documento descreve as correções realizadas para garantir a integração correta do módulo de Materiais com os módulos de Demandas, Equipes, Funcionários e Ordens de Serviço.

## Problemas Identificados e Corrigidos

### 1. Redundância no Campo `materiais_utilizados`
**Problema:** Existia um campo JSON `materiais_utilizados` na tabela `ordens_servico` que era redundante, pois já existe a tabela `ordem_servico_materiais` que faz a relação many-to-many corretamente.

**Solução:**
- Removido o campo `materiais_utilizados` do modelo `OrdemServico`
- Criada migration para remover o campo do banco de dados
- Atualizadas todas as referências para usar o relacionamento `materiais()`

### 2. Controle de Estoque Inconsistente
**Problema:** O `CampoOrdensController` estava atualizando o estoque diretamente com `decrement()` sem registrar a movimentação na tabela `material_movimentacoes`, quebrando o rastreamento.

**Solução:**
- Atualizado `CampoOrdensController` para usar os métodos `removerEstoque()` e `adicionarEstoque()` do modelo `Material`
- Esses métodos garantem que:
  - O estoque seja atualizado corretamente
  - A movimentação seja registrada automaticamente
  - Tudo seja feito em uma transação (atomicidade)

### 3. Falta de Rastreamento de Funcionário
**Problema:** Não havia rastreamento de qual funcionário carregou qual material.

**Solução:**
- Adicionado campo `funcionario_id` na tabela `material_movimentacoes`
- Criada migration para adicionar o campo
- Atualizados os métodos `adicionarEstoque()` e `removerEstoque()` para aceitar `funcionario_id`
- Atualizado `CampoOrdensController` para identificar automaticamente o funcionário a partir do usuário autenticado

### 4. Relacionamentos Faltantes
**Problema:** Faltavam relacionamentos para facilitar consultas e relatórios.

**Solução:**
- Adicionado relacionamento `funcionario()` no modelo `MaterialMovimentacao`
- Adicionados métodos auxiliares no modelo `OrdemServico`:
  - `getTotalMateriaisAttribute()`: Retorna o total de materiais
  - `getValorTotalMateriaisAttribute()`: Retorna o valor total dos materiais
  - `temMateriais()`: Verifica se a ordem tem materiais

## Estrutura de Relacionamentos

```
Demanda (1) ──> (1) OrdemServico (N) ──> (N) OrdemServicoMaterial (N) ──> (1) Material
                                                      │
                                                      └──> Registra movimentação
                                                           └──> MaterialMovimentacao
                                                                ├──> user_id (quem registrou)
                                                                ├──> funcionario_id (quem carregou)
                                                                └──> ordem_servico_id (origem)
```

## Fluxo de Uso de Materiais

1. **Demanda é criada** → Status: `aberta`
2. **Ordem de Serviço é criada** → Vinculada à demanda e atribuída a uma equipe/funcionário
3. **Funcionário inicia atendimento** → Status da OS: `em_execucao`
4. **Funcionário carrega materiais**:
   - Seleciona material e quantidade
   - Sistema verifica estoque disponível
   - Se disponível:
     - Cria registro em `ordem_servico_materiais`
     - Remove do estoque usando `removerEstoque()`
     - Registra movimentação em `material_movimentacoes` com:
       - Tipo: `saida`
       - Motivo: "Uso na ordem de serviço #XXX"
       - `funcionario_id`: Funcionário que carregou
       - `ordem_servico_id`: Ordem relacionada
5. **Se material for removido**:
   - Remove de `ordem_servico_materiais`
   - Restaura estoque usando `adicionarEstoque()`
   - Registra movimentação com tipo: `entrada`
6. **Ordem é concluída** → Status: `concluida`

## Garantias do Sistema

✅ **Controle de Estoque Automático**: Toda movimentação é registrada automaticamente
✅ **Rastreabilidade Completa**: Sabe-se quem, quando, onde e por quê cada material foi movimentado
✅ **Sem Redundâncias**: Dados são armazenados em um único lugar (normalização)
✅ **Transações Atômicas**: Operações de estoque são atômicas (tudo ou nada)
✅ **Validações**: Sistema verifica estoque antes de permitir saída
✅ **Integração Completa**: Materiais se relacionam corretamente com Demandas, Ordens, Equipes e Funcionários

## Arquivos Modificados

### Migrations
- `Modules/Materiais/database/migrations/2024_12_20_000001_fix_material_integration.php`

### Models
- `Modules/Materiais/app/Models/Material.php`
- `Modules/Materiais/app/Models/MaterialMovimentacao.php`
- `Modules/Ordens/app/Models/OrdemServico.php`

### Controllers
- `Modules/Ordens/app/Http/Controllers/Campo/CampoOrdensController.php`

### Views
- `Modules/Ordens/resources/views/show.blade.php`
- `resources/views/campo/ordens/show.blade.php` (já estava correto)

## Próximos Passos Recomendados

1. Executar a migration: `php artisan migrate`
2. Testar o fluxo completo de uso de materiais
3. Verificar relatórios de movimentação de materiais
4. Validar que o estoque está sendo atualizado corretamente

