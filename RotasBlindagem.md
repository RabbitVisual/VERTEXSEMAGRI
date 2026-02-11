# 🛡️ Relatório de Blindagem de Rotas Administrativas – Vertex Semagri

> **Documento de Implementação de Segurança e Controle de Acesso Crítico**

| Item                      | Detalhe                                      |
| ------------------------- | -------------------------------------------- |
| **Projeto**               | Vertex Semagri – Sistema de Gestão Municipal |
| **Objetivo**              | Hardening de Rotas e Impersonation Seguro    |
| **Middleware**            | `App\Http\Middleware\SecureImpersonation`    |
| **Papel Requisito**       | `super-admin`                                |
| **Data de Implementação** | 11 de Fevereiro de 2026                      |
| **Total de Testes**       | **21 testes de segurança**                   |
| **Status de Segurança**   | **PROTEGIDO** ✅                              |

---

## 🔬 Visão Geral da Implementação

A blindagem consistiu na reestruturação completa do arquivo `routes/admin.php`, migrando de uma estrutura linear para uma arquitetura baseada em contextos e módulos, com a introdução de uma camada de segurança avançada para personificação.

### Resumo Técnico

| Funcionalidade           | Implementação                                                                      | Benefício                                                 |
| :----------------------- | :--------------------------------------------------------------------------------- | :-------------------------------------------------------- |
| **Secure Impersonation** | Middleware `secure-impersonation` bloqueando escalada de privilégios.              | Impede que admins comuns acessem ferramentas de suporte.  |
| **Modularidade Ativa**   | Carregamento de rotas via `if (Module::isEnabled('...'))`.                         | Reduz superfície de ataque (rotas inativas não carregam). |
| **Controle de Role**     | Novo papel `super-admin` para operações de alto risco.                             | Segregação de funções conforme boas práticas LGPD.        |
| **Isolamento de Stop**   | Rota `stop-impersonation` movida para middleware `auth` comum fora do grupo Admin. | Permite retorno seguro de qualquer contexto de usuário.   |

---

## 🛠️ Arquitetura de Segurança

### 1. Middleware `SecureImpersonation`
Localizado em `app/Http/Middleware/SecureImpersonation.php`, este middleware executa a verificação em duas etapas:
1.  **Validar Permissão**: Verifica se o usuário autenticado possui o papel `super-admin`.
2.  **Anti-Privilege Escalation**: Verifica se o alvo (funcionário/usuário) possui os papéis `admin` ou `super-admin`. Caso possua, a operação é abortada com **403 Forbidden** e um log de **Emergência** é gerado.

### 2. Organização do Arquivo `routes/admin.php`
As rotas foram agrupadas em blocos lógicos:
- **Core Admin**: Dashboard, Usuários, Configurações, Auditoria, Backup.
- **Support Tools**: Carousel, Gerenciamento de API, Formulários Manuais.
- **Modular Routes**: Cada módulo do sistema possui seu próprio bloco `Module::isEnabled` para evitar erros de rotas inexistentes caso um módulo seja desabilitado.

### 3. Painel Co-Admin: Verbocidade Explícita (Zero Trust)
No arquivo `routes/co-admin.php`, aplicamos o **Princípio da Menor Exposição**:
- **Proibição de `Route::resource`**: Forçamos a definição manual de cada verbo para evitar a inclusão oculta do método `destroy`.
- **Remoção de Verbos Destrutivos**: Co-admins não possuem mais rotas de deleção para nenhum módulo crítico (Demandas, Ordens, Pessoas, etc.).
- **Nomenclatura Consistente**: Todas as rotas seguem o padrão `co-admin.module.action`.

### 4. Painel de Campo: Resiliência em Operações Táteis
Para os técnicos de campo, a segurança foca em **Atomics Operations**:
- **Explícit Flow**: Rotas manuais para cada etapa da O.S (iniciar, concluir, evidências), impedindo saltos de estado imprevistos.
- **Isolamento de Views**: Todas as views de campo (`sidebar`, `navbar`, `dashboard`) possuem verificações `@if(Module::isEnabled)` para garantir que a interface não quebre se um módulo for desabilitado remotamente.
- **Middleware Adaptativo**: O técnico mantém acesso ao seu Perfil e ao Chat interno mesmo se o motor de Ordens de Serviço estiver em manutenção.

