<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta Criada - {{ $funcionario->nome ?? 'Funcionário' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-header p {
            color: #e9d5ff;
            margin: 0;
            font-size: 14px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .credentials-box {
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            border: 2px solid #8b5cf6;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        .credential-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e9d5ff;
        }
        .credential-row:last-child {
            border-bottom: none;
        }
        .credential-label {
            font-weight: 600;
            color: #6b21a8;
            font-size: 14px;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: 700;
            color: #7c3aed;
            background: #ffffff;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #d8b4fe;
        }
        .warning-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .warning-box h3 {
            color: #92400e;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .warning-box p {
            color: #78350f;
            margin: 5px 0;
            font-size: 14px;
        }
        .info-section {
            background: #f8fafc;
            border-left: 4px solid #8b5cf6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #475569;
            font-size: 14px;
        }
        .info-value {
            color: #1e293b;
            font-size: 14px;
            text-align: right;
        }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(139, 92, 246, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        }
        .help-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .help-box h3 {
            color: #1e40af;
            margin: 0 0 15px 0;
            font-size: 16px;
        }
        .help-list {
            margin: 0;
            padding-left: 20px;
        }
        .help-list li {
            margin: 8px 0;
            color: #1e293b;
            font-size: 14px;
        }
        .footer {
            background: #f8fafc;
            padding: 30px 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #8b5cf6;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .credential-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .credential-value {
                margin-top: 8px;
                width: 100%;
            }
            .info-row {
                flex-direction: column;
            }
            .info-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>👤 Conta Criada com Sucesso!</h1>
            <p>Secretaria Municipal de Agricultura - SEMAGRI</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                Olá <strong>{{ $funcionario->nome ?? 'Funcionário' }}</strong>,
            </div>

            <p>Sua conta foi criada no sistema de gestão da SEMAGRI. Utilize as credenciais abaixo para acessar o sistema.</p>

            @if($senhaTemporaria)
            <!-- Credenciais -->
            <div class="credentials-box">
                <h3 style="margin: 0 0 20px 0; color: #6b21a8; font-size: 18px; text-align: center;">🔐 Suas Credenciais de Acesso</h3>

                <div class="credential-row">
                    <span class="credential-label">E-mail:</span>
                    <span class="credential-value">{{ $funcionario->email }}</span>
                </div>

                <div class="credential-row">
                    <span class="credential-label">Senha Temporária:</span>
                    <span class="credential-value">{{ $senhaTemporaria }}</span>
                </div>
            </div>

            <!-- Aviso Importante -->
            <div class="warning-box">
                <h3>⚠️ IMPORTANTE</h3>
                <p><strong>Esta é uma senha temporária.</strong> Por segurança, você precisará alterá-la no primeiro acesso ao sistema.</p>
                <p style="margin-top: 10px;"><strong>Guarde estas informações com segurança!</strong> Não compartilhe suas credenciais com ninguém.</p>
            </div>
            @else
            <!-- Aviso se não houver senha temporária -->
            <div class="warning-box">
                <h3>ℹ️ Informação</h3>
                <p>Sua conta foi criada, mas a senha ainda não foi definida. Entre em contato com o administrador do sistema para obter suas credenciais de acesso.</p>
            </div>
            @endif

            <!-- Informações do Funcionário -->
            <div class="info-section">
                <h3 style="margin: 0 0 15px 0; color: #1e293b; font-size: 16px;">📋 Informações da Conta</h3>

                <div class="info-row">
                    <span class="info-label">Nome:</span>
                    <span class="info-value">{{ $funcionario->nome }}</span>
                </div>

                @if($funcionario->codigo)
                <div class="info-row">
                    <span class="info-label">Código:</span>
                    <span class="info-value" style="font-family: monospace;">{{ $funcionario->codigo }}</span>
                </div>
                @endif

                @if($funcionario->funcao)
                <div class="info-row">
                    <span class="info-label">Função:</span>
                    <span class="info-value">{{ $funcionario->funcao_formatada }}</span>
                </div>
                @endif

                @if($funcionario->data_admissao)
                <div class="info-row">
                    <span class="info-label">Data de Admissão:</span>
                    <span class="info-value">{{ $funcionario->data_admissao->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>

            <!-- Instruções -->
            <div class="help-box">
                <h3>📝 Como Acessar o Sistema</h3>
                <ul class="help-list">
                    <li><strong>Acesse o link abaixo</strong> ou visite o sistema</li>
                    <li><strong>Faça login</strong> com seu e-mail e senha temporária</li>
                    @if($senhaTemporaria)
                    <li><strong>Altere sua senha</strong> no primeiro acesso (obrigatório)</li>
                    @endif
                    <li><strong>Explore o sistema</strong> e comece a trabalhar</li>
                </ul>
            </div>

            <!-- Botão de Ação -->
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">🔗 Acessar o Sistema</a>
            </div>

            <p style="font-size: 13px; color: #64748b; margin-top: 25px; text-align: center;">
                Ou copie e cole este link no seu navegador:<br>
                <a href="{{ $loginUrl }}" style="color: #8b5cf6; word-break: break-all;">{{ $loginUrl }}</a>
            </p>
        </div>

        <div class="footer">
            <p><strong>{{ $appName ?? 'SEMAGRI' }}</strong> - Secretaria Municipal de Agricultura</p>
            <p>Prefeitura Municipal de Coração de Maria - Bahia</p>
            <p style="margin-top: 15px; font-size: 11px; color: #94a3b8;">
                Este é um e-mail automático. Por favor, não responda a esta mensagem.<br>
                Se você não solicitou esta conta, entre em contato com o administrador imediatamente.
            </p>
        </div>
    </div>
</body>
</html>

