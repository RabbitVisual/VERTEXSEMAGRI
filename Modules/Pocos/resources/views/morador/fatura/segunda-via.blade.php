<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2ª Via de Fatura - {{ $boleto->numero_boleto }}</title>
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
            padding: 15px; /* Reduzido de 20px */
        }

        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        /* Top Bar */
        .top-bar {
            background: #1e293b;
            color: white;
            padding: 12px 20px; /* Reduzido de 15px 25px */
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
            font-size: 15px; /* Levemente reduzido */
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .brand-subtext {
            font-size: 8px; /* Reduzido de 9px */
            opacity: 0.7;
            font-weight: 600;
            display: block;
        }

        .invoice-label {
            text-align: right;
        }

        .invoice-label h1 {
            font-size: 16px; /* Reduzido de 18px */
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #3b82f6;
        }

        .invoice-label p {
            font-size: 9px;
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
            padding: 10px 20px; /* Reduzido de 15px 25px */
            border-right: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .grid-item:last-child {
            border-right: none;
        }

        .label {
            font-size: 7px; /* Reduzido de 8px */
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
            display: block;
        }

        .value {
            font-size: 10px; /* Reduzido de 11px */
            font-weight: 700;
            color: #0f172a;
        }

        /* Main Data Section */
        .main-info {
            background: #f8fafc;
            padding: 15px 20px; /* Reduzido de 25px */
            border-bottom: 1px solid #e2e8f0;
        }

        .customer-header {
            font-size: 8px; /* Reduzido */
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #cbd5e1;
            display: block;
        }

        .customer-name {
            font-size: 18px; /* Reduzido de 20px */
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .customer-address {
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
        }

        /* Financial Section */
        .financial-summary {
            padding: 0;
            background: white;
            display: table;
            width: 100%;
        }

        .summary-box {
            display: table-cell;
            padding: 15px 20px; /* Reduzido de 25px */
            width: 33.33%;
            border-right: 1px solid #e2e8f0;
        }

        .summary-box:last-child {
            border-right: none;
            background: #eff6ff;
            text-align: center;
        }

        .total-label {
            font-size: 10px; /* Reduzido de 11px */
            font-weight: 900;
            color: #1e40af;
            text-transform: uppercase;
        }

        .total-value {
            font-size: 24px; /* Reduzido de 28px */
            font-weight: 900;
            color: #1e40af;
            margin-top: 4px;
        }

        /* PIX Section */
        .payment-options {
            padding: 15px 20px; /* Reduzido de 25px */
            background: #f0fdf4;
            border-bottom: 1px solid #e2e8f0;
        }

        .pix-container {
            display: flex;
            gap: 20px; /* Reduzido de 25px */
            align-items: center;
        }

        .pix-qr {
            flex-shrink: 0;
            background: white;
            padding: 8px; /* Reduzido de 10px */
            border: 1px solid #b7e4c7;
            border-radius: 12px;
        }

        .pix-details {
            flex-grow: 1;
        }

        .pix-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #22c55e;
            color: white;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 9px; /* Reduzido de 10px */
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .pix-key {
            font-family: monospace;
            font-size: 12px; /* Reduzido de 14px */
            font-weight: 900;
            color: #166534;
            background: white;
            padding: 8px;
            border: 1px solid #b7e4c7;
            border-radius: 8px;
            word-break: break-all;
            display: block;
        }

        /* Instructions Section */
        .instructions-section {
            padding: 12px 20px; /* Reduzido de 20px 25px */
            border-bottom: 1px solid #e2e8f0;
        }

        .instructions-section h3 {
            font-size: 9px; /* Reduzido de 10px */
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .instructions-section ul {
            list-style: none;
        }

        .instructions-section li {
            font-size: 8px; /* Reduzido de 9px */
            color: #64748b;
            margin-bottom: 3px;
            padding-left: 12px;
            position: relative;
        }

        .instructions-section li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #3b82f6;
        }

        /* Legal Disclaimer */
        .disclaimer-section {
            padding: 12px 20px; /* Reduzido de 20px 25px */
            background: #f1f5f9;
            font-size: 8px; /* Reduzido de 9px */
            color: #475569;
            text-align: justify;
        }

        .disclaimer-section p {
            margin-bottom: 6px;
        }

        .disclaimer-section strong {
            color: #0f172a;
        }

        /* Footer */
        .footer {
            padding: 10px 20px; /* Reduzido de 15px 25px */
            background: white;
            font-size: 7px; /* Reduzido de 8px */
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media print {
            body { padding: 0; }
            .invoice-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>

    <div class="invoice-container">
        <!-- Header -->
        <div class="top-bar">
            <div class="system-brand">
                <img src="{{ public_path('images/logo-icon.svg') }}" alt="Logo" style="width: 35px; height: 35px;">
                <div>
                    <span class="brand-text">VERTEX</span>
                    <span class="brand-subtext">Gestão de Recursos Comunitários</span>
                </div>
            </div>
            <div class="invoice-label">
                <h1>FATURA / 2ª VIA</h1>
                <p>Nº {{ $boleto->numero_boleto }}</p>
            </div>
        </div>

        <!-- Info Grid 1 -->
        <div class="grid-section">
            <div class="grid-item">
                <span class="label">Mês de Referência</span>
                <span class="value">{{ $boleto->mensalidade->mes_ano }}</span>
            </div>
            <div class="grid-item">
                <span class="label">Data de Emissão</span>
                <span class="value">{{ $boleto->data_emissao->format('d/m/Y') }}</span>
            </div>
            <div class="grid-item">
                <span class="label">Vencimento</span>
                <span class="value" style="color: #ef4444;">{{ $boleto->data_vencimento->format('d/m/Y') }}</span>
            </div>
        </div>

        <!-- Customer Section -->
        <div class="main-info">
            <span class="customer-header">Unidade Consumidora / Morador</span>
            <h2 class="customer-name">{{ $usuario->nome }}</h2>
            <p class="customer-address">
                {{ $usuario->endereco }}{{ $usuario->numero_casa ? ', ' . $usuario->numero_casa : '' }}<br>
                {{ $boleto->poco->localidade->nome ?? 'Localidade Central' }} • CPF: {{ $usuario->cpf_formatado ?? '---' }}
            </p>
        </div>

        <!-- Info Grid 2 (Location details) -->
        <div class="grid-section">
            <div class="grid-item" style="width: 60%;">
                <span class="label">Unidade Produtora (Poço)</span>
                <span class="value">{{ $boleto->poco->nome_mapa ?? $boleto->poco->codigo }}</span>
            </div>
            <div class="grid-item">
                <span class="label">Gestão Responsável</span>
                <span class="value">{{ $boleto->poco->lider->name ?? 'Liderança Comunitária' }}</span>
            </div>
        </div>

        <!-- Payment Options (PIX) -->
        @if($boleto->mensalidade->forma_recebimento == 'pix' && $boleto->mensalidade->chave_pix)
        <div class="payment-options">
            <div class="pix-container">
                <div class="pix-qr">
                    @if(!empty($qrCodeDataUrl) && str_starts_with($qrCodeDataUrl, 'data:image'))
                        <img src="{{ $qrCodeDataUrl }}" alt="QR Code PIX" style="width: 110px; height: 110px; display: block;">
                    @else
                        <div style="width: 110px; height: 110px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-align: center; color: #94a3b8; font-size: 8px;">
                            QR Code<br>Indisponível
                        </div>
                    @endif
                </div>
                <div class="pix-details">
                    <div class="pix-badge">
                        <svg style="width: 12px; height: 12px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 4c-3.79 0-6.86 3.07-6.86 6.86 0 2.21 1.04 4.17 2.66 5.43l4.2-4.2c.42-.42 1.1-.42 1.52 0l4.2 4.2c1.62-1.26 2.66-3.22 2.66-5.43 0-3.79-3.07-6.86-6.88-6.86zm-.01 10.43c-.79 0-1.43-.64-1.43-1.43 0-.79.64-1.43 1.43-1.43s1.43.64 1.43 1.43c0 .79-.64 1.43-1.43 1.43z"/></svg>
                        Pagamento via PIX
                    </div>
                    <span class="label" style="display: block; margin-bottom: 2px;">Chave PIX (Copie e Cole)</span>
                    <code class="pix-key">{{ $boleto->mensalidade->chave_pix }}</code>
                </div>
            </div>
        </div>
        @endif

        <!-- Financial Summary -->
        <div class="financial-summary">
            <div class="summary-box">
                <span class="label">Código do Boleto</span>
                <span class="value" style="font-family: monospace;">{{ $boleto->numero_boleto }}</span>
            </div>
            <div class="summary-box">
                <span class="label">Status Atual</span>
                <span class="value" style="color: #3b82f6; text-transform: uppercase;">{{ $boleto->status }}</span>
            </div>
            <div class="summary-box">
                <span class="total-label">Total a Pagar</span>
                <div class="total-value">R$ {{ number_format($boleto->valor, 2, ',', '.') }}</div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="instructions-section">
            <h3>Instruções de Pagamento</h3>
            <ul>
                @if($boleto->instrucoes)
                    <li>{!! nl2br(e($boleto->instrucoes)) !!}</li>
                @endif
                <li>Este boleto é referente à mensalidade de conservação do poço artesiano comunitário.</li>
                <li>O não pagamento pode levar à suspensão do fornecimento de água pela gestão local.</li>
                <li>Em caso de dúvidas, procure o seu líder comunitário.</li>
            </ul>
        </div>

        <!-- Legal Disclaimer -->
        <div class="disclaimer-section">
            <p><strong>AVISO LEGAL E TERMO DE RESPONSABILIDADE:</strong></p>
            <p>
                Este sistema (VERTEX SEAMAGRI) é disponibilizado pela municipalidade exclusivamente como ferramenta tecnológica de apoio à organização e gestão comunitária de poços artesianos.
                <strong>O faturamento, a arrecadação e a gestão financeira destes recursos são de responsabilidade integral e exclusiva da gestão local da comunidade/poço</strong>,
                representada pelo líder comunitário responsável.
            </p>
            <p>
                A municipalidade não atua como recebedora, garantidora ou beneficiária direta desta transação financeira. Este documento possui validade como cobrança oficial da gestão comunitária local.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p>Documento emitido digitalmente em {{ now()->format('d/m/Y H:i:s') }}</p>
                <p>Sistema de Apoio à Agricultura Familiar - VERTEX</p>
            </div>
            <div style="text-align: right; opacity: 0.5;">
                <p>Autenticação: {{ strtoupper(substr(md5($boleto->id . $boleto->numero_boleto), 0, 16)) }}</p>
                <p>© {{ date('Y') }} Direitos Reservados</p>
            </div>
        </div>
    </div>

</body>
</html>
