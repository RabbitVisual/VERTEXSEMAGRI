# Sistema PIX - Integração com API do Banco Central

## Visão Geral

Este módulo implementa uma integração completa com a API PIX do Banco Central do Brasil, permitindo que líderes comunitários recebam pagamentos de mensalidades via PIX de forma automática e profissional.

## Funcionalidades

### 1. Cadastro de Chave PIX
- Líderes comunitários podem cadastrar sua chave PIX (CPF, CNPJ, E-mail, Telefone ou Chave Aleatória)
- Validação automática da chave conforme o tipo selecionado
- Ativação/desativação da chave PIX

### 2. Geração de QR Code
- Geração automática de QR Code PIX para cada mensalidade
- QR Code exibido em modal responsivo
- Código PIX copiável para área de transferência
- Integração com biblioteca QRCode.js para renderização visual

### 3. Processamento Automático de Pagamentos
- Webhook para receber notificações de pagamento do PSP
- Processamento automático quando pagamento é confirmado
- Criação automática de registro de pagamento na tabela `pagamentos_poco`
- Atualização automática do status da mensalidade

### 4. Consulta de Status
- Consulta manual do status de pagamentos PIX
- Atualização automática quando pagamento é confirmado

## Estrutura do Banco de Dados

### Tabela: `lideres_comunidade`
Novos campos adicionados:
- `chave_pix` (string, nullable): Chave PIX do líder
- `tipo_chave_pix` (enum): Tipo da chave (cpf, cnpj, email, telefone, aleatoria)
- `pix_ativo` (boolean): Status de ativação da chave PIX

### Tabela: `pagamentos_pix_poco`
Nova tabela para armazenar pagamentos PIX:
- `txid`: Transaction ID único do PIX
- `codigo`: Código interno do pagamento
- `mensalidade_id`: Relacionamento com mensalidade
- `usuario_poco_id`: Usuário que está pagando (opcional)
- `poco_id`: Poço relacionado
- `lider_id`: Líder que receberá o pagamento
- `chave_pix_destino`: Chave PIX de destino
- `valor`: Valor do pagamento
- `qr_code_base64`: QR Code em base64
- `qr_code_string`: String do QR Code (EMV)
- `location_id`: ID da location do PIX
- `status`: Status do pagamento (pendente, pago, expirado, cancelado)
- `data_expiracao`: Data de expiração do QR Code
- `data_pagamento`: Data em que o pagamento foi confirmado
- `e2eid`: End-to-end ID do pagamento
- `chave_pix_origem`: Chave PIX de quem pagou
- `nome_pagador`: Nome do pagador
- `cpf_pagador`: CPF do pagador
- `webhook_recebido_em`: Data de recebimento do webhook
- `webhook_dados`: Dados completos do webhook (JSON)

## Configuração

### Variáveis de Ambiente (.env)

```env
# Configurações PIX - API Banco Central do Brasil
PIX_BASE_URL=https://api-pix.gerencianet.com.br
PIX_CLIENT_ID=seu_client_id
PIX_CLIENT_SECRET=seu_client_secret
PIX_CERTIFICATE_PATH=caminho/para/certificado.pem
PIX_WEBHOOK_SECRET=seu_webhook_secret
PIX_WEBHOOK_URL=${APP_URL}/api/webhook/pix
PIX_PSP_NAME=gerencianet
PIX_ENVIRONMENT=sandbox
```

### Arquivo de Configuração

O arquivo `config/pix.php` contém todas as configurações do sistema PIX.

## Uso

### Para Líderes Comunitários

1. **Cadastrar Chave PIX:**
   - Acesse o dashboard do líder comunitário
   - Clique em "Configurar PIX"
   - Selecione o tipo de chave e informe a chave PIX
   - Salve a configuração

2. **Gerar QR Code para Pagamento:**
   - Acesse a mensalidade desejada
   - Para cada usuário pendente, clique em "QR Code PIX"
   - O QR Code será exibido em um modal
   - O usuário pode escanear o QR Code com o app do banco
   - O pagamento será processado automaticamente via webhook

3. **Verificar Status de Pagamento:**
   - No modal do QR Code, clique em "Verificar Pagamento"
   - O sistema consultará o status atual do pagamento

### Para Desenvolvedores

#### Gerar QR Code Programaticamente

```php
use Modules\Pocos\App\Services\PixService;
use Modules\Pocos\App\Models\MensalidadePoco;
use Modules\Pocos\App\Models\LiderComunidade;

$pixService = app(PixService::class);
$mensalidade = MensalidadePoco::find($id);
$lider = $mensalidade->lider;

$resultado = $pixService->criarCobranca($mensalidade, $lider, $usuarioPocoId);
// Retorna: ['pagamento_pix', 'qr_code', 'txid']
```

#### Processar Webhook

O webhook é processado automaticamente pela rota `/api/webhook/pix`. O sistema:
1. Valida a assinatura do webhook (se configurado)
2. Processa os dados do pagamento
3. Atualiza o status do pagamento PIX
4. Cria registro de pagamento na tabela `pagamentos_poco`

## Segurança

- Validação de chave PIX conforme tipo selecionado
- Validação de assinatura de webhook (implementar conforme PSP)
- Tokens OAuth2 para autenticação na API
- Certificados SSL para comunicação segura

## Notas Importantes

1. **PSP (Prestador de Serviços de Pagamento):**
   - O sistema foi desenvolvido para funcionar com qualquer PSP compatível com a API PIX do Banco Central
   - Por padrão, está configurado para Gerencianet, mas pode ser adaptado para outros PSPs

2. **Ambiente:**
   - Use `PIX_ENVIRONMENT=sandbox` para testes
   - Use `PIX_ENVIRONMENT=production` para produção

3. **Webhook:**
   - Configure o webhook no painel do PSP apontando para: `{APP_URL}/api/webhook/pix`
   - O webhook deve ser configurado para cada chave PIX cadastrada

4. **Certificados:**
   - Alguns PSPs exigem certificado SSL para autenticação
   - Configure o caminho do certificado em `PIX_CERTIFICATE_PATH`

## Troubleshooting

### Erro: "Não foi possível obter token de acesso PIX"
- Verifique se `PIX_CLIENT_ID` e `PIX_CLIENT_SECRET` estão corretos
- Verifique se a URL base está correta
- Verifique se o certificado SSL está configurado corretamente

### Erro: "Chave PIX inválida"
- Verifique se o tipo de chave está correto
- Verifique se a chave está no formato correto (sem pontos, traços, etc.)

### Webhook não está sendo recebido
- Verifique se a URL do webhook está configurada corretamente no PSP
- Verifique se a rota `/api/webhook/pix` está acessível
- Verifique os logs do Laravel para erros

## Referências

- [API PIX - Banco Central do Brasil](https://www.bcb.gov.br/estabilidadefinanceira/pix)
- [Documentação Gerencianet](https://dev.gerencianet.com.br/)
- [Especificação EMV QR Code](https://www.emvco.com/emv-technologies/qrcodes/)

