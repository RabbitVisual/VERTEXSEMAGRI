<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta: Estoque Baixo - {{ $material->nome ?? 'Material' }}</title>
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            color: #fef3c7;
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
        .alert-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        .alert-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .alert-title {
            font-size: 24px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 10px;
        }
        .alert-message {
            font-size: 16px;
            color: #78350f;
            margin: 0;
        }
        .info-section {
            background: #f8fafc;
            border-left: 4px solid #f59e0b;
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
        .estoque-baixo {
            color: #dc2626;
            font-weight: 700;
            font-size: 18px;
        }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }
        .action-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .action-box h3 {
            color: #1e40af;
            margin: 0 0 15px 0;
            font-size: 16px;
        }
        .action-list {
            margin: 0;
            padding-left: 20px;
        }
        .action-list li {
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
            color: #f59e0b;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
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
            <h1>⚠️ Alerta: Estoque Baixo</h1>
            <p>Secretaria Municipal de Agricultura - SEMAGRI</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                Olá <strong>{{ $admin->name ?? 'Administrador' }}</strong>,
            </div>

            <p>O material abaixo está com estoque abaixo da quantidade mínima definida. É necessário realizar a reposição do estoque.</p>

            <!-- Alerta Destacado -->
            <div class="alert-box">
                <div class="alert-icon">⚠️</div>
                <div class="alert-title">ATENÇÃO: Estoque Baixo</div>
                <p class="alert-message">
                    O material <strong>{{ $material->nome }}</strong> está com estoque abaixo do mínimo necessário.
                </p>
            </div>

            <!-- Informações do Material -->
            <div class="info-section">
                <h3 style="margin: 0 0 15px 0; color: #1e293b; font-size: 16px;">📦 Informações do Material</h3>

                <div class="info-row">
                    <span class="info-label">Nome:</span>
                    <span class="info-value">{{ $material->nome }}</span>
                </div>

                @if($material->codigo)
                <div class="info-row">
                    <span class="info-label">Código:</span>
                    <span class="info-value" style="font-family: monospace;">{{ $material->codigo }}</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="info-label">Categoria:</span>
                    <span class="info-value">{{ $material->categoria_formatada }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Unidade de Medida:</span>
                    <span class="info-value">{{ ucfirst($material->unidade_medida) }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Estoque Atual:</span>
                    <span class="info-value estoque-baixo">{{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }} {{ $material->unidade_medida }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Estoque Mínimo:</span>
                    <span class="info-value">{{ formatar_quantidade($material->quantidade_minima, $material->unidade_medida) }} {{ $material->unidade_medida }}</span>
                </div>

                @php
                    $diferenca = $material->quantidade_minima - $material->quantidade_estoque;
                @endphp
                <div class="info-row">
                    <span class="info-label">Quantidade Necessária:</span>
                    <span class="info-value estoque-baixo">{{ number_format($diferenca, 2, ',', '.') }} {{ $material->unidade_medida }}</span>
                </div>

                @if($material->valor_unitario)
                <div class="info-row">
                    <span class="info-label">Valor Unitário:</span>
                    <span class="info-value">R$ {{ number_format($material->valor_unitario, 2, ',', '.') }}</span>
                </div>

                @php
                    $valorNecessario = $diferenca * $material->valor_unitario;
                @endphp
                <div class="info-row">
                    <span class="info-label">Valor Estimado para Reposição:</span>
                    <span class="info-value" style="color: #059669; font-weight: 600;">R$ {{ number_format($valorNecessario, 2, ',', '.') }}</span>
                </div>
                @endif

                @if($material->fornecedor)
                <div class="info-row">
                    <span class="info-label">Fornecedor:</span>
                    <span class="info-value">{{ $material->fornecedor }}</span>
                </div>
                @endif

                @if($material->localizacao_estoque)
                <div class="info-row">
                    <span class="info-label">Localização no Estoque:</span>
                    <span class="info-value">{{ $material->localizacao_estoque }}</span>
                </div>
                @endif
            </div>

            <!-- Ações Recomendadas -->
            <div class="action-box">
                <h3>📋 Ações Recomendadas</h3>
                <ul class="action-list">
                    <li><strong>Verificar disponibilidade</strong> do material com o fornecedor</li>
                    <li><strong>Solicitar cotação</strong> para reposição do estoque</li>
                    <li><strong>Registrar entrada</strong> quando o material for recebido</li>
                    <li><strong>Atualizar estoque mínimo</strong> se necessário ajustar o parâmetro</li>
                    <li><strong>Verificar outras ordens</strong> que podem precisar deste material</li>
                </ul>
            </div>

            <!-- Botão de Ação -->
            <div style="text-align: center;">
                <a href="{{ $detalhesUrl }}" class="button">🔗 Ver Detalhes do Material</a>
            </div>

            <p style="font-size: 13px; color: #64748b; margin-top: 25px; text-align: center;">
                Ou copie e cole este link no seu navegador:<br>
                <a href="{{ $detalhesUrl }}" style="color: #f59e0b; word-break: break-all;">{{ $detalhesUrl }}</a>
            </p>
        </div>

        <div class="footer">
            <p><strong>{{ $appName ?? 'SEMAGRI' }}</strong> - Secretaria Municipal de Agricultura</p>
            <p>Prefeitura Municipal de Coração de Maria - Bahia</p>
            <p style="margin-top: 15px; font-size: 11px; color: #94a3b8;">
                Este é um e-mail automático. Por favor, não responda a esta mensagem.<br>
                Este alerta será enviado novamente após 24 horas se o estoque não for reposto.
            </p>
        </div>
    </div>
</body>
</html>

