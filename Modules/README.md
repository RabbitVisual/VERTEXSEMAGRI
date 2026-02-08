# Sistema de Módulos VERTEXSEMAGRI

## 📋 Visão Geral

O **VERTEXSEMAGRI** é um sistema modular desenvolvido para gestão municipal, especialmente focado em secretarias de agricultura e desenvolvimento rural. O sistema utiliza uma arquitetura modular baseada em **Laravel Modules**, permitindo que cada funcionalidade seja desenvolvida, mantida e ativada/desativada independentemente.

## 🏗️ Arquitetura Modular

O sistema é construído sobre o pacote **nwidart/laravel-modules**, que permite:

- **Modularidade**: Cada módulo é uma unidade independente de código
- **Flexibilidade**: Módulos podem ser habilitados ou desabilitados conforme necessário
- **Escalabilidade**: Novos módulos podem ser adicionados sem afetar os existentes
- **Manutenibilidade**: Código organizado por funcionalidade, facilitando manutenção

## 📦 Estrutura de um Módulo

Cada módulo segue uma estrutura padronizada:

```
Modules/
└── NomeDoModulo/
    ├── module.json          # Configuração e metadados do módulo
    ├── app/
    │   ├── Http/
    │   │   └── Controllers/
    │   │       ├── Admin/   # Controllers administrativos
    │   │       └── ...      # Controllers públicos
    │   └── Models/          # Modelos Eloquent
    ├── routes/              # Rotas do módulo
    ├── resources/
    │   └── views/           # Views Blade
    ├── database/
    │   └── migrations/      # Migrações de banco de dados
    └── config/              # Arquivos de configuração
```

## 🔗 Integração e Relacionamentos entre Módulos

O sistema foi projetado com integração completa entre todos os módulos, garantindo que as informações fluam de forma coerente e sem redundâncias. A seguir, os principais relacionamentos:

### Fluxo Principal: Demanda → Ordem de Serviço → Execução

```
┌──────────┐      ┌──────────┐      ┌──────────┐      ┌──────────┐
│ Pessoas  │─────▶│ Demandas │─────▶│  Ordens  │─────▶│ Materiais│
└──────────┘      └──────────┘      └──────────┘      └──────────┘
     │                  │                  │                  │
     │                  │                  │                  │
     ▼                  ▼                  ▼                  ▼
┌──────────┐      ┌──────────┐      ┌──────────┐      ┌──────────┐
│Localidades│      │Infraest. │      │  Equipes │      │Funcionários│
└──────────┘      └──────────┘      └──────────┘      └──────────┘
```

### Relacionamentos por Módulo

#### 📍 Localidades (Módulo Central)
- **Relaciona com:**
  - `Pessoas`: Uma localidade tem muitas pessoas cadastradas
  - `Demandas`: Uma localidade tem muitas demandas
  - `Agua`: Redes de água por localidade
  - `Iluminacao`: Pontos de luz por localidade
  - `Estradas`: Trechos de estrada por localidade
  - `Pocos`: Poços artesianos por localidade

#### 📋 Demandas (Módulo Central de Atendimento)
- **Relaciona com:**
  - `Localidades`: Toda demanda pertence a uma localidade
  - `Pessoas`: Demanda pode estar vinculada a uma pessoa do CadÚnico
  - `Pocos`: Demanda pode estar diretamente relacionada a um poço (tipo 'poco')
  - `Ordens`: Uma demanda pode gerar uma ordem de serviço
  - `Agua`: Demandas de água relacionadas por localidade
  - `Iluminacao`: Demandas de iluminação relacionadas por localidade
  - `Estradas`: Demandas de estrada relacionadas por localidade

**Tipos de Demanda:**
- `agua`: Problemas com abastecimento de água, carro pipa, etc.
- `luz`: Poste quebrado, luz queimada, relé com problema, braço de poste danificado
- `estrada`: Buracos, estrada intransitável, ponte danificada
- `poco`: Bomba queimada, poço sem água, problemas elétricos no poço

