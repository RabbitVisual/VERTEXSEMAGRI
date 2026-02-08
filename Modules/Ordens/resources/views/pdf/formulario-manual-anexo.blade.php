<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anexo - Materiais e Recursos - VERTEX</title>
    <style>
        @page {
            margin: 10mm;
            size: A4 landscape;
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
            padding: 12px 25px;
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
            letter-spacing: 1px;
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
            padding: 6px 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 9px;
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Table Styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f1f5f9;
            color: #64748b;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            text-align: left;
            padding: 8px 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 10px;
            color: #0f172a;
            font-weight: 600;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .col-id { width: 40px; text-align: center; color: #94a3b8 !important; }
        .col-desc { width: 350px; }
        .col-qty { width: 80px; text-align: center; }
        .col-unit { width: 60px; text-align: center; }

        /* Label and Value */
        .label {
            font-size: 8px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 2px;
            display: block;
        }

        .value-box {
            border-bottom: 1px solid #cbd5e1;
            min-height: 18px;
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
        }

        /* Footer */
        .footer {
            padding: 10px 25px;
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
                <img src="{{ public_path('images/logo-icon.svg') }}" alt="Logo" style="width: 25px; height: 25px;">
                <div>
                    <span class="brand-text">VERTEX</span>
                    <span class="brand-subtext">Secretaria Municipal de Agricultura</span>
                </div>
            </div>
            <div class="form-label">
                <h1>ANEXO TÉCNICO</h1>
                <p>RECURSOS, MATERIAIS E HORAS-MÁQUINA</p>
            </div>
        </div>

        <!-- 1. Informações de Referência -->
        <div class="section">
            <div style="display: table; width: 100%;">
                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 10px 25px; border-right: 1px solid #e2e8f0; width: 33%;">
                        <span class="label">Vínculo O.S / Demanda</span>
                        <div class="value-box">__________________________</div>
                    </div>
                    <div style="display: table-cell; padding: 10px 25px; border-right: 1px solid #e2e8f0; width: 33%;">
                        <span class="label">Operador / Técnico Responsável</span>
                        <div class="value-box">__________________________</div>
                    </div>
                    <div style="display: table-cell; padding: 10px 25px; width: 34%;">
                        <span class="label">Local / Comunidade</span>
                        <div class="value-box">__________________________</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Tabela de Materiais -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Detalhamento de Materiais e Peças Utilizadas</h2>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-id">#</th>
                        <th class="col-desc">Descrição do Material / Peça</th>
                        <th class="col-qty">Quantidade</th>
                        <th class="col-unit">Unidade</th>
                        <th>Observações Técnicas</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 10; $i++)
                    <tr>
                        <td class="col-id">{{ $i }}</td>
                        <td class="col-desc">__________________________________________</td>
                        <td class="col-qty">________</td>
                        <td class="col-unit">________</td>
                        <td>__________________________________</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- 3. Recursos de Maquinário (Se houver) -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Controle de Maquinário e Combustível</h2>
            </div>
            <div style="display: table; width: 100%;">
                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 10px 25px; border-right: 1px solid #e2e8f0;">
                        <span class="label">Equipamento / Veículo</span>
                        <div class="value-box">__________________________</div>
                    </div>
                    <div style="display: table-cell; padding: 10px 25px; border-right: 1px solid #e2e8f0;">
                        <span class="label">Horímetro / KM Inicial</span>
                        <div class="value-box">__________________________</div>
                    </div>
                    <div style="display: table-cell; padding: 10px 25px; border-right: 1px solid #e2e8f0;">
                        <span class="label">Horímetro / KM Final</span>
                        <div class="value-box">__________________________</div>
                    </div>
                    <div style="display: table-cell; padding: 10px 25px;">
                        <span class="label">Abastecimento (Litros)</span>
                        <div class="value-box">__________________________</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                <p><strong>ESTE DOCUMENTO É INTEGRANTE DA ORDEM DE SERVIÇO</strong></p>
                <p>Deve ser anexado ao formulário principal para fins de auditoria e controle de estoque.</p>
            </div>
            <div style="text-align: right; opacity: 0.5;">
                <p>Emissão: {{ date('d/m/Y H:i') }} | v2.0</p>
                <p>© {{ date('Y') }} VERTEX SEAMAGRI - Coração de Maria - BA</p>
            </div>
        </div>
    </div>

</body>
</html>
