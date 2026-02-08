<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Atualização na Demanda - {{ $demanda->codigo ?? 'N/A' }}</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
    <style>
        /* Reset e Base */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background-color: #f3f4f6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        /* Container Principal */
        .email-wrapper {
            background-color: #f3f4f6;
            padding: 20px 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Header com Logo */
        .email-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 50%, #198754 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 300px;
            height: auto;
        }
        .header-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px 0;
            letter-spacing: 0.5px;
        }
        .header-subtitle {
            color: #d1fae5;
            font-size: 14px;
            margin: 0;
            font-weight: 400;
        }

        /* Body */
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 24px;
            font-weight: 500;
        }
        .greeting strong {
            color: #047857;
            font-weight: 600;
        }

        .intro-text {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        /* Status Box */
        .status-box {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 2px solid #059669;
            border-radius: 12px;
            padding: 30px 25px;
            margin: 30px 0;
            text-align: center;
        }
        .status-label {
            font-size: 12px;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            margin-bottom: 12px;
            display: block;
        }
        .status-badge {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 15px 0;
        }
        .status-aberta {
            background: #3b82f6;
            color: #ffffff;
        }
        .status-em_andamento {
            background: #f59e0b;
            color: #ffffff;
        }
        .status-concluida {
            background: #10b981;
            color: #ffffff;
        }
        .status-cancelada {
            background: #ef4444;
            color: #ffffff;
        }

        /* Info Section */
        .info-section {
            background: #f8fafc;
            border-left: 4px solid #059669;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
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
            flex: 0 0 40%;
        }
        .info-value {
            color: #1e293b;
            font-size: 14px;
            text-align: right;
            flex: 1;
            word-break: break-word;
        }
        .status-change-info {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            line-height: 1.7;
        }

        /* Button */
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(5, 150, 105, 0.3);
            transition: all 0.3s ease;
        }
        .button:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            box-shadow: 0 6px 12px rgba(5, 150, 105, 0.4);
        }

        .link-text {
            font-size: 13px;
            color: #64748b;
            margin-top: 20px;
            text-align: center;
            line-height: 1.6;
        }
        .link-text a {
            color: #059669;
            word-break: break-all;
            text-decoration: none;
        }

        /* Footer */
        .email-footer {
            background: #f8fafc;
            padding: 35px 30px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .footer-brand {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .footer-subtitle {
            font-size: 13px;
            color: #475569;
            margin-bottom: 20px;
        }
        .footer-contact {
            margin: 20px 0;
            padding: 20px 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .footer-contact p {
            margin: 8px 0;
            color: #475569;
            font-size: 13px;
        }
        .footer-contact a {
            color: #059669;
            text-decoration: none;
        }
        .footer-links {
            margin: 20px 0;
        }
        .footer-links a {
            color: #059669;
            text-decoration: none;
            margin: 0 8px;
            font-size: 13px;
        }
        .footer-disclaimer {
            margin-top: 20px;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer-copyright {
            margin-top: 15px;
            font-size: 10px;
            color: #cbd5e1;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                border-radius: 0 !important;
            }
            .email-header,
            .email-body,
            .email-footer {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            .button {
                padding: 14px 30px !important;
                font-size: 15px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header com Logo -->
            <div class="email-header">
                <div class="logo-container">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDUwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDQ1MCAxMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+DQogIDxkZWZzPg0KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0ibWFpbkdyZWVuR3JhZCIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+DQogICAgICA8c3RvcCBvZmZzZXQ9IjAlIiBzdHlsZT0ic3RvcC1jb2xvcjojMjhhNzQ1O3N0b3Atb3BhY2l0eToxIiAvPg0KICAgICAgPHN0b3Agb2Zmc2V0PSI1MCUiIHN0eWxlPSJzdG9wLWNvbG9yOiMyMGM5OTc7c3RvcC1vcGFjaXR5OjEiIC8+DQogICAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiMxOTg3NTQ7c3RvcC1vcGFjaXR5OjEiIC8+DQogICAgPC9saW5lYXJHcmFkaWVudD4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImFjY2VudEdvbGRHcmFkIiB4MT0iMCUiIHkxPSIwJSIgeDI9IjEwMCUiIHkyPSIxMDAlIj4NCiAgICAgIDxzdG9wIG9mZnNldD0iMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiNmZmMxMDc7c3RvcC1vcGFjaXR5OjEiIC8+DQogICAgICA8c3RvcCBvZmZzZXQ9IjUwJSIgc3R5bGU9InN0b3AtY29sb3I6I2ZmYjMwMDtzdG9wLW9wYWNpdHk6MSIgLz4NCiAgICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3R5bGU9InN0b3AtY29sb3I6I2ZmOTgwMDtzdG9wLW9wYWNpdHk6MSIgLz4NCiAgICA8L2xpbmVhckdyYWRpZW50Pg0KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0idGV4dEdyYWQiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMTAwJSIgeTI9IjAlIj4NCiAgICAgIDxzdG9wIG9mZnNldD0iMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiNmZmMxMDc7c3RvcC1vcGFjaXR5OjEiIC8+DQogICAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiNmZjk4MDA7c3RvcC1vcGFjaXR5OjEiIC8+DQogICAgPC9saW5lYXJHcmFkaWVudD4NCiAgICA8ZmlsdGVyIGlkPSJsb2dvU2hhZG93Ij4NCiAgICAgIDxmZURyb3BTaGFkb3cgZHg9IjAiIGR5PSIzIiBzdGREZXZpYXRpb249IjQiIGZsb29kLW9wYWNpdHk9IjAuMjUiLz4NCiAgICA8L2ZpbHRlcj4NCiAgICA8ZmlsdGVyIGlkPSJ0ZXh0U2hhZG93Ij4NCiAgICAgIDxmZURyb3BTaGFkb3cgZHg9IjAiIGR5PSIyIiBzdGREZXZpYXRpb249IjMiIGZsb29kLW9wYWNpdHk9IjAuMiIvPg0KICAgIDwvZmlsdGVyPg0KICA8L2RlZnM+DQogIA0KICA8IS0tIMONY29uZSBwcmluY2lwYWwgLSBGb2xoYSBjb20gdsOpcnRpY2VzIC0tPg0KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyMCwgMjApIiBmaWx0ZXI9InVybCgjbG9nb1NoYWRvdykiPg0KICAgIDwhLS0gQ8OtcmN1bG8gZGUgZnVuZG8gLS0+DQogICAgPGNpcmNsZSBjeD0iNDAiIGN5PSI0MCIgcj0iMzgiIGZpbGw9InVybCgjbWFpbkdyZWVuR3JhZCkiLz4NCiAgICANCiAgICA8IS0tIEZvbGhhIGVzdGlsaXphZGEgLS0+DQogICAgPHBhdGggZD0iTTQwIDE1IFEzMCAxNSwgMjUgMjUgUTIwIDMyLCAyMCA0MCBRMjAgNDgsIDI1IDU1IFEzMCA2NSwgNDAgNjUgUTUwIDY1LCA1NSA1NSBRNjAgNDgsIDYwIDQwIFE2MCAzMiwgNTUgMjUgUTUwIDE1LCA0MCAxNSBaIiANCiAgICAgICAgICBmaWxsPSIjZmZmZmZmIiANCiAgICAgICAgICBvcGFjaXR5PSIwLjE1Ii8+DQogICAgDQogICAgPCEtLSBMaW5oYSBjZW50cmFsIC0tPg0KICAgIDxwYXRoIGQ9Ik00MCAyMCBMNDAgNjAiIHN0cm9rZT0iI2ZmZmZmZiIgc3Ryb2tlLXdpZHRoPSIyLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgb3BhY2l0eT0iMC4zIi8+DQogICAgDQogICAgPCEtLSBWw6lydGljZXMgZG91cmFkYXMgLS0+DQogICAgPGNpcmNsZSBjeD0iNDAiIGN5PSIzMiIgcj0iNCIgZmlsbD0idXJsKCNhY2NlbnRHb2xkR3JhZCkiLz4NCiAgICA8Y2lyY2xlIGN4PSIzMyIgY3k9IjQyIiByPSIzIiBmaWxsPSJ1cmwoI2FjY2VudEdvbGRHcmFkKSIvPg0KICAgIDxjaXJjbGUgY3g9IjQ3IiBjeT0iNDIiIHI9IjMiIGZpbGw9InVybCgjYWNjZW50R29sZEdyYWQpIi8+DQogICAgPGNpcmNsZSBjeD0iNDAiIGN5PSI1MCIgcj0iMi41IiBmaWxsPSJ1cmwoI2FjY2VudEdvbGRHcmFkKSIvPg0KICAgIA0KICAgIDwhLS0gQnJpbGhvIC0tPg0KICAgIDxjaXJjbGUgY3g9IjQwIiBjeT0iNDAiIHI9IjUiIGZpbGw9IiNmZmZmZmYiIG9wYWNpdHk9IjAuNCIvPg0KICA8L2c+DQogIA0KICA8IS0tIFRleHRvIFZFUlRFWCAtLT4NCiAgPHRleHQgeD0iMTMwIiB5PSI1MiIgZm9udC1mYW1pbHk9IidTZWdvZSBVSScsICdBcmlhbCcsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMzgiIGZvbnQtd2VpZ2h0PSJib2xkIiANCiAgICAgICAgZmlsbD0idXJsKCN0ZXh0R3JhZCkiIGZpbHRlcj0idXJsKCN0ZXh0U2hhZG93KSIgbGV0dGVyLXNwYWNpbmc9IjIiPlZFUlRFWDwvdGV4dD4NCiAgDQogIDwhLS0gVGV4dG8gU0VNQUdSSSAtLT4NCiAgPHRleHQgeD0iMTMwIiB5PSI3OCIgZm9udC1mYW1pbHk9IidTZWdvZSBVSScsICdBcmlhbCcsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMjgiIGZvbnQtd2VpZ2h0PSI2MDAiIA0KICAgICAgICBmaWxsPSJ1cmwoI21haW5HcmVlbkdyYWQpIiBmaWx0ZXI9InVybCgjdGV4dFNoYWRvdykiIGxldHRlci1zcGFjaW5nPSIxIj5TRU1BR1JJPC90ZXh0Pg0KICANCiAgPCEtLSBMaW5oYSBkZWNvcmF0aXZhIC0tPg0KICA8bGluZSB4MT0iMTMwIiB5MT0iODgiIHgyPSI0MjAiIHkyPSI4OCIgc3Ryb2tlPSJ1cmwoI2FjY2VudEdvbGRHcmFkKSIgc3Ryb2tlLXdpZHRoPSIzLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgb3BhY2l0eT0iMC44Ii8+DQogIA0KICA8IS0tIFN1YnTDrXR1bG8gLS0+DQogIDx0ZXh0IHg9IjEzMCIgeT0iMTA1IiBmb250LWZhbWlseT0iJ1NlZ29lIFVJJywgJ0FyaWFsJywgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxMyIgZmlsbD0iIzY2NiIgbGV0dGVyLXNwYWNpbmc9IjAuNSI+DQogICAgU2lzdGVtYSBNdW5pY2lwYWwgZGUgQWdyaWN1bHR1cmEgZSBJbmZyYWVzdHJ1dHVyYQ0KICA8L3RleHQ+DQo8L3N2Zz4=" alt="VERTEX SEMAGRI" />
                </div>
                <h1 class="header-title">Atualização na Demanda</h1>
                <p class="header-subtitle">Secretaria Municipal de Agricultura</p>
            </div>

            <!-- Body -->
            <div class="email-body">
                <div class="greeting">
                    Olá <strong>{{ $demanda->solicitante_nome }}@if($demanda->solicitante_apelido) ({{ $demanda->solicitante_apelido }})@endif</strong>,
                </div>

                <p class="intro-text">
                    Informamos que sua demanda foi atualizada. Confira abaixo as informações atualizadas:
                </p>

                <!-- Status Box -->
                <div class="status-box">
                    <span class="status-label">Status Atual</span>
                    <span class="status-badge status-{{ $newStatus }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                @if($oldStatus && $oldStatus !== $newStatus)
                <div class="status-change-info">
                    <strong>Alteração de Status:</strong><br>
                    O status foi alterado de <strong>{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</strong> para <strong>{{ $statusLabel }}</strong>.
                </div>
                @endif

                <!-- Informações da Demanda -->
                <div class="info-section">
                    <div class="info-row">
                        <span class="info-label">Código/Protocolo:</span>
                        <span class="info-value">{{ $demanda->codigo ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Motivo:</span>
                        <span class="info-value">{{ $demanda->motivo }}</span>
                    </div>
                    @if($demanda->localidade)
                    <div class="info-row">
                        <span class="info-label">Localidade:</span>
                        <span class="info-value">{{ $demanda->localidade->nome }}</span>
                    </div>
                    @endif
                </div>

                @if($demanda->observacoes)
                <div class="info-section">
                    <div class="info-label" style="margin-bottom: 12px;">Observações:</div>
                    <div style="color: #1e293b; font-size: 14px; line-height: 1.7; white-space: pre-wrap;">{{ $demanda->observacoes }}</div>
                </div>
                @endif

                <p class="intro-text">
                    Você pode acompanhar o status da sua demanda em tempo real através do link abaixo:
                </p>

                <!-- Botão de Ação -->
                <div class="button-container">
                    <a href="{{ $consultaUrl }}" class="button">Acompanhar Minha Demanda</a>
                </div>

                <p class="link-text">
                    Ou copie e cole este link no seu navegador:<br>
                    <a href="{{ $consultaUrl }}">{{ $consultaUrl }}</a>
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <div class="footer-brand">SEMAGRI</div>
                <div class="footer-subtitle">Secretaria Municipal de Agricultura</div>
                <div class="footer-subtitle">Prefeitura Municipal de Coração de Maria - Bahia</div>

                <div class="footer-contact">
                    <p><strong>Contato:</strong></p>
                    <p>Telefone: <a href="tel:7532482489">(75) 3248-2489</a></p>
                    <p>E-mail: <a href="mailto:gabinete@coracaodemaria.ba.gov.br">gabinete@coracaodemaria.ba.gov.br</a></p>
                    <p>Endereço: Praça Dr. Araújo Pinho, Centro - CEP 44250-000</p>
                </div>

                <div class="footer-links">
                    <a href="{{ config('app.url', 'https://semagricm.com') }}">Página Inicial</a> |
                    <a href="{{ config('app.url', 'https://semagricm.com') }}/consulta-demanda">Consultar Demanda</a>
                </div>

                <div class="footer-disclaimer">
                    Este é um e-mail automático enviado pelo sistema SEMAGRI.<br>
                    Por favor, não responda a esta mensagem. Para contato, utilize o telefone ou e-mail acima.
                </div>

                <div class="footer-copyright">
                    © {{ date('Y') }} Prefeitura Municipal de Coração de Maria - BA. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
