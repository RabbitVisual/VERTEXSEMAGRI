<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Credenciais - {{ $funcionario->nome }}</title>

    @vite(['resources/css/app.css', 'resources/js/qrcode.js'])

    <style>
        :root {
            --margin: 1.27cm; /* Margem exata solicitada */
            --color-black: #000;
            --color-gray: #4b5563;
            --color-light-gray: #f3f4f6;
            --border-width: 1px;
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
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px; /* Padding para visualização em tela */
            background-color: #fce7f3; /* Cor de fundo suave para tela */
            color: var(--color-black);
            font-size: 10pt;
            line-height: 1.3;
        }

        .a4-page {
            width: 210mm;
            min-height: 297mm;
            padding: var(--margin);
            background: white;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Utilitários de Impressão */
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
                padding: 0; /* A margem é controlada pelo @page */
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
        }

        /* Layout Grid */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--color-black);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo-section img {
            height: 60px;
            width: auto;
        }

        .doc-title {
            text-align: right;
        }

        .doc-title h1 {
            font-size: 16pt;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .doc-title p {
            font-size: 9pt;
            color: var(--color-gray);
            margin: 5px 0 0;
        }

        /* Box Styles */
        .box {
            border: 1px solid var(--color-black);
            margin-bottom: 15px;
        }

        .box-header {
            background-color: #e5e7eb;
            padding: 5px 10px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 8pt;
            border-bottom: 1px solid var(--color-black);
        }

        .box-content {
            padding: 10px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .field {
            display: flex;
            flex-direction: column;
        }

        .field label {
            font-size: 7pt;
            color: var(--color-gray);
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .field span {
            font-size: 10pt;
            font-weight: 500;
        }

        /* Credenciais em Destaque */
        .credentials-box {
            background-color: #f9fafb;
            border: 2px dashed var(--color-black);
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }

        .password-display {
            font-family: 'Courier New', Courier, monospace;
            font-size: 24pt;
            font-weight: 700;
            letter-spacing: 3px;
            background: #fff;
            padding: 10px 20px;
            border: 1px solid #ccc;
            display: inline-block;
            margin: 10px 0;
        }

        .url-box {
            background-color: var(--color-light-gray);
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            font-family: monospace;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        /* QR Code Footer */
        .footer-section {
            display: flex;
            margin-top: auto;
            border-top: 1px solid var(--color-black);
            padding-top: 20px;
            gap: 20px;
        }

        .qr-area {
            width: 120px;
            flex-shrink: 0;
            border: 1px solid #ccc;
            padding: 5px;
        }

        .instructions {
            flex-grow: 1;
        }

        .instructions h3 {
            font-size: 10pt;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }

        .instructions ul {
            margin: 0;
            padding-left: 15px;
            font-size: 9pt;
        }

        .instructions li {
            margin-bottom: 5px;
        }

        /* Botão Flutuante */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #000;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            cursor: pointer;
            border: none;
            transition: transform 0.2s;
            z-index: 1000;
        }

        .fab:hover {
            transform: scale(1.1);
        }

        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            padding-top: 5px;
            font-size: 8pt;
        }
    </style>
</head>
<body>

    <!-- Botão de Impressão -->
    <button class="fab no-print" onclick="window.print()" title="Imprimir (Ctrl+P)">
        <x-icon name="print" style="duotone" class="w-6 h-6 text-white" />
    </button>

    <div class="a4-page">
        <!-- Cabeçalho -->
        <header class="header">
            <div class="logo-section" style="display: flex; align-items: center; gap: 15px;">
                <img src="{{ asset('images/logo-icon.svg') }}" alt="VERTEX Logo" style="width: 50px; height: 50px; object-fit: contain;">
                <div>
                    <h2 style="margin: 0; font-size: 16pt; font-weight: 900; line-height: 1; letter-spacing: -0.5px;">VERTEX</h2>
                    <p style="margin: 2px 0 0 0; font-size: 8pt; font-weight: 500; color: var(--color-gray); text-transform: uppercase;">Secretaria Municipal de Agricultura</p>
                </div>
            </div>
            <div class="doc-title">
                <h1>COMPROVANTE DE<br>CREDENCIAIS</h1>
                <p>Nº DO PROTOCOLO: {{ date('Y') }}.{{ str_pad($funcionario->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p>EMISSÃO: {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </header>

        <!-- Dados do Funcionário -->
        <div class="box">
            <div class="box-header">1. DADOS DO COLABORADOR</div>
            <div class="box-content">
                <div class="field">
                    <label>NOME COMPLETO</label>
                    <span>{{ strtoupper($funcionario->nome) }}</span>
                </div>
                <div class="field">
                    <label>MATRÍCULA / CÓDIGO</label>
                    <span>{{ $funcionario->codigo ?? 'N/A' }}</span>
                </div>
                <div class="field">
                    <label>CARGO / FUNÇÃO</label>
                    <span>{{ strtoupper($funcionario->funcao ?? 'Não Informado') }}</span>
                </div>
                <div class="field">
                    <label>VÍNCULO</label>
                    <span>ATIVO</span>
                </div>
            </div>
        </div>

        <!-- Credenciais -->
        <div class="box">
            <div class="box-header">2. CREDENCIAIS DE ACESSO AO SISTEMA</div>
            <div class="box-content" style="grid-template-columns: 1fr;">
                <div style="text-align: center; padding: 10px;">
                    <p style="margin: 0; font-size: 9pt; color: #666;">ACESSE O SISTEMA PELO ENDEREÇO:</p>
                    <div class="url-box">{{ $urlLogin }}</div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: left;">
                        <div class="field">
                            <label>USUÁRIO (LOGIN)</label>
                            <span style="font-size: 14pt;">{{ $user->email }}</span>
                        </div>
                        <div class="field">
                            <label>SENHA TEMPORÁRIA</label>
                            <div class="password-display">
                                {{ $senha }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nota de Segurança -->
        <div style="border: 1px solid #000; padding: 15px; margin-bottom: 30px; background-color: #fce7f3;">
            <strong style="text-transform: uppercase; font-size: 9pt;">⚠ Importante:</strong>
            <p style="font-size: 9pt; margin: 5px 0 0;">
                Esta senha é temporária e deve ser alterada no primeiro acesso. Mantenha estas credenciais em total sigilo.
                O uso destas credenciais é pessoal e intransferível, sendo o colaborador responsável por todas as ações realizadas no sistema com este usuário.
            </p>
        </div>

        <!-- Rodapé com QR Code -->
        <div class="footer-section">
            <div class="qr-area">
                <div id="qrcode-container">
                    <canvas id="qrcode"></canvas>
                </div>
            </div>
            <div class="instructions">
                <h3>INSTRUÇÕES DE ACESSO RÁPIDO</h3>
                <ul>
                    <li>Aponte a câmera do seu celular para o QR Code ao lado.</li>
                    <li>Você será direcionado automaticamente para a página de login.</li>
                    <li>Digite o usuário e a senha exibidos acima.</li>
                    <li>Em caso de dúvidas ou problemas de acesso, contate o departamento de TI ou seu supervisor imediato.</li>
                </ul>
            </div>
        </div>

        <!-- Assinatura -->
        <div class="signature-line">
            {{ strtoupper($funcionario->nome) }}<br>
            CONFIRMO O RECEBIMENTO DAS CREDENCIAIS
        </div>

        <div style="position: absolute; bottom: var(--margin); left: var(--margin); right: var(--margin); font-size: 8pt; text-align: center; color: #999;">
            Desenvolvido por VERTEX SEMAGRI - Sistema de Gestão Inteligente
        </div>

    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlLogin = '{{ $urlLogin }}';
            const canvas = document.getElementById('qrcode');

            // Aguarda o carregamento do script do Vite
            const checkLibrary = setInterval(function() {
                if (window.generateQRCode) {
                    clearInterval(checkLibrary);
                    window.generateQRCode(urlLogin, canvas, {
                        width: 110,
                        margin: 0,
                        color: {
                            dark: '#000000',
                            light: '#ffffff'
                        }
                    }).catch(error => console.error(error));
                }
            }, 100);

            // Timeout de segurança
            setTimeout(() => {
                if (!window.generateQRCode) {
                    clearInterval(checkLibrary);
                    console.warn('Biblioteca QRCode não carregada.');
                    document.getElementById('qrcode-container').innerHTML = '<span style="font-size:8pt">QR Code Indisponível</span>';
                }
            }, 5000);
        });
    </script>
</body>
</html>