#### 🔧 Ordens (Módulo de Execução)
- **Relaciona com:**
  - `Demandas`: Toda ordem de serviço está vinculada a uma demanda
  - `Equipes`: Ordem pode ser atribuída a uma equipe
  - `Funcionarios`: Ordem pode ter um funcionário específico atribuído
  - `Materiais`: Ordem utiliza materiais do estoque
  - `Users`: Usuários que abriram e executaram a ordem

#### 🌊 Agua (Infraestrutura)
- **Relaciona com:**
  - `Localidades`: Rede de água pertence a uma localidade
  - `Demandas`: Demandas de água na mesma localidade
  - `Ordens`: Ordens de serviço via demandas
  - `Equipes`: Equipes que executaram serviços
  - `Materiais`: Materiais utilizados nas ordens

#### 💡 Iluminacao (Infraestrutura)
- **Relaciona com:**
  - `Localidades`: Ponto de luz pertence a uma localidade
  - `Demandas`: Demandas de iluminação na mesma localidade (tipo 'luz')
  - `Ordens`: Ordens de serviço via demandas
  - `Equipes`: Equipes que executaram serviços
  - `Materiais`: Materiais utilizados (lâmpadas, relés, braços de poste, etc.)

#### 🛣️ Estradas (Infraestrutura)
- **Relaciona com:**
  - `Localidades`: Trecho de estrada pertence a uma localidade
  - `Demandas`: Demandas de estrada na mesma localidade (tipo 'estrada')
  - `Ordens`: Ordens de serviço via demandas
  - `Equipes`: Equipes que executaram serviços
  - `Materiais`: Materiais utilizados (cascalho, asfalto, etc.)

#### 🕳️ Pocos (Infraestrutura)
- **Relaciona com:**
  - `Localidades`: Poço pertence a uma localidade
  - `Demandas`: Demandas diretamente relacionadas ao poço (tipo 'poco', com `poco_id`)
  - `Ordens`: Ordens de serviço via demandas
  - `Equipes`: Equipe responsável pelo poço
  - `Materiais`: Materiais utilizados (peças de bomba, filtros, etc.)

#### 👨‍👩‍👧‍👦 Equipes (Gestão Operacional)
- **Relaciona com:**
  - `Funcionarios`: Equipe tem muitos funcionários
  - `Users`: Equipe pode ter um líder (User)
  - `Ordens`: Equipe executa ordens de serviço
  - `Pocos`: Equipe pode ser responsável por poços

#### 👷 Funcionarios (Gestão Operacional)
- **Relaciona com:**
  - `Equipes`: Funcionário pode pertencer a várias equipes
  - `Ordens`: Funcionário pode ser atribuído a ordens de serviço
  - `Materiais`: Funcionário pode solicitar materiais

#### 📦 Materiais (Gestão Operacional)
- **Relaciona com:**
  - `Ordens`: Material é utilizado em ordens de serviço
  - `MaterialMovimentacao`: Histórico de entradas e saídas
  - `Funcionarios`: Funcionário que solicitou/retirou material

#### 👥 Pessoas (Gestão Social)
- **Relaciona com:**
  - `Localidades`: Pessoa pertence a uma localidade
  - `Demandas`: Pessoa pode ter demandas registradas
  - `CAF`: Pessoa pode estar no Cadastro de Agricultores Familiares

#### 🌾 CAF (Agricultura)
- **Relaciona com:**
  - `Pessoas`: Agricultor familiar é uma pessoa cadastrada
  - `ProgramasAgricultura`: Agricultor pode participar de programas

#### 🌱 ProgramasAgricultura (Agricultura)
- **Relaciona com:**
  - `CAF`: Programa pode ter beneficiários do CAF
  - `Eventos`: Programa pode ter eventos relacionados
  - `Beneficiarios`: Programa tem beneficiários

## 🎯 Módulos Disponíveis

### Módulos de Infraestrutura

