# Changelog - VERTEXSEMAGRI

## [2.1.0] - 2026-01-30 - Integração Efipay Split

### 🎯 Resumo
Integração total com o sistema de pagamentos **PIX Efipay (Gerencianet) SDK**, introduzindo suporte para **Split de Pagamentos (Marketplace)** entre Plataforma Central e Líderes Comunitários. Implementação de painel de configurações 100% dinâmico (Admin), redesign de UI para temas escuros/claros e auditoria completa de segurança para produção.

### ✨ Novas Funcionalidades
- **Pagamentos Split:** Fluxo "Platform-First" com cálculo automático de taxas e repasse líquido.
- **SDK Gerencianet:** Substituição de chamadas manuais para maior segurança.
- **Painel de Configurações:** Gestão dinâmica de chaves API via Admin.

### 🎨 UI/UX & Melhorias
- **Tema Escuro/Claro:** Seletor global persistente.
- **Feedback Visual:** Alertas padronizados com ícones SVG.
- **Auditoria HTML:** Validação de estrutura Blade.

---

## [2.0.0] - 2025-01-XX - PWA Completo & Offline

### 🎯 Resumo
Implementação completa de um **Progressive Web App (PWA)** profissional para o painel Campo, com funcionalidade 100% offline, sincronização segura via IndexedDB, design moderno com Tailwind CSS v4.1 e HyperUI, sistema de alertas inteligente e correções críticas de UX.

### 📱 PWA & Offline
- **Service Worker Avançado:** Cache estratégico e background sync.
- **IndexedDB:** Armazenamento local robusto para operações offline.
- **Manifest.json Profissional:** Ícones SVG, shortcuts e display modes.

### � Correções & Melhorias
- **UI/UX:** Layouts modernos, alertas globais e carregamento otimizado.
- **Bug Fixes:** Loading overlay, ícones 404 e logging condicional.

### � Arquivos Impactados
`public/sw.js`, `public/manifest.json`, `public/js/campo-offline.js`, `resources/views/campo/*`
