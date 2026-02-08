<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual de Ordem de Serviço - VERTEX</title>
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
            min-height: 60px;
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
                <h1>ORDEM DE SERVIÇO</h1>
                <p>REGISTRO TÉCNICO DE EXECUÇÃO EM CAMPO</p>
            </div>
        </div>

        <!-- 1. Identificação da O.S -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">1. Identificação da O.S</h2>
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
                        <span class="label">Número da O.S</span>
                        <div class="value-box" style="font-family: monospace; color: #64748b; font-size: 9px;">
                            OS-{{ date('Ymd') }}-____
                        </div>
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
                        <span class="label">Equipe Executora <span class="required">*</span></span>
                        <div class="value-box"></div>
                    </div>
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Responsável Técnico</span>
                        <div class="value-box"></div>
                    </div>
                </div>
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Acompanhante / Auxiliar 1</span>
                        <div class="value-box"></div>
                    </div>
                    <div class="grid-item">
                        <span class="label">Acompanhante / Auxiliar 2</span>
                        <div class="value-box"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Descrição do Trabalho Requisitado -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">3. Descrição do Serviço Requisitado</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item">
                        <span class="label">Tipo de Serviço / Natureza da Operação <span class="required">*</span></span>
                        <div class="value-box"></div>
                    </div>
                </div>
            </div>
            <div class="content-area" style="padding-top: 5px;">
                <span class="label">Detalhes da Ordem de Serviço</span>
                <div class="textarea-box" style="min-height: 60px;"></div>
            </div>
        </div>

        <!-- 4. Status e Controle de Execução -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">4. Status e Cronograma</h2>
            </div>
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Status Inicial</span>
                        <div class="options-grid" style="padding: 5px 0 0 0;">
                            <div class="option-item"><div class="checkbox"></div> Pendente</div>
                            <div class="option-item"><div class="checkbox"></div> Em Execução</div>
                            <div class="option-item"><div class="checkbox"></div> Concluída</div>
                        </div>
                    </div>
                    <div class="grid-item" style="width: 50%;">
                        <span class="label">Datas de Controle</span>
                        <div class="value-box" style="font-size: 8px; border: none;">
                            Início: ____/____/____ às ____:____<br>
                            Fim: ____/____/____ às ____:____
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Relatório Técnico de Campo -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">5. Relatório Técnico de Execução</h2>
            </div>
            <div class="content-area">
                <span class="label">Ocorrências / Materiais Utilizados / Observações Finais</span>
                <div class="textarea-box" style="min-height: 80px;"></div>
                <p style="font-size: 7px; color: #94a3b8; font-style: italic; margin-top: 8px;">
                    Obs: Utilize o anexo de materiais para detalhamento de peças, combustível e horas-máquina.
                </p>
            </div>
        </div>

        <!-- 6. Validação e Encerramento -->
        <div class="signature-section">
            <div class="signature-box">
                <span class="label">Responsável pela Abertura</span>
                <div class="signature-line"></div>
                <span class="signature-name">Emitente</span>
                <p class="signature-desc">SEMAGRI - Gestão Administrativa</p>
            </div>
            <div class="signature-box">
                <span class="label">Responsável pela Execução</span>
                <div class="signature-line"></div>
                <span class="signature-name">Técnico em Campo</span>
                <p class="signature-desc">Confirmação de execução do serviço</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p><strong>FORMULÁRIO OFICIAL DE ORDEM DE SERVIÇO</strong></p>
                <p>Obrigatório o preenchimento de todos os campos marcados com *.</p>
            </div>
            <div style="text-align: right; opacity: 0.5;">
                <p>Emissão: {{ date('d/m/Y H:i') }} | v2.0</p>
                <p>© {{ date('Y') }} VERTEX SEAMAGRI - Coração de Maria - BA</p>
            </div>
        </div>
    </div>

</body>
</html>