#### 🌊 Agua
Gestão completa de sistemas de abastecimento de água do município.

**Funcionalidades:**
- Cadastro de redes de água e pontos de distribuição
- Controle de qualidade da água
- Manutenção de infraestrutura hídrica
- Integração com demandas (carro pipa, falta de água, etc.)
- Rastreamento de ordens de serviço relacionadas

**Relacionamentos:**
- `Localidades`: Rede pertence a uma localidade
- `Demandas`: Demandas de água na mesma localidade
- `Ordens`: Ordens de serviço via demandas
- `Equipes`: Equipes que executaram serviços
- `Materiais`: Materiais utilizados (canos, conexões, etc.)

#### 💡 Iluminacao
Gestão completa de iluminação pública do município.

**Funcionalidades:**
- Cadastro de pontos de luz e postes
- Controle de manutenção preventiva
- Gestão de lâmpadas e equipamentos
- Mapeamento geográfico de iluminação
- Integração com demandas (poste quebrado, luz queimada, relé com problema, etc.)

**Relacionamentos:**
- `Localidades`: Ponto de luz pertence a uma localidade
- `Demandas`: Demandas de iluminação na mesma localidade (tipo 'luz')
- `Ordens`: Ordens de serviço via demandas
- `Equipes`: Equipes que executaram serviços
- `Materiais`: Materiais utilizados (lâmpadas, relés, braços de poste, etc.)

**Tipos Comuns de Demanda:**
- Poste público quebrado
- Luz queimada
- Relé com problema
- Braço de poste danificado
- Fiação danificada
- Poste tombado

#### 🛣️ Estradas
Gestão completa de estradas rurais e vias públicas do município.

**Funcionalidades:**
- Cadastro de trechos de estrada
- Controle de condições (boa, regular, ruim, péssima)
- Gestão de manutenção preventiva
- Mapeamento de infraestrutura viária
- Integração com demandas (buracos, estrada intransitável, etc.)

**Relacionamentos:**
- `Localidades`: Trecho pertence a uma localidade
- `Demandas`: Demandas de estrada na mesma localidade (tipo 'estrada')
- `Ordens`: Ordens de serviço via demandas
- `Equipes`: Equipes que executaram serviços
- `Materiais`: Materiais utilizados (cascalho, asfalto, etc.)

#### 🕳️ Pocos
Gestão completa de poços artesianos e sistemas de captação de água.

**Funcionalidades:**
- Cadastro de poços artesianos
- Controle de perfurações e características técnicas
- Gestão de sistemas de bombeamento
- Manutenção preventiva e corretiva
- Integração com demandas (bomba queimada, poço sem água, etc.)

**Relacionamentos:**
- `Localidades`: Poço pertence a uma localidade
- `Demandas`: Demandas diretamente relacionadas ao poço (tipo 'poco', com `poco_id`)
- `Ordens`: Ordens de serviço via demandas
- `Equipes`: Equipe responsável pelo poço
- `Materiais`: Materiais utilizados (peças de bomba, filtros, etc.)

### Módulos de Gestão Social

#### 👥 Pessoas
Gestão de pessoas do Cadastro Único (CadÚnico) e beneficiários do município.

**Funcionalidades:**
- Integração com CadÚnico
- Cadastro de beneficiários
- Gestão de cidadãos
- Histórico de atendimentos e demandas

**Relacionamentos:**
- `Localidades`: Pessoa pertence a uma localidade
- `Demandas`: Pessoa pode ter demandas registradas
- `CAF`: Pessoa pode estar no Cadastro de Agricultores Familiares

#### 📋 Demandas
Sistema central de gestão de demandas da população e atendimentos do município.

**Funcionalidades:**
- Cadastro de solicitações da população
- Acompanhamento completo de demandas
- Atendimento ao cidadão
- Histórico de requerimentos
- Geração automática de ordens de serviço

