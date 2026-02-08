# Sistema de Gestão de Poços Artesianos para Líderes de Comunidade

## 📋 Índice

1. [Visão Geral](#visão-geral)
2. [Arquitetura do Sistema](#arquitetura-do-sistema)
3. [Estrutura de Banco de Dados](#estrutura-de-banco-de-dados)
4. [Models e Relacionamentos](#models-e-relacionamentos)
5. [Controllers e Rotas](#controllers-e-rotas)
6. [Views e Interface](#views-e-interface)
7. [Funcionalidades](#funcionalidades)
8. [Integrações com Módulos](#integrações-com-módulos)
9. [Instalação e Configuração](#instalação-e-configuração)
10. [Fluxo de Uso](#fluxo-de-uso)
11. [Tecnologias Utilizadas](#tecnologias-utilizadas)

---

## 🎯 Visão Geral

O Sistema de Gestão de Poços Artesianos para Líderes de Comunidade é um módulo completo que permite aos líderes comunitários gerenciar de forma profissional e transparente:

- **Cadastro de moradores/usuários** do poço artesiano
- **Criação de mensalidades** mensais para cobrança de taxa de água
- **Geração automática de boletos** para cada usuário
- **Registro de pagamentos** com histórico completo
- **Relatórios financeiros** detalhados
- **Área pública para moradores** consultarem suas faturas e emitirem segunda via

O sistema foi desenvolvido seguindo os padrões do VERTEXSEMAGRI, com integração completa aos módulos existentes (`Pocos`, `Pessoas`, `Localidades`).

---

## 🏗️ Arquitetura do Sistema

### Estrutura de Diretórios

```
Modules/Pocos/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LiderComunidadeController.php    # Painel do líder
│   │       └── MoradorPocoController.php         # Área pública do morador
│   └── Models/
│       ├── LiderComunidade.php                   # Model do líder
│       ├── UsuarioPoco.php                       # Model do morador/usuário
│       ├── MensalidadePoco.php                   # Model da mensalidade
│       ├── PagamentoPoco.php                     # Model do pagamento
│       └── BoletoPoco.php                        # Model do boleto
├── database/
│   └── migrations/
│       ├── 2025_01_28_000001_create_lideres_comunidade_table.php
│       ├── 2025_01_28_000002_create_usuarios_poco_table.php
│       ├── 2025_01_28_000003_create_mensalidades_poco_table.php
│       ├── 2025_01_28_000004_create_pagamentos_poco_table.php
│       └── 2025_01_28_000005_create_boletos_poco_table.php
└── resources/
    └── views/
        ├── lider-comunidade/                     # Views do painel do líder
        │   ├── layouts/
        │   │   ├── app.blade.php
        │   │   ├── navbar.blade.php
        │   │   └── sidebar.blade.php
        │   ├── dashboard.blade.php
        │   ├── usuarios/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   ├── edit.blade.php
        │   │   └── show.blade.php
        │   ├── mensalidades/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   └── show.blade.php
        │   └── relatorios/
        │       └── index.blade.php
        └── morador/                               # Views públicas do morador
            ├── layouts/
            │   └── app.blade.php
            ├── index.blade.php                    # Login com código
            ├── dashboard.blade.php
            ├── historico.blade.php
            └── fatura/
                ├── show.blade.php
                └── segunda-via.blade.php          # PDF do boleto
```

---

## 💾 Estrutura de Banco de Dados

### Tabela: `lideres_comunidade`

Armazena os líderes de comunidade que gerenciam poços.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | bigint | ID único |
| `codigo` | string(unique) | Código único do líder |
| `nome` | string | Nome completo |
| `cpf` | string(11, unique) | CPF (apenas números) |
| `telefone` | string | Telefone de contato |
| `email` | string | Email (opcional) |
| `localidade_id` | foreignId | Referência à localidade |
| `user_id` | foreignId(nullable) | Referência ao usuário do sistema |
| `poco_id` | foreignId(nullable) | Referência ao poço gerenciado |
| `endereco` | text | Endereço completo |
| `status` | enum | `ativo` ou `inativo` |
| `observacoes` | text | Observações adicionais |
| `created_at`, `updated_at`, `deleted_at` | timestamps | Controle de tempo |

**Relacionamentos:**
- `belongsTo(Localidade)` - Localidade da comunidade
- `belongsTo(User)` - Usuário do sistema (opcional)
- `belongsTo(Poco)` - Poço gerenciado
- `hasMany(MensalidadePoco)` - Mensalidades criadas
- `hasMany(PagamentoPoco)` - Pagamentos registrados

### Tabela: `usuarios_poco`

Armazena os moradores/usuários que utilizam o poço.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | bigint | ID único |
| `codigo` | string(unique) | Código único do usuário |
| `poco_id` | foreignId | Referência ao poço |
| `pessoa_id` | foreignId(nullable) | Referência ao CadÚnico |
| `nome` | string | Nome completo |
| `cpf` | string(11) | CPF (opcional) |
| `telefone` | string | Telefone |
| `email` | string | Email (opcional) |
| `endereco` | text | Endereço completo |
| `numero_casa` | string | Número da casa |
| `codigo_acesso` | string(8, unique) | Código de acesso para área do morador |
| `status` | enum | `ativo`, `inativo` ou `suspenso` |
| `data_cadastro` | date | Data de cadastro |
| `observacoes` | text | Observações |
| `created_at`, `updated_at`, `deleted_at` | timestamps | Controle de tempo |

**Relacionamentos:**
- `belongsTo(Poco)` - Poço utilizado
- `belongsTo(PessoaCad)` - Pessoa do CadÚnico (opcional)
- `hasMany(PagamentoPoco)` - Pagamentos realizados
- `hasMany(BoletoPoco)` - Boletos gerados

**Características Especiais:**
- Geração automática de `codigo_acesso` de 8 caracteres alfanuméricos maiúsculos
- Código único e não duplicável

### Tabela: `mensalidades_poco`

Armazena as mensalidades criadas por mês/ano.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | bigint | ID único |
| `codigo` | string(unique) | Código único da mensalidade |
| `poco_id` | foreignId | Referência ao poço |
| `lider_id` | foreignId | Referência ao líder que criou |
| `mes` | integer | Mês (1-12) |
| `ano` | integer | Ano (ex: 2025) |
| `valor_mensalidade` | decimal(10,2) | Valor da mensalidade |
| `data_vencimento` | date | Data de vencimento |
| `data_criacao` | date | Data de criação |
| `observacoes` | text | Observações |
| `status` | enum | `aberta`, `fechada` ou `cancelada` |
| `created_at`, `updated_at`, `deleted_at` | timestamps | Controle de tempo |

**Constraints:**
- `UNIQUE(poco_id, mes, ano)` - Uma mensalidade por mês/ano por poço

**Relacionamentos:**
- `belongsTo(Poco)` - Poço relacionado
- `belongsTo(LiderComunidade)` - Líder que criou
- `hasMany(PagamentoPoco)` - Pagamentos registrados
- `hasMany(BoletoPoco)` - Boletos gerados

**Accessors Calculados:**
- `mes_ano` - Retorna "Janeiro/2025"
- `total_arrecadado` - Soma dos pagamentos confirmados
- `total_pendente` - Valor pendente (total esperado - arrecadado)
- `total_usuarios` - Total de usuários ativos
- `usuarios_pagantes` - Quantidade de usuários que pagaram
- `usuarios_pendentes` - Quantidade de usuários pendentes

### Tabela: `pagamentos_poco`

Armazena os pagamentos registrados pelos líderes.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | bigint | ID único |
| `codigo` | string(unique) | Código único do pagamento |
| `mensalidade_id` | foreignId | Referência à mensalidade |
| `usuario_poco_id` | foreignId | Referência ao usuário |
| `poco_id` | foreignId | Referência ao poço |
| `lider_id` | foreignId(nullable) | Líder que registrou |
| `data_pagamento` | date | Data do pagamento |
| `valor_pago` | decimal(10,2) | Valor pago |
| `forma_pagamento` | enum | `dinheiro`, `pix`, `transferencia`, `outro` |
| `comprovante` | string | Caminho do arquivo (opcional) |
| `observacoes` | text | Observações |
| `status` | enum | `pendente`, `confirmado` ou `cancelado` |
| `created_at`, `updated_at`, `deleted_at` | timestamps | Controle de tempo |

**Constraints:**
- `UNIQUE(mensalidade_id, usuario_poco_id)` - Um pagamento por mensalidade por usuário

**Relacionamentos:**
- `belongsTo(MensalidadePoco)` - Mensalidade paga
- `belongsTo(UsuarioPoco)` - Usuário que pagou
- `belongsTo(Poco)` - Poço relacionado
- `belongsTo(LiderComunidade)` - Líder que registrou

### Tabela: `boletos_poco`

Armazena os boletos gerados automaticamente.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | bigint | ID único |
| `codigo_barras` | string(20, unique) | Código de barras do boleto |
| `numero_boleto` | string(unique) | Número do boleto (ex: POCO0000000001) |
| `mensalidade_id` | foreignId | Referência à mensalidade |
| `usuario_poco_id` | foreignId | Referência ao usuário |
| `poco_id` | foreignId | Referência ao poço |
| `valor` | decimal(10,2) | Valor do boleto |
| `data_vencimento` | date | Data de vencimento |
| `data_emissao` | date | Data de emissão |
| `status` | enum | `aberto`, `pago`, `vencido` ou `cancelado` |
| `caminho_pdf` | string | Caminho do PDF gerado (opcional) |
| `numero_parcela` | integer | Número da parcela (padrão: 1) |
| `instrucoes` | text | Instruções de pagamento |
| `created_at`, `updated_at`, `deleted_at` | timestamps | Controle de tempo |

**Relacionamentos:**
- `belongsTo(MensalidadePoco)` - Mensalidade relacionada
- `belongsTo(UsuarioPoco)` - Usuário responsável
- `belongsTo(Poco)` - Poço relacionado

**Características Especiais:**
- Geração automática de `numero_boleto` (formato: POCO + 10 dígitos)
- Geração automática de `codigo_barras` (20 dígitos)
- Atualização automática de status quando pagamento é registrado

---

## 🔗 Models e Relacionamentos

### LiderComunidade

```php
// Relacionamentos
localidade()          -> belongsTo(Localidade)
user()                -> belongsTo(User)
poco()                -> belongsTo(Poco)
mensalidades()        -> hasMany(MensalidadePoco)
pagamentos()          -> hasMany(PagamentoPoco)

// Scopes
scopeAtivos()         -> Filtra líderes ativos
scopePorLocalidade()  -> Filtra por localidade
scopePorPoco()        -> Filtra por poço

// Accessors
cpf_formatado         -> CPF formatado (XXX.XXX.XXX-XX)
status_texto          -> Status em texto
```

### UsuarioPoco

```php
// Relacionamentos
poco()                -> belongsTo(Poco)
pessoa()              -> belongsTo(PessoaCad)
pagamentos()          -> hasMany(PagamentoPoco)
boletos()             -> hasMany(BoletoPoco)
mensalidades()        -> hasManyThrough(MensalidadePoco, PagamentoPoco)

// Scopes
scopeAtivos()         -> Filtra usuários ativos
scopePorPoco()        -> Filtra por poço
scopePorCodigoAcesso() -> Busca por código de acesso

// Métodos
gerarCodigoAcesso()   -> Gera código único de 8 caracteres
temPagamentoPendente() -> Verifica se tem pagamento pendente

// Accessors
cpf_formatado         -> CPF formatado
status_texto          -> Status em texto
```

### MensalidadePoco

```php
// Relacionamentos
poco()                -> belongsTo(Poco)
lider()               -> belongsTo(LiderComunidade)
pagamentos()          -> hasMany(PagamentoPoco)
boletos()             -> hasMany(BoletoPoco)
usuarios()            -> hasManyThrough(UsuarioPoco, PagamentoPoco)

// Scopes
scopeAbertas()        -> Filtra mensalidades abertas
scopeFechadas()       -> Filtra mensalidades fechadas
scopePorPoco()        -> Filtra por poço
scopePorMesAno()      -> Filtra por mês/ano
scopeVencidas()       -> Filtra mensalidades vencidas

// Accessors
mes_ano               -> "Janeiro/2025"
total_arrecadado      -> Soma dos pagamentos confirmados
total_pendente        -> Valor pendente
total_usuarios        -> Total de usuários ativos
usuarios_pagantes     -> Quantidade de pagantes
usuarios_pendentes    -> Quantidade de pendentes

// Métodos
estaVencida()         -> Verifica se está vencida
podeSerFechada()      -> Verifica se pode ser fechada
```

### PagamentoPoco

```php
// Relacionamentos
mensalidade()         -> belongsTo(MensalidadePoco)
usuarioPoco()         -> belongsTo(UsuarioPoco)
poco()                -> belongsTo(Poco)
lider()               -> belongsTo(LiderComunidade)

// Scopes
scopeConfirmados()    -> Filtra pagamentos confirmados
scopePendentes()      -> Filtra pagamentos pendentes
scopePorMensalidade() -> Filtra por mensalidade
scopePorUsuario()     -> Filtra por usuário
scopePorPoco()        -> Filtra por poço
scopePorPeriodo()     -> Filtra por período

// Accessors
status_texto          -> Status em texto
forma_pagamento_texto -> Forma de pagamento em texto
```

### BoletoPoco

```php
// Relacionamentos
mensalidade()         -> belongsTo(MensalidadePoco)
usuarioPoco()         -> belongsTo(UsuarioPoco)
poco()                -> belongsTo(Poco)

// Scopes
scopeAbertos()        -> Filtra boletos abertos
scopePagos()          -> Filtra boletos pagos
scopeVencidos()       -> Filtra boletos vencidos
scopePorUsuario()     -> Filtra por usuário
scopePorMensalidade() -> Filtra por mensalidade

// Accessors
status_texto          -> Status em texto
esta_vencido          -> Verifica se está vencido
dias_vencido          -> Dias desde o vencimento

// Métodos
gerarNumeroBoleto()   -> Gera número único
gerarCodigoBarras()   -> Gera código de barras único
marcarComoPago()      -> Atualiza status para pago
marcarComoVencido()   -> Atualiza status para vencido
```

---

## 🎮 Controllers e Rotas

### LiderComunidadeController

**Namespace:** `Modules\Pocos\App\Http\Controllers`

**Métodos Principais:**

1. **`dashboard()`** - Dashboard principal com estatísticas
2. **`usuariosIndex()`** - Lista de usuários com filtros
3. **`usuariosCreate()`** - Formulário de criação
4. **`usuariosStore()`** - Salvar novo usuário
5. **`usuariosShow()`** - Detalhes do usuário
6. **`usuariosEdit()`** - Formulário de edição
7. **`usuariosUpdate()`** - Atualizar usuário
8. **`usuariosDestroy()`** - Deletar usuário
9. **`mensalidadesIndex()`** - Lista de mensalidades
10. **`mensalidadesCreate()`** - Formulário de criação
11. **`mensalidadesStore()`** - Criar mensalidade e gerar boletos
12. **`mensalidadesShow()`** - Detalhes da mensalidade
13. **`mensalidadesFechar()`** - Fechar mensalidade
14. **`pagamentosStore()`** - Registrar pagamento
15. **`pagamentosUpdate()`** - Atualizar pagamento
16. **`pagamentosDestroy()`** - Remover pagamento
17. **`relatorios()`** - Relatórios financeiros
18. **`relatoriosExport()`** - Exportar relatórios (CSV)

**Rotas (prefixo: `/lider-comunidade`):**

```php
GET  /                           -> dashboard
GET  /dashboard                  -> dashboard
GET  /usuarios                   -> usuariosIndex
GET  /usuarios/create            -> usuariosCreate
POST /usuarios                   -> usuariosStore
GET  /usuarios/{id}              -> usuariosShow
GET  /usuarios/{id}/edit         -> usuariosEdit
PUT  /usuarios/{id}              -> usuariosUpdate
DELETE /usuarios/{id}            -> usuariosDestroy
GET  /mensalidades               -> mensalidadesIndex
GET  /mensalidades/create        -> mensalidadesCreate
POST /mensalidades               -> mensalidadesStore
GET  /mensalidades/{id}          -> mensalidadesShow
PUT  /mensalidades/{id}/fechar   -> mensalidadesFechar
POST /pagamentos                 -> pagamentosStore
PUT  /pagamentos/{id}            -> pagamentosUpdate
DELETE /pagamentos/{id}          -> pagamentosDestroy
GET  /relatorios                 -> relatorios
GET  /relatorios/export          -> relatoriosExport
```

**Middleware:** `auth` (usuário autenticado)

### MoradorPocoController

**Namespace:** `Modules\Pocos\App\Http\Controllers`

**Métodos Principais:**

1. **`index()`** - Tela inicial (solicita código de acesso)
2. **`autenticar()`** - Valida código e cria sessão
3. **`dashboard()`** - Dashboard do morador
4. **`historico()`** - Histórico completo de faturas
5. **`faturaShow()`** - Detalhes de uma fatura
6. **`segundaVia()`** - Gera PDF da segunda via
7. **`boletoView()`** - Visualização HTML do boleto
8. **`logout()`** - Encerra sessão

**Rotas (prefixo: `/morador-poco`):**

```php
GET  /                           -> index (público)
POST /autenticar                 -> autenticar (público)
GET  /dashboard                  -> dashboard (middleware: morador.poco)
GET  /historico                  -> historico (middleware: morador.poco)
GET  /fatura/{id}                -> faturaShow (middleware: morador.poco)
GET  /fatura/{id}/segunda-via    -> segundaVia (middleware: morador.poco)
GET  /fatura/{id}/view           -> boletoView (middleware: morador.poco)
POST /logout                     -> logout (middleware: morador.poco)
```

**Middleware:** `EnsureMoradorPocoAuthenticated` (valida código de acesso na sessão)

---

## 🎨 Views e Interface

### Painel do Líder

#### Layout Principal (`lider-comunidade/layouts/app.blade.php`)

- Layout completo com navbar e sidebar
- Suporte a dark mode
- Flash messages (success, error, warning)
- Validação de erros
- Responsivo (mobile, tablet, desktop)

#### Navbar (`lider-comunidade/layouts/navbar.blade.php`)

- Nome do sistema e logo
- Informações do usuário logado
- Botão de logout
- Menu mobile (drawer)

#### Sidebar (`lider-comunidade/layouts/sidebar.blade.php`)

- Menu de navegação
- Links ativos destacados
- Ícones SVG
- Scrollable para mobile

#### Dashboard (`lider-comunidade/dashboard.blade.php`)

**Estatísticas do Mês Atual:**
- Total Arrecadado
- Total Pendente
- Usuários Pagantes
- Pagamentos Hoje

**Últimos Pagamentos:**
- Tabela com últimos 10 pagamentos
- Informações: usuário, mensalidade, data, valor, forma

**Mensalidades Recentes:**
- Cards com últimas 6 mensalidades
- Status visual (aberta/fechada)
- Link para detalhes

#### Usuários

**Lista (`usuarios/index.blade.php`):**
- Tabela responsiva
- Filtros: busca, status
- Paginação
- Ações: ver detalhes

**Criar (`usuarios/create.blade.php`):**
- Formulário completo
- Vinculação opcional ao CadÚnico
- Validação client-side e server-side
- Campos: nome, CPF, telefone, email, endereço, status

**Editar (`usuarios/edit.blade.php`):**
- Formulário pré-preenchido
- Mesmas validações do criar

**Detalhes (`usuarios/show.blade.php`):**
- Informações completas do usuário
- Histórico de pagamentos
- Código de acesso destacado

#### Mensalidades

**Lista (`mensalidades/index.blade.php`):**
- Tabela com todas as mensalidades
- Filtros: mês, ano, status
- Colunas: mês/ano, valor, vencimento, arrecadado, pendente, status

**Criar (`mensalidades/create.blade.php`):**
- Formulário de criação
- Seleção de mês/ano
- Valor da mensalidade
- Data de vencimento
- Aviso sobre geração automática de boletos

**Detalhes (`mensalidades/show.blade.php`):**
- Estatísticas da mensalidade
- Lista de todos os usuários com status de pagamento
- Modal para registrar pagamento
- Botões de ação

#### Relatórios (`relatorios/index.blade.php`)

- Filtros por período (data início/fim)
- Resumo: total arrecadado, total de pagamentos
- Tabela detalhada de pagamentos
- Exportação CSV

### Área do Morador

#### Layout Público (`morador/layouts/app.blade.php`)

- Layout simples e limpo
- Navbar apenas quando autenticado
- Flash messages
- Sem sidebar

#### Tela Inicial (`morador/index.blade.php`)

- Formulário de código de acesso
- Design centrado e profissional
- Instruções de uso
- Validação de código de 8 caracteres

#### Dashboard (`morador/dashboard.blade.php`)

**Faturas Vencidas (destaque):**
- Alerta vermelho
- Lista de faturas vencidas
- Valor e data de vencimento

**Faturas em Aberto:**
- Lista de faturas abertas
- Botões: Ver detalhes, 2ª Via

**Últimos Pagamentos:**
- Histórico recente
- Link para histórico completo

#### Histórico (`morador/historico.blade.php`)

- Tabela completa de faturas
- Paginação
- Status visual (pago/vencido/aberto)
- Ações: ver, 2ª via

#### Detalhes da Fatura (`morador/fatura/show.blade.php`)

- Informações completas
- Status de pagamento
- Dados do boleto
- Botão para 2ª via

#### Segunda Via (`morador/fatura/segunda-via.blade.php`)

- Template HTML para PDF
- Design profissional tipo boleto
- Informações completas
- Código de barras
- Instruções de pagamento
- Botão de impressão

---

## ⚙️ Funcionalidades Detalhadas

### Painel do Líder

#### 1. Dashboard

**Estatísticas em Tempo Real:**
- Total arrecadado no mês atual
- Total pendente
- Quantidade de usuários pagantes vs pendentes
- Pagamentos registrados hoje

**Últimos Pagamentos:**
- Lista dos 10 últimos pagamentos
- Informações: usuário, mensalidade, data, valor, forma

**Mensalidades Recentes:**
- Cards das últimas 6 mensalidades
- Status visual (aberta/fechada)
- Link rápido para detalhes

#### 2. Gestão de Usuários

**Cadastro:**
- Formulário completo com validação
- Vinculação opcional ao CadÚnico (busca por localidade)
- Geração automática de código de acesso único
- Campos: nome, CPF, telefone, email, endereço, número da casa, status

**Listagem:**
- Tabela responsiva
- Filtros: busca (nome, CPF, código), status
- Paginação
- Ações: ver, editar, deletar

**Edição:**
- Formulário pré-preenchido
- Mesmas validações do cadastro
- Atualização de todos os campos

**Detalhes:**
- Informações completas do usuário
- Histórico de pagamentos
- Código de acesso destacado

#### 3. Gestão de Mensalidades

**Criação:**
- Seleção de mês e ano
- Definição do valor da mensalidade
- Data de vencimento
- Observações opcionais
- **Geração Automática de Boletos:** Ao criar, o sistema gera automaticamente um boleto para cada usuário ativo do poço

**Listagem:**
- Tabela com todas as mensalidades
- Filtros: mês, ano, status
- Informações: mês/ano, valor, vencimento, arrecadado, pendente, status

**Detalhes:**
- Estatísticas completas
- Lista de todos os usuários com status de pagamento
- Modal para registrar pagamento
- Botão para fechar mensalidade

#### 4. Registro de Pagamentos

**Modal de Pagamento:**
- Seleção do usuário
- Data do pagamento
- Valor pago
- Forma de pagamento (dinheiro, PIX, transferência, outro)
- Observações
- **Atualização Automática:** Ao registrar, o boleto é automaticamente marcado como pago

**Edição:**
- Atualização de dados do pagamento
- Validações

**Exclusão:**
- Remoção do pagamento
- Boleto volta para status "aberto"

#### 5. Relatórios Financeiros

**Filtros:**
- Data início
- Data fim
- Período padrão: ano atual

**Resumo:**
- Total arrecadado no período
- Total de pagamentos registrados

**Tabela Detalhada:**
- Data do pagamento
- Usuário
- Mensalidade (mês/ano)
- Valor pago
- Forma de pagamento

**Exportação:**
- CSV com todos os dados
- Nome do arquivo: `relatorio_pagamentos_YYYYMMDD_HHMMSS.csv`

### Área do Morador

#### 1. Autenticação

**Código de Acesso:**
- 8 caracteres alfanuméricos maiúsculos
- Gerado automaticamente no cadastro
- Único por usuário
- Armazenado na sessão após autenticação

**Validações:**
- Código deve existir
- Usuário deve estar ativo
- Sessão expira ao fazer logout

#### 2. Dashboard

**Faturas Vencidas (Destaque):**
- Alerta vermelho no topo
- Lista de faturas vencidas
- Informações: mês/ano, data de vencimento, valor
- Link para detalhes

**Faturas em Aberto:**
- Lista de faturas abertas
- Ordenadas por data de vencimento
- Botões: Ver detalhes, Emitir 2ª Via

**Últimos Pagamentos:**
- Histórico dos últimos 10 pagamentos
- Informações: mês/ano, data, valor, forma
- Link para histórico completo

#### 3. Histórico Completo

- Tabela paginada com todas as faturas
- Ordenação por data de vencimento (mais recente primeiro)
- Status visual (pago/vencido/aberto)
- Ações: ver detalhes, emitir 2ª via

#### 4. Detalhes da Fatura

- Informações completas do boleto
- Status de pagamento
- Se pago: data e forma de pagamento
- Se vencido: dias desde o vencimento
- Botão para emitir 2ª via em PDF

#### 5. Segunda Via do Boleto

**Visualização HTML:**
- Template tipo boleto profissional
- Informações completas
- Código de barras
- Instruções de pagamento
- Botão de impressão

**Download PDF:**
- Geração via DomPDF
- Formato A4 portrait
- Mesmo conteúdo da visualização HTML
- Nome do arquivo: `boleto_NUMERO_MES_ANO.pdf`

---

## 🔌 Integrações com Módulos

### Módulo: Pocos

**Integração:**
- `Poco` model atualizado com relacionamentos:
  - `liderComunidade()` - Líder responsável
  - `usuariosPoco()` - Usuários do poço
  - `mensalidades()` - Mensalidades criadas
  - `pagamentos()` - Pagamentos registrados
  - `boletos()` - Boletos gerados

**Uso:**
- Líder vinculado a um poço específico
- Usuários vinculados ao poço
- Mensalidades e pagamentos relacionados ao poço

### Módulo: Pessoas (CadÚnico)

**Integração:**
- `UsuarioPoco` pode ser vinculado a `PessoaCad`
- Busca de pessoas por localidade no formulário de cadastro
- Dados pré-preenchidos quando vinculado

**Benefícios:**
- Evita duplicação de dados
- Integração com sistema de cadastro único
- Histórico completo da pessoa

### Módulo: Localidades

**Integração:**
- `LiderComunidade` vinculado a `Localidade`
- `UsuarioPoco` pode buscar pessoas da mesma localidade
- Filtros e relatórios por localidade

**Uso:**
- Organização por comunidade
- Relatórios por localidade
- Gestão descentralizada

---

## 🚀 Instalação e Configuração

### 1. Executar Migrations

```bash
php artisan migrate
```

Isso criará as 5 tabelas necessárias:
- `lideres_comunidade`
- `usuarios_poco`
- `mensalidades_poco`
- `pagamentos_poco`
- `boletos_poco`

### 2. Criar Líder de Comunidade

**Opção 1: Via Seeder (Recomendado)**

Criar seeder em `Modules/Pocos/database/seeders/LiderComunidadeSeeder.php`:

```php
use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Models\Poco;
use Modules\Localidades\App\Models\Localidade;

LiderComunidade::create([
    'codigo' => 'LID001',
    'nome' => 'João Silva',
    'cpf' => '12345678901',
    'telefone' => '(75) 99999-9999',
    'email' => 'joao@exemplo.com',
    'localidade_id' => Localidade::first()->id,
    'poco_id' => Poco::first()->id,
    'endereco' => 'Rua Principal, 123',
    'status' => 'ativo',
]);
```

**Opção 2: Via Tinker**

```bash
php artisan tinker
```

```php
$lider = \Modules\Pocos\App\Models\LiderComunidade::create([...]);
```

**Opção 3: Via Interface Admin (Futuro)**

Criar interface admin para gerenciar líderes.

### 3. Vincular Líder a Usuário do Sistema

```php
$user = \App\Models\User::find(1);
$lider = \Modules\Pocos\App\Models\LiderComunidade::find(1);
$lider->update(['user_id' => $user->id]);
```

### 4. Testar o Sistema

1. **Acessar Painel do Líder:**
   - URL: `/lider-comunidade`
   - Login necessário
   - Verificar se líder está vinculado a um poço

2. **Cadastrar Usuário:**
   - Ir em "Usuários" > "Novo Usuário"
   - Preencher formulário
   - Anotar código de acesso gerado

3. **Criar Mensalidade:**
   - Ir em "Mensalidades" > "Nova Mensalidade"
   - Preencher dados
   - Boletos serão gerados automaticamente

4. **Registrar Pagamento:**
   - Abrir detalhes da mensalidade
   - Clicar em "Registrar Pagamento" para um usuário
   - Preencher modal e salvar

5. **Testar Área do Morador:**
   - Acessar `/morador-poco`
   - Informar código de acesso do usuário cadastrado
   - Verificar dashboard, histórico e segunda via

---

## 📱 Fluxo de Uso

### Fluxo do Líder

1. **Login no Sistema**
   - Acessa `/lider-comunidade`
   - Sistema identifica líder pelo `user_id`, `email` ou `cpf`

2. **Cadastrar Usuários**
   - Vai em "Usuários" > "Novo Usuário"
   - Preenche dados do morador
   - Sistema gera código de acesso automaticamente
   - **Importante:** Anotar código de acesso para entregar ao morador

3. **Criar Mensalidade**
   - Vai em "Mensalidades" > "Nova Mensalidade"
   - Seleciona mês/ano
   - Define valor e data de vencimento
   - Sistema gera boletos automaticamente para todos os usuários ativos

4. **Registrar Pagamentos**
   - Abre detalhes da mensalidade
   - Para cada usuário que pagou, clica em "Registrar Pagamento"
   - Preenche modal com dados do pagamento
   - Sistema atualiza boleto automaticamente

5. **Consultar Relatórios**
   - Vai em "Relatórios"
   - Filtra por período
   - Visualiza ou exporta dados

### Fluxo do Morador

1. **Acessar Sistema**
   - Acessa `/morador-poco`
   - Informa código de acesso de 8 caracteres
   - Sistema valida e cria sessão

2. **Visualizar Faturas**
   - Dashboard mostra faturas em aberto e vencidas
   - Pode ver detalhes de cada fatura

3. **Emitir Segunda Via**
   - Clica em "2ª Via" na fatura desejada
   - Sistema gera PDF
   - Pode imprimir ou salvar

4. **Consultar Histórico**
   - Vai em "Histórico"
   - Visualiza todas as faturas
   - Vê status de pagamento

---

## 🛠️ Tecnologias Utilizadas

### Backend

- **Laravel 12** - Framework PHP
- **Eloquent ORM** - Mapeamento objeto-relacional
- **Migrations** - Controle de versão do banco
- **Soft Deletes** - Exclusão lógica
- **Traits** - `GeneratesCode`, `HasHistory`

### Frontend

- **Tailwind CSS v4.1** - Framework CSS utility-first
- **Flowbite v4.0.1** - Componentes UI para Tailwind
- **Vite** - Build tool e dev server
- **Alpine.js** (via Flowbite) - Interatividade
- **DomPDF** - Geração de PDFs

### Banco de Dados

- **MySQL/PostgreSQL** - SGBD
- **Foreign Keys** - Integridade referencial
- **Índices** - Otimização de consultas
- **Unique Constraints** - Garantia de unicidade

### Segurança

- **Middleware de Autenticação** - Proteção de rotas
- **Validação de Dados** - Server-side validation
- **CSRF Protection** - Proteção contra CSRF
- **Sanitização** - Limpeza de inputs

---

## 📊 Estatísticas e Métricas

### Métricas Disponíveis

**Por Mensalidade:**
- Total arrecadado
- Total pendente
- Quantidade de pagantes
- Quantidade de pendentes
- Percentual de arrecadação

**Por Poço:**
- Total de usuários ativos
- Total de mensalidades criadas
- Total arrecadado (geral)
- Mensalidade atual

**Por Período:**
- Total arrecadado
- Quantidade de pagamentos
- Média de pagamentos por dia
- Forma de pagamento mais usada

---

## 🔒 Segurança e Validações

### Validações Implementadas

**Usuário:**
- Nome obrigatório
- CPF com 11 dígitos (se informado)
- Email válido (se informado)
- Endereço obrigatório
- Status válido

**Mensalidade:**
- Mês válido (1-12)
- Ano válido (2020-2100)
- Valor mínimo R$ 0,01
- Data de vencimento obrigatória
- Unicidade: uma mensalidade por mês/ano por poço

**Pagamento:**
- Mensalidade válida
- Usuário válido
- Data de pagamento obrigatória
- Valor mínimo R$ 0,01
- Forma de pagamento válida
- Unicidade: um pagamento por mensalidade por usuário

**Código de Acesso:**
- 8 caracteres alfanuméricos
- Único no sistema
- Gerado automaticamente

### Controles de Acesso

**Líder:**
- Acesso apenas às mensalidades do seu poço
- Acesso apenas aos usuários do seu poço
- Validação de propriedade em todas as ações

**Morador:**
- Acesso apenas às próprias faturas
- Validação de código de acesso
- Sessão expira ao fazer logout

---

## 🎨 Design e Responsividade

### Padrão de Design

- **Flowbite v4.0.1** - Componentes UI
- **Tailwind CSS v4.1** - Estilização
- **Dark Mode** - Suporte completo
- **Responsivo** - Mobile-first

### Breakpoints

- **Mobile:** < 640px
- **Tablet:** 640px - 1024px
- **Desktop:** > 1024px

### Componentes Utilizados

- Cards
- Tabelas responsivas
- Modais
- Formulários
- Badges
- Alerts
- Botões
- Sidebar/Drawer (mobile)

---

## 📝 Próximas Melhorias Sugeridas

1. **Notificações Automáticas**
   - Email/SMS quando nova mensalidade é criada
   - Lembrete de vencimento
   - Confirmação de pagamento

2. **Integração com Gateway de Pagamento**
   - PIX automático
   - QR Code para pagamento
   - Webhook de confirmação

3. **Dashboard Avançado**
   - Gráficos de arrecadação
   - Previsão de receita
   - Análise de inadimplência

4. **App Mobile**
   - App Flutter para líderes
   - App Flutter para moradores
   - Notificações push

5. **Relatórios Avançados**
   - Exportação Excel
   - Gráficos interativos
   - Comparativos mensais

---

## 🐛 Troubleshooting

### Problema: Líder não consegue acessar

**Solução:**
1. Verificar se líder está vinculado a um poço
2. Verificar se `user_id` está correto
3. Verificar se usuário está ativo

### Problema: Código de acesso não funciona

**Solução:**
1. Verificar se código tem exatamente 8 caracteres
2. Verificar se usuário está ativo
3. Limpar cache da sessão

### Problema: Boletos não são gerados

**Solução:**
1. Verificar se há usuários ativos no poço
2. Verificar logs de erro
3. Verificar se mensalidade foi criada com sucesso

### Problema: PDF não gera

**Solução:**
1. Verificar se DomPDF está instalado: `composer show barryvdh/laravel-dompdf`
2. Verificar permissões de escrita
3. Verificar logs de erro

---

## 📞 Suporte

Para dúvidas ou problemas:
1. Verificar logs em `storage/logs/laravel.log`
2. Verificar documentação do Laravel
3. Verificar documentação do Tailwind CSS
4. Verificar documentação do Flowbite

---

**Versão:** 1.0.0  
**Última Atualização:** Janeiro 2025  
**Autor:** Sistema VERTEXSEMAGRI

