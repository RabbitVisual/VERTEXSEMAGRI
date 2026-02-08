<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demanda {{ $demanda->codigo ?? '#' . $demanda->id }} - VERTEX</title>
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
            font-size: 10px;
            line-height: 1.4;
            color: #1e293b;
            background: white;
            padding: 15px;
        }

        .document-container {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        /* Top Bar / Header */
        .top-bar {
            background: #1e293b;
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .system-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-text {
            font-size: 16px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .brand-subtext {
            font-size: 9px;
            opacity: 0.7;
            font-weight: 600;
            display: block;
        }

        .form-label {
            text-align: right;
        }

        .form-label h1 {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #3b82f6;
        }

        .form-label p {
            font-size: 10px;
            opacity: 0.8;
            font-weight: 700;
        }

        /* Generic Section Styling */
        .section {
            border-bottom: 1px solid #e2e8f0;
        }

        .section-header {
            background: #f8fafc;
            padding: 8px 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 10px;
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
            padding: 12px 25px;
            border-right: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .grid-item:last-child {
            border-right: none;
        }

        .label {
            font-size: 8px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
        }

        .value {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
        }

        .highlight-box {
            background: #f1f5f9;
            padding: 12px 25px;
            border-radius: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .highlight-value {
            font-size: 12px;
            font-weight: 800;
            color: #3b82f6;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-aberta { background: #dcfce7; color: #166534; }
        .status-pendente { background: #fef9c3; color: #854d0e; }
        .status-concluida { background: #dbeafe; color: #1e40af; }
        .status-cancelada { background: #fee2e2; color: #991b1b; }

        /* QR Code flutuante lateral */
        .qr-side {
            float: right;
            padding: 15px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-left: 20px;
            text-align: center;
        }

        .qr-side canvas {
            width: 90px !important;
            height: 90px !important;
            display: block;
            margin: 0 auto 5px auto;
        }

        .qr-side p {
            font-size: 7px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
        }

        /* Multi-line Content */
        .content-area {
            padding: 15px 25px;
        }

        .text-box {
            font-size: 11px;
            color: #334155;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        /* Footer */
        .footer {
            padding: 15px 25px;
            background: #f8fafc;
            font-size: 8px;
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

    <button class="print-btn" onclick="window.print()">IMPRIMIR DOCUMENTO</button>

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
                <h1>FICHA DE DEMANDA</h1>
                <p>PROTOCOLO DE ATENDIMENTO PÚBLICO</p>
            </div>
        </div>

        <!-- 1. Informações do Protocolo -->
        <div class="highlight-box">
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="padding: 0; border: none; width: 33%;">
                        <span class="label">Código do Protocolo</span>
                        <div class="highlight-value">{{ $demanda->codigo ?? 'DEM-' . str_pad($demanda->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="grid-item" style="padding: 0; border: none; width: 33%;">
                        <span class="label">Status Atual</span>
                        @php
                            $statusClass = 'status-' . ($demanda->status ?? 'aberta');
                            $statusLabel = match($demanda->status) {
                                'aberta' => 'Aberta / Pendente',
                                'em_andamento' => 'Em Atendimento',
                                'concluida' => 'Serviço Concluído',
                                'cancelada' => 'Demanda Cancelada',
                                default => 'Aberta'
                            };
                        @endphp
                        <div class="status-badge {{ $statusClass }}">{{ $statusLabel }}</div>
                    </div>
                    <div class="grid-item" style="padding: 0; border: none; width: 34%;">
                        <span class="label">Data de Registro</span>
                        <div class="value">
                            {{ $demanda->data_abertura ? $demanda->data_abertura->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Dados do Solicitante -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">2. Identificação do Solicitante</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 65%;">
                        <span class="label">Nome Completo / Interessado</span>
                        <div class="value">
                            {{ \App\Helpers\LgpdHelper::maskName($demanda->solicitante_nome ?? 'N/A') }}
                            @if($demanda->solicitante_apelido)
                                <span style="color: #4f46e5; font-weight: 600;">({{ $demanda->solicitante_apelido }})</span>
                            @elseif($demanda->pessoa && $demanda->pessoa->nom_apelido_pessoa)
                                <span style="color: #4f46e5; font-weight: 600;">({{ $demanda->pessoa->nom_apelido_pessoa }})</span>
                            @endif
                        </div>
                    </div>
                    <div class="grid-item" style="width: 35%;">
                        <span class="label">CPF / CNPJ</span>
                        <div class="value">
                            {{ $demanda->pessoa && $demanda->pessoa->num_cpf_pessoa
                                ? \App\Helpers\LgpdHelper::maskCpf($demanda->pessoa->num_cpf_pessoa)
                                : 'Não informado' }}
                        </div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Telefone / WhatsApp</span>
                        <div class="value">{{ \App\Helpers\LgpdHelper::maskPhone($demanda->solicitante_telefone ?? 'N/A') }}</div>
                    </div>
                    <div class="grid-item">
                        <span class="label">E-mail</span>
                        <div class="value">{{ $demanda->solicitante_email ? \App\Helpers\LgpdHelper::maskEmail($demanda->solicitante_email) : 'Não informado' }}</div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Apelido na Comunidade</span>
                        <div class="value">{{ $demanda->solicitante_apelido ?? ($demanda->pessoa ? $demanda->pessoa->nom_apelido_pessoa : 'N/A') }}</div>
                    </div>
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">CadÚnico (NIS)</span>
                        <div class="value">{{ $demanda->pessoa && $demanda->pessoa->num_nis_pessoa_atual ? \App\Helpers\LgpdHelper::maskNis($demanda->pessoa->num_nis_pessoa_atual) : 'Não informado' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Localização -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">3. Localização da Necessidade</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Localidade / Comunidade</span>
                        <div class="value">{{ $demanda->localidade ? $demanda->localidade->nome : 'N/A' }}</div>
                    </div>
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Ponto de Referência</span>
                        <div class="value">{{ $demanda->localidade && $demanda->localidade->ponto_referencia ? $demanda->localidade->ponto_referencia : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Detalhamento Técnico -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">4. Detalhamento da Solicitação</h2>
            </div>
            <div class="content-area">
                <div class="qr-side">
                    <canvas id="qrcode-canvas"></canvas>
                    <p>Acompanhamento Online</p>
                </div>
                <span class="label">Motivo do Chamado</span>
                <div class="value" style="margin-bottom: 15px; font-size: 13px; color: #3b82f6;">
                    {{ $demanda->motivo ?? 'N/A' }}
                </div>

                <span class="label">Descrição Detalhada</span>
                <div class="text-box">{{ $demanda->descricao ?? 'Sem descrição detalhada disponível.' }}</div>
            </div>
        </div>

        <!-- 5. Informações de Execução (Se houver OS) -->
        @if($demanda->ordemServico)
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">5. Ordem de Serviço Vinculada</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 33%;">
                        <span class="label">Nº Ordem de Serviço</span>
                        <div class="value">#{{ $demanda->ordemServico->numero ?? $demanda->ordemServico->id }}</div>
                    </div>
                    <div class="grid-item" style="width: 33%;">
                        <span class="label">Equipe Responsável</span>
                        <div class="value">{{ $demanda->ordemServico->equipe ? $demanda->ordemServico->equipe->nome : 'A definir' }}</div>
                    </div>
                    <div class="grid-item" style="width: 34%;">
                        <span class="label">Data de Conclusão</span>
                        <div class="value">
                            {{ $demanda->data_conclusao ? $demanda->data_conclusao->format('d/m/Y') : 'Em aberto' }}
                        </div>
                    </div>
                </div>
            </div>
            @if($demanda->ordemServico->relatorio_execucao)
            <div class="content-area" style="background: #fdfdfd; border-top: 1px solid #f1f5f9;">
                <span class="label">Relatório Final de Execução</span>
                <div class="text-box" style="font-style: italic; color: #64748b;">
                    {{ $demanda->ordemServico->relatorio_execucao }}
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div>
                <p><strong>DOCUMENTO OFICIAL GERADO PELO SISTEMA VERTEX</strong></p>
                <p>Este comprovante garante o registro da sua demanda em nossa base de dados.</p>
            </div>
            <div style="text-align: right; opacity: 0.8;">
                <p>Emitido em: {{ date('d/m/Y H:i') }} | v2.0</p>
                <p>© {{ date('Y') }} VERTEX SEAMAGRI - Coração de Maria - BA</p>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrCodeUrl = '{{ route('demandas.public.show', ['codigo' => $demanda->codigo]) }}';

            const generateQR = () => {
                if (typeof window.generateQRCode !== 'undefined') {
                    window.generateQRCode(qrCodeUrl, 'qrcode-canvas', {
                        width: 90,
                        margin: 0,
                        color: { dark: '#1e293b', light: '#FFFFFF' }
                    });
                } else {
                    setTimeout(generateQR, 500);
                }
            };
            generateQR();
        });
    </script>
</body>
</html>