**Relacionamentos:**
- `Localidades`: Toda demanda pertence a uma localidade
- `Pessoas`: Demanda pode estar vinculada a uma pessoa do CadÚnico
- `Pocos`: Demanda pode estar diretamente relacionada a um poço
- `Ordens`: Uma demanda pode gerar uma ordem de serviço
- `Agua`, `Iluminacao`, `Estradas`: Demandas relacionadas por tipo e localidade

**Tipos de Demanda:**
- `agua`: Problemas com abastecimento, carro pipa, etc.
- `luz`: Poste quebrado, luz queimada, relé com problema, etc.
- `estrada`: Buracos, estrada intransitável, ponte danificada
- `poco`: Bomba queimada, poço sem água, problemas elétricos

### Módulos de Agricultura

#### 🌾 CAF (Cadastro de Agricultores Familiares)
Módulo completo de Cadastro de Agricultores Familiares integrado ao VERTEXSEMAGRI.

**Funcionalidades:**
- Cadastro de agricultores familiares
- Gestão de propriedades rurais
- Controle de produção
- Integração com programas governamentais

**Relacionamentos:**
- `Pessoas`: Agricultor familiar é uma pessoa cadastrada
- `ProgramasAgricultura`: Agricultor pode participar de programas

#### 🌱 ProgramasAgricultura
Gestão de programas de agricultura, políticas públicas rurais e projetos agrícolas.

**Funcionalidades:**
- Gestão de programas agrícolas
- Políticas públicas rurais
- Projetos e iniciativas
- Acompanhamento de resultados
- Gestão de eventos e inscrições

**Relacionamentos:**
- `CAF`: Programa pode ter beneficiários do CAF
- `Eventos`: Programa pode ter eventos relacionados
- `Beneficiarios`: Programa tem beneficiários

### Módulos de Gestão Operacional

#### 👷 Funcionarios
Gestão de funcionários públicos, cadastro de servidores e recursos humanos.

**Funcionalidades:**
- Cadastro de servidores
- Gestão de recursos humanos
- Controle de lotações
- Histórico funcional
- Vinculação com equipes

**Relacionamentos:**
- `Equipes`: Funcionário pode pertencer a várias equipes
- `Ordens`: Funcionário pode ser atribuído a ordens de serviço
- `Materiais`: Funcionário pode solicitar materiais

#### 👨‍👩‍👧‍👦 Equipes
Gestão de equipes de campo, funcionários e alocação de recursos.

**Funcionalidades:**
- Formação de equipes
- Alocação de recursos
- Controle de atividades de campo
- Gestão de veículos e equipamentos
- Estatísticas de produtividade

**Relacionamentos:**
- `Funcionarios`: Equipe tem muitos funcionários
- `Users`: Equipe pode ter um líder (User)
- `Ordens`: Equipe executa ordens de serviço
- `Pocos`: Equipe pode ser responsável por poços

#### 📦 Materiais
Gestão completa de materiais e estoque, controle de inventário e recursos.

**Funcionalidades:**
- Controle de estoque
- Gestão de inventário
- Entrada e saída de materiais
- Reserva de materiais para ordens de serviço
- Relatórios de consumo
- Alertas de estoque baixo

**Relacionamentos:**
- `Ordens`: Material é utilizado em ordens de serviço
- `MaterialMovimentacao`: Histórico de entradas e saídas
- `Funcionarios`: Funcionário que solicitou/retirou material

**Categorias de Materiais:**
- Lâmpadas, reatores, fios elétricos
- Canos, conexões hidráulicas, válvulas
- Peças para poços, bombas, filtros
- EPI, ferramentas, equipamentos de segurança
- Combustível, óleos, graxa
- Peças para máquinas e veículos

#### 🔧 Ordens
Sistema completo de gestão de ordens de serviço e controle de execução.

**Funcionalidades:**
- Criação de ordens de serviço a partir de demandas
- Acompanhamento de execução
- Controle de manutenção
- Histórico de serviços
- Gestão de materiais utilizados
- Fotos antes e depois
- Relatórios de execução