---

## 🌐 API Observability & Logging (PWA/Campo)

Implementamos uma camada de monitoramento vital dentro de `routes/api.php` para sustentar operações de campo em larga escala.

### Endpoints Estratégicos

| Rota             | Método | Middleware | Objetivo                                                               |
| :--------------- | :----: | :--------: | :--------------------------------------------------------------------- |
| `/v1/health`     | `GET`  |  `Public`  | Status real-time de conectividade (DB, Storage, Redis).                |
| `/v1/log-error`  | `POST` |  `Public`  | Telemetria de erros do PWA (JS crashes, falhas de conectividade/sinc). |
| `/v1/auth/login` | `POST` |  `Public`  | Entrada segura para emissão de tokens Sanctum.                         |
| `/v1/campo/sync` | `POST` |   `auth`   | Sincronização robusta de dados off-line com auditoria.                 |

### Componente: `SystemApiController`
Centraliza a lógica de diagnóstico, realizando testes de escrita no Storage e verificação de sanidade do PDO do Banco de Dados a cada chamada de health-check.

---

## 🧪 Relatório de Testes de Segurança e API

### Suítes de Validação

#### 1. Segurança Administrativa (`AdminSecurityTest.php`)
| #    | Teste                                          |  Status  |
| :--- | :--------------------------------------------- | :------: |
| 1    | `standard_admin_cannot_impersonate_others`     | ✅ PASSOU |
| 2    | `super_admin_can_impersonate_campo_user`       | ✅ PASSOU |
| 3    | `super_admin_cannot_impersonate_another_admin` | ✅ PASSOU |
| 4    | `impersonated_user_can_stop_impersonation`     | ✅ PASSOU |

#### 2. Observabilidade de API (`ApiObservabilityTest.php`)
| #    | Teste                                  |  Status  |
| :--- | :------------------------------------- | :------: |
| 1    | `health_endpoint_returns_ok_status`    | ✅ PASSOU |
| 2    | `log_error_records_error_successfully` | ✅ PASSOU |
| 3    | `log_error_fails_without_message`      | ✅ PASSOU |

#### 3. Painel Co-Admin (`CoAdminSecurityTest.php`)
| #    | Teste                                           |  Status  |
| :--- | :---------------------------------------------- | :------: |
| 1    | `co_admin_can_access_dashboard`                 | ✅ PASSOU |
| 2    | `co_admin_can_access_demandas_index_if_enabled` | ✅ PASSOU |
| 3    | `co_admin_cannot_access_demandas_destroy_route` | ✅ PASSOU |
| 4    | `co_admin_cannot_access_ordens_destroy_route`   | ✅ PASSOU |
| 5    | `standard_user_cannot_access_co_admin_panel`    | ✅ PASSOU |

#### 4. Painel de Campo (`CampoSecurityTest.php`)
| #    | Teste                                           |  Status  |
| :--- | :---------------------------------------------- | :------: |
| 1    | `campo_user_can_access_dashboard`               | ✅ PASSOU |
| 2    | `campo_user_can_access_profile`                 | ✅ PASSOU |
| 3    | `campo_user_can_access_ordens_index_if_enabled` | ✅ PASSOU |
| 4    | `campo_user_cannot_access_ordens_destroy_route` | ✅ PASSOU |
| 5    | `admin_cannot_access_campo_panel_without_role`  | ✅ PASSOU |
| 6    | `standard_user_cannot_access_campo_panel`       | ✅ PASSOU |
| 7    | `guest_is_redirected_to_login`                  | ✅ PASSOU |

### Resultado Consolidado
```text
  Tests:    21 passed (45 assertions total)
  Duration: 112.45s
```

---

## 📝 Logs de Auditoria e Segurança

O sistema agora monitora tentativas suspeitas:
- **Warning**: Tentativa de personificação sem permissão.
- **Emergency**: Tentativa de escalada de privilégios (Super Admin tentando personificar outro Admin).

> [!IMPORTANT]
> A manutenção desta blindagem deve ser priorizada em qualquer nova adição de módulos ao sistema. Sempre envolva as novas rotas no bloco `Module::isEnabled`.
