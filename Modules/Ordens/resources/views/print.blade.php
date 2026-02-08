<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço {{ $ordem->numero }} - VERTEX</title>
    <style>
        @page {
            margin: 10mm;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Helvetica', 'Arial', sans-serif;
            font-size: 9.5px;
            line-height: 1.3;
            color: #1e293b;
            background: white;
            padding: 8px;
        }

        .document-container {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        /* Top Bar / Header */
        .top-bar {
            background: #1e293b;
            color: white;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .system-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-text {
            font-size: 14px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .brand-subtext {
            font-size: 8px;
            opacity: 0.7;
            font-weight: 600;
            display: block;
        }

        .form-label {
            text-align: right;
        }

        .form-label h1 {
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #3b82f6;
        }

        .form-label p {
            font-size: 9px;
            opacity: 0.8;
            font-weight: 700;
        }

        /* Generic Section Styling */
        .section {
            border-bottom: 1px solid #e2e8f0;
        }

        .section-header {
            background: #f8fafc;
            padding: 6px 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 9px;
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Grid System */
        .grid {
            display: table;
            width: 100%;
        }

        .grid-row {
            display: table-row;
        }

        .grid-item {
            display: table-cell;
            padding: 8px 15px;
            border-right: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .grid-item:last-child {
            border-right: none;
        }

        .label {
            font-size: 7.5px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 2px;
            display: block;
        }

        .value {
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
        }

        .highlight-box {
            background: #f1f5f9;
            padding: 8px 15px;
            border-radius: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .highlight-value {
            font-size: 11px;
            font-weight: 800;
            color: #3b82f6;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pendente { background: #fef9c3; color: #854d0e; }
        .status-em_execucao { background: #dbeafe; color: #1e40af; }
        .status-concluida { background: #dcfce7; color: #166534; }
        .status-cancelada { background: #fee2e2; color: #991b1b; }

        /* Multi-line Content */
        .content-area {
            padding: 8px 15px;
        }

        .text-box {
            font-size: 10px;
            color: #334155;
            line-height: 1.4;
            white-space: pre-wrap;
            max-height: 100px;
            overflow: hidden;
        }

        /* Signature Section */
        .signature-section {
            display: table;
            width: 100%;
            padding: 10px 15px;
            background: #fff;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            padding: 5px 15px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #cbd5e1;
            margin-top: 25px;
            padding-top: 5px;
        }

        .signature-name {
            font-size: 8.5px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
        }

        /* Footer */
        .footer {
            padding: 10px 15px;
            background: #f8fafc;
            font-size: 7.5px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1e293b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        @media print {
            body { padding: 0; }
            .print-btn { display: none; }
            .document-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">IMPRIMIR ORDEM DE SERVIÇO</button>

    <div class="document-container">
        <!-- Header -->
        <div class="top-bar">
            <div class="system-brand">
                <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo" style="width: 35px; height: 35px;">
                <div>
                    <span class="brand-text">VERTEX</span>
                    <span class="brand-subtext">Secretaria Municipal de Agricultura</span>
                </div>
            </div>
            <div class="form-label">
                <h1>ORDEM DE SERVIÇO</h1>
                <p>REGISTRO TÉCNICO DE EXECUÇÃO</p>
            </div>
        </div>

        <!-- 1. Informações da O.S -->
        <div class="highlight-box">
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="padding: 0; border: none; width: 33%;">
                        <span class="label">Número da O.S</span>
                        <div class="highlight-value">{{ $ordem->numero }}</div>
                    </div>
                    <div class="grid-item" style="padding: 0; border: none; width: 33%;">
                        <span class="label">Status de Execução</span>
                        <div class="status-badge status-{{ $ordem->status }}">{{ $ordem->status_texto }}</div>
                    </div>
                    <div class="grid-item" style="padding: 0; border: none; width: 34%;">
                        <span class="label">Data de Abertura</span>
                        <div class="value">{{ $ordem->data_abertura->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Equipe e Responsável -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">2. Equipe e Atribuição</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Equipe Executora</span>
                        <div class="value">{{ $ordem->equipe ? $ordem->equipe->nome : 'N/A' }}</div>
                    </div>
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Tipo de Serviço</span>
                        <div class="value">{{ $ordem->tipo_servico }}</div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Registrado por</span>
                        <div class="value">{{ $ordem->usuarioAbertura->name ?? 'Sistema' }}</div>
                    </div>
                    <div class="grid-item">
                        <span class="label">Prioridade Definida</span>
                        <div class="value">{{ $ordem->prioridade_texto }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Demanda Relacionada -->
        @if($ordem->demanda)
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">3. Informações da Demanda / Solicitante</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 33%;">
                        <span class="label">Protocolo da Demanda</span>
                        <div class="value" style="color: #3b82f6;">{{ $ordem->demanda->codigo ?? '#' . $ordem->demanda->id }}</div>
                    </div>
                    <div class="grid-item" style="width: 67%;">
                        <span class="label">Solicitante (Dados Protegidos LGPD)</span>
                        <div class="value">
                            {{ \App\Helpers\LgpdHelper::maskName($ordem->demanda->solicitante_nome ?? 'N/A') }}
                            @if($ordem->demanda->solicitante_apelido)
                                <span style="color: #4f46e5;">({{ $ordem->demanda->solicitante_apelido }})</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Localidade / Comunidade</span>
                        <div class="value">{{ $ordem->demanda->localidade ? $ordem->demanda->localidade->nome : 'N/A' }}</div>
                    </div>
                    <div class="grid-item">
                        <span class="label">Ponto de Referência</span>
                        <div class="value">{{ $ordem->demanda->localidade && $ordem->demanda->localidade->ponto_referencia ? $ordem->demanda->localidade->ponto_referencia : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- 4. Descrição do Trabalho -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">4. Descritivo da Solicitação</h2>
            </div>
            <div class="content-area">
                <span class="label">Instruções e Detalhes</span>
                <div class="text-box">{{ $ordem->descricao }}</div>
            </div>
        </div>

        <!-- 5. Cronologia e Relatório -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">5. Registro de Execução em Campo</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Início da Execução</span>
                        <div class="value">{{ $ordem->data_inicio ? $ordem->data_inicio->format('d/m/Y H:i') : 'Pendente' }}</div>
                    </div>
                    <div class="grid-item">
                        <span class="label">Conclusão do Serviço</span>
                        <div class="value">{{ $ordem->data_conclusao ? $ordem->data_conclusao->format('d/m/Y H:i') : 'Em aberto' }}</div>
                    </div>
                    <div class="grid-item">
                        <span class="label">Tempo Total</span>
                        <div class="value">{{ $ordem->tempo_execucao_formatado ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            @if($ordem->relatorio_execucao)
            <div class="content-area" style="background: #fdfdfd; border-top: 1px solid #f1f5f9;">
                <span class="label">Relatório Técnico de Execução</span>
                <div class="text-box" style="font-style: italic; color: #64748b;">
                    {{ $ordem->relatorio_execucao }}
                </div>
            </div>
            @endif
        </div>

        <!-- 6. Materiais Utilizados -->
        @if($ordem->materiais && $ordem->materiais->count() > 0)
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">6. Insumos e Materiais Utilizados</h2>
            </div>
            <div class="grid">
                <div class="grid-row" style="background: #f8fafc; font-weight: 800; font-size: 8px; color: #64748b; text-transform: uppercase;">
                    <div class="grid-item" style="padding: 5px 15px;">Material</div>
                    <div class="grid-item" style="padding: 5px 15px; width: 80px;">Qtd</div>
                    <div class="grid-item" style="padding: 5px 15px; width: 100px;">V. Unit.</div>
                    <div class="grid-item" style="padding: 5px 15px; width: 100px;">Total</div>
                </div>
                @foreach($ordem->materiais as $material)
                @php
                    $valorUnitario = $material->valor_unitario ?? 0;
                    $quantidade = $material->quantidade ?? 0;
                    $total = $valorUnitario * $quantidade;
                @endphp
                <div class="grid-row">
                    <div class="grid-item">{{ $material->material->nome ?? 'N/A' }}</div>
                    <div class="grid-item">{{ formatar_quantidade($quantidade, $material->material->unidade_medida ?? null) }}</div>
                    <div class="grid-item">R$ {{ number_format($valorUnitario, 2, ',', '.') }}</div>
                    <div class="grid-item"><div class="value">R$ {{ number_format($total, 2, ',', '.') }}</div></div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Assinaturas -->
        <div class="signature-section">
            <div class="signature-box">
                <span class="label">Responsável pela Execução</span>
                <div class="signature-line"></div>
                <span class="signature-name">{{ $ordem->equipe ? $ordem->equipe->nome : 'Técnico em Campo' }}</span>
                <p style="font-size: 7px; color: #94a3b8;">Confirmação de execução do serviço</p>
            </div>
            <div class="signature-box">
                <span class="label">Responsável Técnico / SEMAGRI</span>
                <div class="signature-line"></div>
                <span class="signature-name">Gestão Administrativa</span>
                <p style="font-size: 7px; color: #94a3b8;">Validação de registro oficial</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p><strong>DOCUMENTO OFICIAL DE ORDEM DE SERVIÇO - VERTEX</strong></p>
                <p>O registro oficial garante a rastreabilidade e transparência dos serviços públicos.</p>
            </div>
            <div style="text-align: right; opacity: 0.8;">
                <p>Emitido em: {{ date('d/m/Y H:i') }} | v2.0</p>
                <p>© {{ date('Y') }} VERTEX SEAMAGRI - Coração de Maria - BA</p>
            </div>
        </div>
    </div>

</body>
</html>