**Relacionamentos:**
- `Demandas`: Toda ordem está vinculada a uma demanda
- `Equipes`: Ordem pode ser atribuída a uma equipe
- `Funcionarios`: Ordem pode ter um funcionário específico
- `Materiais`: Ordem utiliza materiais do estoque
- `Users`: Usuários que abriram e executaram a ordem

**Status de Ordem:**
- `pendente`: Aguardando execução
- `em_execucao`: Em andamento
- `concluida`: Finalizada
- `cancelada`: Cancelada

### Módulos de Sistema

#### 🏠 Homepage
Gestão da página inicial do sistema, banners e conteúdo principal.

**Funcionalidades:**
- Gestão de banners
- Carousel de imagens
- Conteúdo da homepage
- Personalização visual

#### 📍 Localidades
Módulo central de gestão territorial do município.

**Funcionalidades:**
- Cadastro de bairros e distritos
- Gestão de divisão territorial
- Mapeamento geográfico
- Estatísticas por localidade

**Relacionamentos:**
- `Pessoas`: Uma localidade tem muitas pessoas
- `Demandas`: Uma localidade tem muitas demandas
- `Agua`, `Iluminacao`, `Estradas`, `Pocos`: Infraestrutura por localidade

#### 🔔 Notificacoes
Sistema de notificações, alertas e comunicações internas.

**Funcionalidades:**
- Notificações em tempo real
- Alertas do sistema
- Comunicações internas
- Histórico de mensagens

#### 📊 Relatorios
Sistema completo de relatórios e estatísticas.

**Funcionalidades:**
- Geração de relatórios
- Estatísticas e gráficos
- Exportação de dados (PDF, Excel, CSV)
- Análises personalizadas
- Dashboard com métricas gerais

## 🔄 Fluxo de Trabalho Padrão

### 1. Registro de Demanda
1. Cidadão solicita atendimento (presencial ou telefone)
2. Sistema registra demanda vinculada à localidade
3. Demanda pode estar vinculada a uma pessoa do CadÚnico
4. Demanda recebe tipo (agua, luz, estrada, poco) e prioridade

### 2. Criação de Ordem de Serviço
1. Administrador analisa demanda
2. Cria ordem de serviço vinculada à demanda
3. Atribui equipe e/ou funcionário
4. Define materiais necessários (opcional)

### 3. Execução
1. Equipe recebe ordem de serviço
2. Retira materiais do estoque (se necessário)
3. Executa serviço no local
4. Registra fotos antes e depois
5. Preenche relatório de execução

### 4. Conclusão
1. Ordem de serviço é concluída
2. Materiais são baixados definitivamente do estoque
3. Demanda é automaticamente concluída
4. Sistema registra histórico completo

## 📊 Estatísticas e Relatórios

Todos os módulos possuem AdminControllers padronizados com:

- **Estatísticas Gerais**: Total de registros, status, condições
- **Estatísticas de Demandas**: Abertas, em andamento, concluídas
- **Estatísticas de Ordens**: Pendentes, em execução, concluídas
- **Relacionamentos Visíveis**: Links para módulos relacionados
- **Histórico Completo**: Todas as ações e movimentações

### Padronização de Views Admin

Todas as views admin foram padronizadas para garantir:

✅ **Consistência Visual**: Layout uniforme em todos os módulos  
✅ **Informações Completas**: Exibição de todos os relacionamentos relevantes  
✅ **Estatísticas Visíveis**: Cards com métricas importantes  
✅ **Navegação Fácil**: Links para módulos relacionados  
✅ **Ações Rápidas**: Botões de ação contextualizados  
✅ **Responsividade**: Layout adaptável a diferentes tamanhos de tela  
✅ **Dark Mode**: Suporte completo a tema escuro  

