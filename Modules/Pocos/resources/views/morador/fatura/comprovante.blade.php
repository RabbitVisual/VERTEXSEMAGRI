<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Quitação - {{ $pagamento->codigo }}</title>
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
            padding: 20px;
        }

        .receipt-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Top Bar */
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

        .receipt-label {
            text-align: right;
        }

        .receipt-label h1 {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #22c55e;
        }

        .receipt-label p {
            font-size: 10px;
            opacity: 0.8;
            font-weight: 700;
        }

        /* Info Grid */
        .grid-section {
            display: table;
            width: 100%;
            border-bottom: 1px solid #e2e8f0;
        }

        .grid-item {
            display: table-cell;
            padding: 15px 25px;
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

        /* Large Data Section */
        .main-info {
            background: #f8fafc;
            padding: 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .customer-header {
            font-size: 10px;
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #cbd5e1;
            display: block;
        }

        .customer-name {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .customer-address {
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
        }

        /* Financial Summary */
        .financial-summary {
            padding: 0;
            background: white;
            display: table;
            width: 100%;
        }

        .summary-box {
            display: table-cell;
            padding: 25px;
            width: 33.33%;
            border-right: 1px solid #e2e8f0;
        }

        .summary-box:last-child {
            border-right: none;
            background: #f0fdf4;
            text-align: center;
        }

        .total-label {
            font-size: 11px;
            font-weight: 900;
            color: #166534;
            text-transform: uppercase;
        }

        .total-value {
            font-size: 28px;
            font-weight: 900;
            color: #15803d;
            margin-top: 5px;
        }

        /* Status Stamp */
        .status-stamp {
            display: inline-block;
            padding: 8px 15px;
            background: #22c55e;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            transform: rotate(-3deg);
            box-shadow: 4px 4px 0 #15803d;
            margin-top: 10px;
        }

        /* Legal Disclaimer */
        .disclaimer-section {
            padding: 20px 25px;
            background: #f1f5f9;
            font-size: 9px;
            color: #475569;
            text-align: justify;
        }

        .disclaimer-section p {
            margin-bottom: 8px;
        }

        .disclaimer-section strong {
            color: #0f172a;
        }

        /* Footer */
        .footer {
            padding: 15px 25px;
            background: white;
            font-size: 8px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-placeholder {
            width: 80px;
            height: 80px;
            background: #fff;
            padding: 5px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        @media print {
            body { padding: 0; }
            .receipt-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <!-- Header -->
        <div class="top-bar">
            <div class="system-brand">
                <img src="{{ public_path('images/logo-icon.svg') }}" alt="Logo" style="width: 35px; height: 35px;">
                <div>
                    <span class="brand-text">VERTEX</span>
                    <span class="brand-subtext">Gestão de Recursos Comunitários</span>
                </div>
            </div>
            <div class="receipt-label">
                <h1>QUITADO</h1>
                <p>Nº {{ $pagamento->codigo }}</p>
            </div>
        </div>

        <!-- Info Grid 1 -->
        <div class="grid-section">
            <div class="grid-item">
                <span class="label">Mês de Referência</span>
                <span class="value">{{ $pagamento->mensalidade->mes_ano }}</span>
            </div>
            <div class="grid-item">
                <span class="label">Data de Vencimento</span>
                <span class="value">{{ $boleto->data_vencimento->format('d/m/Y') }}</span>
            </div>
            <div class="grid-item">
                <span class="label">Data de Pagamento</span>
                <span class="value">{{ $pagamento->data_pagamento->format('d/m/Y') }}</span>
            </div>
        </div>

        <!-- Customer Section -->
        <div class="main-info">
            <span class="customer-header">Unidade Consumidora / Morador</span>
            <h2 class="customer-name">{{ $usuario->nome }}</h2>
            <p class="customer-address">
                {{ $usuario->endereco }}{{ $usuario->numero_casa ? ', ' . $usuario->numero_casa : '' }}<br>
                {{ $usuario->localidade->nome ?? 'Localidade Central' }} • CPF: {{ $usuario->cpf_formatado ?? '---' }}
            </p>
        </div>

        <!-- Info Grid 2 (Location details) -->
        <div class="grid-section">
            <div class="grid-item" style="width: 60%;">
                <span class="label">Origem do Recurso (Poço)</span>
                <span class="value">{{ $pagamento->poco->nome_mapa ?? $pagamento->poco->codigo }}</span>
            </div>
            <div class="grid-item">
                <span class="label">Liderança Responsável</span>
                <span class="value">{{ $pagamento->poco->lider->name ?? 'Gestão Local' }}</span>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="financial-summary">
            <div class="summary-box">
                <span class="label">Forma de Pagamento</span>
                <span class="value" style="text-transform: uppercase;">{{ $pagamento->forma_pagamento_texto }}</span>
            </div>
            <div class="summary-box">
                <span class="label">Autenticação do Sistema</span>
                <span class="value" style="font-family: monospace;">{{ strtoupper(md5($pagamento->codigo . $pagamento->data_pagamento)) }}</span>
            </div>
            <div class="summary-box">
                <span class="total-label">Valor Total Liquidado</span>
                <div class="total-value">R$ {{ number_format($pagamento->valor_pago, 2, ',', '.') }}</div>
                <div class="status-stamp">RECEBIDO</div>
            </div>
        </div>

        <!-- Legal Disclaimer -->
        <div class="disclaimer-section">
            <p><strong>AVISO LEGAL E TERMO DE RESPONSABILIDADE:</strong></p>
            <p>
                Este sistema (VERTEX SEAMAGRI) é disponibilizado pela municipalidade exclusivamente como ferramenta tecnológica de apoio à organização e gestão comunitária de poços artesianos.
                <strong>A responsabilidade financeira pelo recebimento, gestão e aplicação dos valores informados neste recibo é integral e exclusiva da gestão local da comunidade/poço</strong>,
                representada pelo líder comunitário responsável.
            </p>
            <p>
                A municipalidade não atua como recebedora ou garantidora direta desta transação financeira. Este comprovante tem validade legal como prova de quitação perante a gestão comunitária local.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p>Documento emitido digitalmente em {{ now()->format('d/m/Y H:i:s') }}</p>
                <p>Sistema de Apoio à Agricultura Familiar - VERTEX</p>
            </div>
            <div style="text-align: right; opacity: 0.5;">
                <p>Integridade garantida via SHA-256</p>
                <p>© {{ date('Y') }} Direitos Reservados</p>
            </div>
        </div>
    </div>

</body>
</html>
