<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Manual de Demanda - VERTEX</title>
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
            padding: 10px;
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
            padding: 10px 25px;
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
            padding: 8px 25px;
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

        .required {
            color: #ef4444;
            margin-left: 2px;
        }

        .value-box {
            border-bottom: 1px solid #cbd5e1;
            min-height: 20px;
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            padding-bottom: 2px;
        }

        /* Checkbox Styling */
        .options-grid {
            padding: 15px 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
        }

        .option-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            font-weight: 600;
            color: #334155;
        }

        .checkbox {
            width: 14px;
            height: 14px;
            border: 2px solid #3b82f6;
            border-radius: 4px;
            background: white;
            flex-shrink: 0;
        }

        /* Multi-line Content */
        .content-area {
            padding: 15px 25px;
        }

        .textarea-box {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            min-height: 100px;
            padding: 10px;
            background: #fdfdfd;
        }

        /* Signature Section */
        .signature-section {
            display: table;
            width: 100%;
            background: #f8fafc;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            padding: 20px;
            border-right: 1px solid #e2e8f0;
            text-align: center;
        }

        .signature-box:last-child {
            border-right: none;
        }

        .signature-line {
            border-bottom: 1.5px solid #1e293b;
            margin: 15px auto 8px auto;
            width: 80%;
            height: 20px;
        }

        .signature-name {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            color: #1e293b;
        }

        .signature-desc {
            font-size: 8px;
            color: #64748b;
            margin-top: 4px;
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

        @media print {
            body { padding: 0; }
            .document-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>

    <div class="document-container">
        <!-- Header -->
        <div class="top-bar">
            <div class="system-brand">
                <img src="{{ public_path('images/logo-icon.svg') }}" alt="Logo" style="width: 35px; height: 35px;">
                <div>
                    <span class="brand-text">VERTEX</span>
                    <span class="brand-subtext">Secretaria Municipal de Agricultura</span>
                </div>
            </div>
            <div class="form-label">
                <h1>DEMANDA MANUAL</h1>
                <p>REGISTRO DE MANUTENÇÃO / SOLICITAÇÃO</p>
            </div>
        </div>

        <!-- 1. Identificação do Registro -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">1. Identificação do Registro</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 40%;">
                        <span class="label">Data de Abertura <span class="required">*</span></span>
                        <div class="value-box">____/____/________</div>
                    </div>
                    <div class="grid-item" style="width: 30%;">
                        <span class="label">Hora do Registro</span>
                        <div class="value-box">____:____</div>
                    </div>
                    <div class="grid-item" style="width: 30%;">
                        <span class="label">Código do Formulário</span>
                        <div class="value-box" style="font-family: monospace; color: #64748b; font-size: 9px;">
                            DM-{{ date('Ymd') }}-____
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Dados do Solicitante -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">2. Dados do Solicitante</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 65%;">
                        <span class="label">Nome Completo / Interessado <span class="required">*</span></span>
                        <div class="value-box"></div>
                    </div>
                    <div class="grid-item" style="width: 35%;">
                        <span class="label">CPF / CNPJ</span>
                        <div class="value-box"></div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Telefone / WhatsApp</span>
                        <div class="value-box">(__) _________-_________</div>
                    </div>
                    <div class="grid-item">
                        <span class="label">E-mail (Opcional)</span>
                        <div class="value-box"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Localização da Demanda -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">3. Localização da Demanda</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Localidade / Comunidade <span class="required">*</span></span>
                        <div class="value-box"></div>
                    </div>
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Ponto de Referência</span>
                        <div class="value-box"></div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Endereço Detalhado / Descritivo</span>
                        <div class="value-box" style="min-height: 40px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Classificação do Serviço -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">4. Classificação do Serviço</h2>
            </div>
            <div class="options-grid">
                <div class="option-item"><div class="checkbox"></div> Abastecimento (Pipa)</div>
                <div class="option-item"><div class="checkbox"></div> Recuperação de Estradas</div>
                <div class="option-item"><div class="checkbox"></div> Poços Artesianos</div>
                <div class="option-item"><div class="checkbox"></div> Iluminação Pública</div>
                <div class="option-item"><div class="checkbox"></div> Limpeza de Aguadas</div>
                <div class="option-item"><div class="checkbox"></div> Outros: __________________</div>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 100%;">
                        <span class="label">Tipo de Solicitação</span>
                        <div class="option-item" style="margin-top: 5px; gap: 20px;">
                            <div class="option-item"><div class="checkbox"></div> Nova Demanda</div>
                            <div class="option-item"><div class="checkbox"></div> Reclamação</div>
                            <div class="option-item"><div class="checkbox"></div> Manutenção</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Detalhamento e Observações -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">5. Detalhamento da Solicitação</h2>
            </div>
            <div class="content-area">
                <span class="label">Descrição Detalhada da Necessidade <span class="required">*</span></span>
                <div class="textarea-box"></div>
                <p style="font-size: 7px; color: #94a3b8; font-style: italic; margin-top: 8px;">
                    Obs: Utilize o verso da folha caso falte espaço para o detalhamento técnico ou desenhos de localização.
                </p>
            </div>
        </div>

        <!-- 6. Assinaturas e Responsabilidade -->
        <div class="signature-section">
            <div class="signature-box">
                <span class="label">Interessado / Solicitante</span>
                <div class="signature-line"></div>
                <span class="signature-name">Assinatura Manual</span>
                <p class="signature-desc">Declaro serem verídicas as informações</p>
            </div>
            <div class="signature-box">
                <span class="label">Servidor SEMAGRI (Recebimento)</span>
                <div class="signature-line"></div>
                <span class="signature-name">Carimbo e Assinatura</span>
                <p class="signature-desc">Responsável pela entrada no sistema</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p><strong>FORMULÁRIO OFICIAL DE REGISTRO MANUAL</strong></p>
                <p>Este documento deve ser digitalizado após o preenchimento.</p>
            </div>
            <div style="text-align: right; opacity: 0.5;">
                <p>Emissão: {{ date('d/m/Y H:i') }} | v2.0</p>
                <p>© {{ date('Y') }} VERTEX SEAMAGRI - Coração de Maria - BA</p>
            </div>
        </div>
    </div>

</body>
</html>