**Módulos Padronizados:**
- ✅ Estradas
- ✅ Pocos
- ✅ Equipes
- ✅ Funcionarios
- ✅ Materiais
- ✅ Localidades
- ✅ Pessoas
- ✅ Demandas
- ✅ Ordens
- ✅ CAF
- ✅ ProgramasAgricultura
- ✅ Notificacoes
- ✅ Homepage
- ✅ Relatorios

## 🚀 Como Funciona

### 1. Instalação de Módulos

Os módulos são instalados na pasta `Modules/` na raiz do projeto. Cada módulo é uma pasta independente contendo todo o código necessário.

### 2. Registro de Módulos

Os módulos são registrados automaticamente pelo Laravel Modules através dos Service Providers definidos no `module.json`.

### 3. Ativação/Desativação

Os módulos podem ser habilitados ou desabilitados através do painel administrativo em:
- **Admin → Módulos**

Quando um módulo é desabilitado:
- Suas rotas não são carregadas
- Seus Service Providers não são executados
- O módulo permanece instalado, mas inativo

### 4. Prioridade de Carregamento

O campo `priority` no `module.json` determina a ordem de carregamento:
- **0**: Prioridade padrão
- **Maior número**: Maior prioridade (carregado primeiro)

Isso é útil quando um módulo depende de outro ser carregado primeiro.

## 🔧 Desenvolvimento de Módulos

### Criando um Novo Módulo

1. Use o comando Artisan:
```bash
php artisan module:make NomeDoModulo
```

2. Configure o `module.json` com as informações do módulo

3. Desenvolva as funcionalidades seguindo a estrutura padrão

4. Registre os Service Providers necessários

### Boas Práticas

- ✅ Use namespaces consistentes: `Modules\NomeDoModulo\`
- ✅ Siga a estrutura de pastas padrão
- ✅ Documente o módulo no `module.json`
- ✅ Use migrations para alterações no banco
- ✅ Implemente relacionamentos Eloquent corretamente
- ✅ Crie AdminControllers com estatísticas completas
- ✅ Use eager loading para otimizar consultas
- ✅ Implemente accessors para estatísticas
- ✅ Mantenha views padronizadas com relacionamentos visíveis
- ✅ Implemente testes quando possível
- ✅ Mantenha o código organizado e comentado

### Padrão de AdminControllers

Todos os AdminControllers devem seguir este padrão:

```php
class NomeAdminController extends Controller
{
    public function index(Request $request)
    {
        // Filtros e busca
        $filters = $request->only(['search', 'status', 'localidade_id']);
        $query = Modelo::with(['relacionamento1', 'relacionamento2']);
        
        // Aplicar filtros
        if (!empty($filters['search'])) {
            $query->where('campo', 'like', "%{$filters['search']}%");
        }
        
        // Paginação
        $registros = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Estatísticas gerais
        $estatisticas = $this->calcularEstatisticas();
        
        return view('modulo::admin.index', compact('registros', 'filters', 'estatisticas'));
    }

