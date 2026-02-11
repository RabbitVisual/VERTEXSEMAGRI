# Sistema de Design Padrão e Ícones (Local Font Awesome 7.1)

Este documento descreve como utilizar o sistema de ícones e fontes configurado no projeto. Todos os recursos (ícones e fontes) são carregados **localmente**, sem dependência de CDNs externas, garantindo performance e conformidade com ambientes offline.

## 1. Fontes Globais

O sistema utiliza as seguintes famílias de fontes locais:

*   **Principal (Sans)**: `Inter` (Regular, Medium/500, SemiBold/600, Bold/700)
*   **Secundária/Destaque**: `Poppins` (Regular, Bold)

Estas fontes são configuradas no arquivo `resources/css/fonts.css` e integradas ao Tailwind via `resources/css/app.css`.

---

## 2. Ícones (Font Awesome 7.1 Pro Local)

Utilizamos a biblioteca **Font Awesome 7.1 Pro** hospedada em `resources/fw-pro`.

### Como usar o Componente `<x-icon />`

O projeto possui um componente Blade otimizado para renderizar ícones com suporte a todos os estilos do FA 7.1 (Duotone, Sharp, Thin, etc).

#### Sintaxe Básica (pelo nome do ícone)
```blade
<x-icon name="user" />                  <!-- Padrão: Duotone -->
<x-icon name="house" style="solid" />   <!-- Estilo Sólido -->
<x-icon name="check" class="text-green-500" />
```

#### Sintaxe por Módulo (Recomendado para Menus/Títulos)
Você pode chamar o ícone padrão de um módulo sem saber qual é o ícone específico, apenas passando o nome do módulo. O mapeamento fica em `config/icons.php`.

```blade
<x-icon module="agua" />      <!-- Renderiza: faucet-drip (ícone da água) -->
<x-icon module="financeiro" /> <!-- Renderiza o ícone configurado no config -->
```

### Estilos Disponíveis (`style="..."`)

| Estilo                 | Código Blade                             | Prefixo Gerado CSS    |
| :--------------------- | :--------------------------------------- | :-------------------- |
| **Duotone** (Padrão)   | `style="duotone"`                        | `fa-duotone`          |
| Solid                  | `style="solid"`                          | `fa-solid`            |
| Regular                | `style="regular"`                        | `fa-regular`          |
| Light                  | `style="light"`                          | `fa-light`            |
| **Thin** (Novo no 7.0) | `style="thin"`                           | `fa-thin`             |
| Brands (Marcas)        | `style="brands"`                         | `fa-brands`           |
| **Sharp Solid**        | `style="sharp"` ou `style="sharp-solid"` | `fa-sharp fa-solid`   |
| Sharp Regular          | `style="sharp-regular"`                  | `fa-sharp fa-regular` |
| Sharp Light            | `style="sharp-light"`                    | `fa-sharp fa-light`   |
| Sharp Thin             | `style="sharp-thin"`                     | `fa-sharp fa-thin`    |

### Ícones Padrão por Módulo

Configure os ícones no arquivo `config/icons.php`. Abaixo a lista atual:

*   **Agua**: `faucet-drip`
*   **Avisos**: `bullhorn`
*   **Blog**: `newspaper`
*   **CAF**: `id-card`
*   **Chat**: `comments`
*   **Demandas**: `clipboard-list`
*   **Equipes**: `users-gear`
*   **Estradas**: `road`
*   **Funcionarios**: `user-tie`
*   **Homepage**: `home`
*   **Iluminacao**: `lightbulb`
*   **Localidades**: `map-location-dot`
*   **Materiais**: `boxes-stacked`
*   **Notificacoes**: `bell`
*   **Ordens**: `file-signature`
*   **Pessoas**: `users`
*   **Pocos**: `arrow-down-to-line`
*   **ProgramasAgricultura**: `wheat`
*   **Relatorios**: `file-chart-column`

---

## 3. Manutenção

*   **Adicionar novos módulos**: Adicione a chave e o ícone em `config/icons.php`.
*   **Atualizar Fonte/Ícones**: Substitua os arquivos em `resources/fonts` ou `resources/fw-pro` e atualize o CSS correspondente se os nomes dos arquivos mudarem.
