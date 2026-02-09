<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Credenciais - {{ $funcionario->nome }}</title>

    <!-- Inter Font Local -->
    <style>
        @font-face {
            font-family: 'Inter';
            src: url('/fonts/Inter-VariableFont_slnt,wght.ttf') format('truetype');
            font-weight: 100 900;
            font-style: normal;
        }

        :root {
            --margin: 1.27cm;
            --color-black: #000;
            --color-gray: #4b5563;
            --color-light-gray: #f3f4f6;
            --primary: #111827;
            --emerald: #059669;
        }

        @page {
            size: A4;
            margin: var(--margin);
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 40px;
            background-color: #f1f5f9;
            color: var(--color-black);
            font-size: 10pt;
            line-height: 1.5;
        }

        .a4-page {
            width: 210mm;
            min-height: 297mm;
            padding: var(--margin);
            background: white;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            border-radius: 4px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            .a4-page {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
            }
            .no-print {
                display: none !important;
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--primary);
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo-section h2 {
            margin: 0;
            font-size: 24pt;
            font-weight: 900;
            letter-spacing: -1.5px;
            color: var(--primary);
        }

        .logo-section p {
            margin: 0;
            font-size: 8pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--color-gray);
        }

        .doc-info {
            text-align: right;
        }

        .doc-info h1 {
            font-size: 12pt;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
        }

        .doc-info p {
            font-size: 8pt;
            font-weight: 700;
            color: var(--color-gray);
            margin: 4px 0 0;
            font-family: monospace;
        }

        .section-title {
            font-size: 8pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--color-gray);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .data-item {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .data-item label {
            display: block;
            font-size: 7pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .data-item span {
            font-size: 11pt;
            font-weight: 700;
            color: var(--primary);
        }

        .credentials-card {
            background: #f0fdf4;
            border: 2px dashed #059669;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 40px 0;
            position: relative;
        }

        .credentials-card::before {
            content: 'CONFIDENCIAL';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 40pt;
            font-weight: 900;
            color: rgba(5, 150, 105, 0.05);
            pointer-events: none;
            z-index: 0;
        }

        .password-box {
            background: white;
            border: 1px solid #d1fae5;
            padding: 20px;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05);
            margin-top: 15px;
            position: relative;
            z-index: 1;
        }

        .password-text {
            font-family: 'Courier New', monospace;
            font-size: 32pt;
            font-weight: 900;
            letter-spacing: 8px;
            color: #065f46;
        }

        .login-url {
            font-family: monospace;
            background: #f3f4f6;
            padding: 10px 20px;
            border-radius: 6px;
            margin: 20px 0;
            display: inline-block;
            font-size: 10pt;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .footer {
            margin-top: 60px;
            display: flex;
            gap: 40px;
            border-top: 1px solid #e5e7eb;
            padding-top: 40px;
        }

        .qr-code {
            width: 140px;
            height: 140px;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
        }

        .instructions {
            flex: 1;
        }

        .instructions h3 {
            font-size: 10pt;
            font-weight: 900;
            margin: 0 0 15px 0;
            text-transform: uppercase;
            color: var(--primary);
        }

        .instructions ul {
            margin: 0;
            padding-left: 18px;
            font-size: 9pt;
            color: #4b5563;
        }

        .instructions li {
            margin-bottom: 8px;
        }

        .signature-area {
            margin-top: 80px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid var(--primary);
            width: 300px;
            display: inline-block;
            padding-top: 10px;
        }

        .signature-line b {
            font-size: 9pt;
            text-transform: uppercase;
            display: block;
        }

        .signature-line span {
            font-size: 7pt;
            color: var(--color-gray);
            font-weight: 600;
        }

        .btn-print {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background: var(--primary);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 900;
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            z-index: 1000;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            background: #000;
        }
    </style>
</head>
<body>

    <button class="btn-print no-print" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Imprimir Comprovante
    </button>

    <div class="a4-page">
        <header class="header">
            <div class="logo-section">
                <img src="/images/logo-icon.svg" alt="Logo" style="width: 48px; height: 48px;">
                <div>
                    <h2>VERTEX</h2>
                    <p>Secretaria de Agricultura</p>
                </div>
            </div>
            <div class="doc-info">
                <h1>PROTOCOLO DE ACESSO</h1>
                <p>REF: {{ date('Y') }}/{{ str_pad($funcionario->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p>EXPEDIÇÃO: {{ now()->format('d.m.Y - H:i') }}</p>
            </div>
        </header>

        <div class="section-title">Informações do Colaborador</div>
        <div class="data-grid">
            <div class="data-item">
                <label>NOME COMPLETO</label>
                <span>{{ strtoupper($funcionario->nome) }}</span>
            </div>
            <div class="data-item">
                <label>MATRÍCULA OPERACIONAL</label>
                <span>{{ $funcionario->codigo ?? 'NÃO ATRIBUÍDA' }}</span>
            </div>
            <div class="data-item">
                <label>FUNÇÃO / CARGO</label>
                <span>{{ strtoupper($funcionario->funcao ?? 'AGENTE DE CAMPO') }}</span>
            </div>
            <div class="data-item">
                <label>CADASTRO (CPF)</label>
                <span>{{ $funcionario->cpf ?? '---' }}</span>
            </div>
        </div>

        <div class="section-title">Diretrizes de Segurança</div>
        <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 20px; border-radius: 8px; font-size: 9pt; color: #92400e; font-weight: 500;">
            <b>AVISO CRÍTICO:</b> Este documento contém informações de acesso restrito. Ao assinar este recebimento, o colaborador assume total responsabilidade legal e administrativa pelas ações realizadas no sistema sob sua credencial. A senha é pessoal, intransferível e deve ser alterada imediatamente no primeiro login.
        </div>

        <div class="credentials-card">
            <p style="text-transform: uppercase; font-size: 8pt; font-weight: 900; color: #065f46; letter-spacing: 2px; margin-bottom: 20px;">DADOS DE IDENTIFICAÇÃO DIGITAL</p>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 7pt; font-weight: 800; color: #059669; margin-bottom: 5px;">ID DE USUÁRIO (LOGIN)</label>
                <div style="font-size: 16pt; font-weight: 900; color: #111827;">{{ $user->email }}</div>
            </div>

            <div class="password-box">
                <label style="display: block; font-size: 7pt; font-weight: 800; color: #059669; margin-bottom: 5px;">SENHA TEMPORÁRIA</label>
                <div class="password-text">{{ $senha }}</div>
            </div>

            <div style="margin-top: 30px;">
                <p style="font-size: 8pt; color: #6b7280; font-weight: 700; margin-bottom: 8px;">PORTAL DE ACESSO:</p>
                <div class="login-url">{{ $urlLogin }}</div>
            </div>
        </div>

        <div class="footer">
            <div class="qr-code">
                <div id="qrcode"></div>
            </div>
            <div class="instructions">
                <h3>Instruções de Primeiro Acesso</h3>
                <ul>
                    <li>Acesse o portal através do QR Code ou URL impressos neste documento.</li>
                    <li>Utilize seu e-mail e a senha temporária de 8 dígitos acima.</li>
                    <li>Siga os passos de segurança para definir sua senha definitiva.</li>
                    <li>Mantenha este comprovante em local seguro ou destrua-o após a alteração.</li>
                    <li>Suporte Técnico: secretaria.agricultura@vertex.gov.br</li>
                </ul>
            </div>
        </div>

        <div class="signature-area">
            <div class="signature-line">
                <b>{{ strtoupper($funcionario->nome) }}</b>
                <span>ASSINATURA DO RECEBEDOR</span>
            </div>
        </div>

        <div style="position: absolute; bottom: 20px; left: 0; right: 0; text-align: center; font-size: 7pt; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
            VERTEX SEMAGRI &copy; {{ date('Y') }} - SISTEMA DE INTELIGÊNCIA AGROINDUSTRIAL
        </div>
    </div>

    <!-- Script QR Code -->
    <script src="/js/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $urlLogin }}",
            width: 120,
            height: 120,
            colorDark : "#111827",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>