    public function show($id)
    {
        // Eager loading de relacionamentos importantes
        $registro = Modelo::with([
            'relacionamento1',
            'relacionamento2.aninhado',
            'demandas.ordemServico',
            'ordensServico.equipe',
            'ordensServico.usuarioAbertura'
        ])->findOrFail($id);
        
        // Estatísticas específicas do registro
        $estatisticas = [
            'total_demandas' => $registro->demandas()->count(),
            'total_ordens' => $registro->ordensServico()->count(),
            'ordens_pendentes' => $registro->ordensServico()->where('status', 'pendente')->count(),
            'ordens_concluidas' => $registro->ordensServico()->where('status', 'concluida')->count(),
        ];
        
        // Dados relacionados para exibição
        $demandasRecentes = $registro->demandas()
            ->with(['localidade', 'usuario', 'ordemServico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('modulo::admin.show', compact('registro', 'estatisticas', 'demandasRecentes'));
    }

    private function calcularEstatisticas()
    {
        try {
            return [
                'total' => Modelo::count(),
                'ativos' => Modelo::where('ativo', true)->count(),
                'inativos' => Modelo::where('ativo', false)->count(),
            ];
        } catch (\Exception $e) {
            \Log::error('Erro ao calcular estatísticas: ' . $e->getMessage());
            return [
                'total' => 0,
                'ativos' => 0,
                'inativos' => 0,
            ];
        }
    }
}
```

### Padrão de Models

Todos os Models devem incluir:

- Relacionamentos Eloquent bem definidos
- Accessors para estatísticas (`getEstatisticasAttribute`)
- Scopes úteis para filtros
- Métodos auxiliares quando necessário

**Exemplo de Model com Accessor de Estatísticas:**

```php
class Modelo extends Model
{
    // Relacionamentos
    public function localidade()
    {
        return $this->belongsTo(Localidade::class);
    }
    
    public function demandas()
    {
        return $this->hasMany(Demanda::class);
    }
    
    public function ordensServico()
    {
        return $this->hasManyThrough(OrdemServico::class, Demanda::class);
    }
    
    // Accessor de Estatísticas
    public function getEstatisticasAttribute()
    {
        return [
            'total_demandas' => $this->demandas()->count(),
            'total_ordens' => $this->ordensServico()->count(),
            'ordens_pendentes' => $this->ordensServico()->where('status', 'pendente')->count(),
            'ordens_concluidas' => $this->ordensServico()->where('status', 'concluida')->count(),
        ];
    }
}
```

### Padrão de Views Admin (show.blade.php)

Todas as views admin de detalhes devem seguir este padrão:

```blade
@extends('admin.layouts.admin')

@section('title', $registro->nome . ' - Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="icon-name" class="w-8 h-8 text-emerald-600 dark:text-emerald-500" />
                {{ $registro->nome }}
            </h1>
            <nav aria-label="breadcrumb">
                <!-- Breadcrumb -->
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.modulo.index') }}" class="...">Voltar</a>
            <a href="{{ route('modulo.show', $registro->id) }}" class="...">Ver no Painel Padrão</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Conteúdo Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informações Principais -->
        <x-admin.card title="Informações">
            <!-- Dados do registro -->
        </x-admin.card>
        
        <!-- Estatísticas -->
        @if(isset($estatisticas))
        <x-admin.card title="Estatísticas">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Cards de estatísticas -->
            </div>
        </x-admin.card>
        @endif
        
        <!-- Relacionamentos -->
        @if($registro->relacionamento->count() > 0)
        <x-admin.card title="Relacionamentos">
            <!-- Lista de relacionamentos -->
        </x-admin.card>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <x-admin.card title="Ações Rápidas">
            <!-- Botões de ação -->
        </x-admin.card>
    </div>
</div>
@endsection
```

**Componentes Padrão:**
- `x-admin.card`: Card para agrupar informações
- `x-admin.badge`: Badge para status e condições
- `x-icon`: Ícones SVG padronizados
- Layout responsivo com grid Tailwind CSS
- Suporte a dark mode

## 📝 Créditos

**Desenvolvedor:** Reinan Rodrigues  
**Empresa:** Vertex Solutions LTDA

Todos os módulos foram desenvolvidos seguindo as melhores práticas de desenvolvimento Laravel e arquitetura modular.

## 📚 Recursos Adicionais

- [Documentação Laravel Modules](https://nwidart.com/laravel-modules/)
- [Documentação Laravel](https://laravel.com/docs)
- [Documentação do Projeto](../README.md)

## 🔄 Versionamento

O sistema utiliza versionamento semântico (Semantic Versioning):
- **MAJOR**: Mudanças incompatíveis
- **MINOR**: Novas funcionalidades compatíveis
- **PATCH**: Correções de bugs compatíveis

## 📞 Suporte

Para suporte técnico ou dúvidas sobre os módulos, entre em contato com a equipe de desenvolvimento da Vertex Solutions LTDA.

---

**VERTEXSEMAGRI** - Sistema de Gestão Municipal Modular  
Desenvolvido com ❤️ por **Vertex Solutions LTDA**
