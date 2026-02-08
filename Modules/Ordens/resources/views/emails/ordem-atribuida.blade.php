<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Ordem de Serviço Atribuída - {{ $ordemServico->numero ?? 'N/A' }}</title>
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
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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
            color: #dbeafe;
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
        .protocol-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px solid #3b82f6;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .protocol-code {
            font-size: 32px;
            font-weight: 700;
            color: #2563eb;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            margin: 10px 0;
        }
        .protocol-label {
            font-size: 14px;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .info-section {
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
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
        .priority-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .priority-baixa { background: #e2e8f0; color: #475569; }
        .priority-media { background: #dbeafe; color: #1e40af; }
        .priority-alta { background: #fef3c7; color: #92400e; }
        .priority-urgente { background: #fee2e2; color: #991b1b; }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }
        .status-pendente { background: #fef3c7; color: #92400e; }
        .status-em_execucao { background: #dbeafe; color: #1e40af; }
        .status-concluida { background: #d1fae5; color: #065f46; }
        .status-cancelada { background: #fee2e2; color: #991b1b; }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
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
            color: #3b82f6;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .protocol-code {
                font-size: 24px;
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
            <h1>📋 Nova Ordem de Serviço Atribuída</h1>
            <p>Secretaria Municipal de Agricultura - SEMAGRI</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                Olá <strong>{{ $funcionario->nome ?? 'Funcionário' }}</strong>,
            </div>

            <p>Uma nova ordem de serviço foi atribuída a você. Acesse o sistema para visualizar os detalhes e iniciar o atendimento.</p>

            <!-- Protocolo Destacado -->
            <div class="protocol-box">
                <div class="protocol-label">Número da Ordem de Serviço</div>
                <div class="protocol-code">{{ $ordemServico->numero ?? 'N/A' }}</div>
            </div>

            <!-- Informações da Ordem -->
            <div class="info-section">
                <h3 style="margin: 0 0 15px 0; color: #1e293b; font-size: 16px;">📋 Informações da Ordem</h3>

                <div class="info-row">
                    <span class="info-label">Tipo de Serviço:</span>
                    <span class="info-value">{{ $ordemServico->tipo_servico }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Prioridade:</span>
                    <span class="info-value">
                        <span class="priority-badge priority-{{ $ordemServico->prioridade }}">
                            {{ $ordemServico->prioridade_texto }}
                        </span>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $ordemServico->status }}">
                            {{ $ordemServico->status_texto }}
                        </span>
                    </span>
                </div>

                @if($ordemServico->equipe)
                <div class="info-row">
                    <span class="info-label">Equipe:</span>
                    <span class="info-value">{{ $ordemServico->equipe->nome }}</span>
                </div>
                @endif

                @if($ordemServico->demanda && $ordemServico->demanda->localidade)
                <div class="info-row">
                    <span class="info-label">Localidade:</span>
                    <span class="info-value">{{ $ordemServico->demanda->localidade->nome }}</span>
                </div>
                @endif

                @if($ordemServico->demanda)
                <div class="info-row">
                    <span class="info-label">Demanda Relacionada:</span>
                    <span class="info-value" style="font-family: monospace;">{{ $ordemServico->demanda->codigo }}</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="info-label">Data de Abertura:</span>
                    <span class="info-value">{{ $ordemServico->data_abertura ? $ordemServico->data_abertura->format('d/m/Y \à\s H:i') : 'N/A' }}</span>
                </div>

                @if($ordemServico->descricao)
                <div class="info-row" style="flex-direction: column; align-items: flex-start;">
                    <span class="info-label" style="margin-bottom: 8px;">Descrição:</span>
                    <span class="info-value" style="text-align: left; white-space: pre-wrap;">{{ $ordemServico->descricao }}</span>
                </div>
                @endif
            </div>

            <!-- Instruções -->
            <div class="help-box">
                <h3>📝 Próximos Passos</h3>
                <ul class="help-list">
                    <li><strong>Acesse o sistema</strong> através do link abaixo</li>
                    <li><strong>Visualize os detalhes</strong> da ordem de serviço</li>
                    <li><strong>Inicie o atendimento</strong> quando estiver no local</li>
                    <li><strong>Registre fotos</strong> antes e depois do serviço</li>
                    <li><strong>Conclua a ordem</strong> após finalizar o serviço</li>
                </ul>
            </div>

            <!-- Botão de Ação -->
            <div style="text-align: center;">
                <a href="{{ $detalhesUrl }}" class="button">🔗 Ver Detalhes da Ordem</a>
            </div>

            <p style="font-size: 13px; color: #64748b; margin-top: 25px; text-align: center;">
                Ou copie e cole este link no seu navegador:<br>
                <a href="{{ $detalhesUrl }}" style="color: #3b82f6; word-break: break-all;">{{ $detalhesUrl }}</a>
            </p>
        </div>

        <div class="footer">
            <p><strong>{{ $appName ?? 'SEMAGRI' }}</strong> - Secretaria Municipal de Agricultura</p>
            <p>Prefeitura Municipal de Coração de Maria - Bahia</p>
            <p style="margin-top: 15px; font-size: 11px; color: #94a3b8;">
                Este é um e-mail automático. Por favor, não responda a esta mensagem.
            </p>
        </div>
    </div>
</body>
</html>

