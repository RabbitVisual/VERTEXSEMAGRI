<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofício nº {{ $numero_oficio ?? '...' }} - Solicitação de Materiais</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
            size: A4;
            @bottom-right {
                content: "Página " counter(page) " de " counter(pages);
                font-size: 8pt;
                color: #64748b;
            }
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }

        /* Institutional Header (Brazilian Standard) */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo-container {
            width: 80px;
            vertical-align: middle;
        }

        .logo-container img {
            max-width: 75px;
            height: auto;
        }

        .header-text {
            vertical-align: middle;
            padding-left: 20px;
            border-left: 1px solid #cbd5e1;
        }

        .municipio-nome {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            color: #000;
            text-transform: uppercase;
        }

        .secretaria-nome {
            font-size: 11pt;
            font-weight: bold;
            margin: 2px 0;
            color: #1e293b;
        }

        .setor-nome {
            font-size: 9pt;
            margin: 0;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Document Metadata */
        .doc-meta {
            margin-bottom: 40px;
        }

        .numero-oficio {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: left;
        }

        .local-data {
            text-align: right;
            margin-bottom: 30px;
            font-style: italic;
        }

        /* Professional Recipient */
        .destinatario {
            margin-bottom: 40px;
        }

        .destinatario p {
            margin: 0;
            font-weight: bold;
        }

        .destinatario .cargo-label {
            font-weight: normal;
            font-size: 10pt;
            color: #475569;
            text-transform: uppercase;
        }

        /* Formal Content */
        .content {
            text-align: justify;
            margin-bottom: 40px;
        }

        .texto {
            text-indent: 2cm;
            margin-bottom: 20px;
        }

        .assunto {
            margin-bottom: 30px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Signatures */
        .signature-section {
            margin-top: 80px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
        }

        .signature-box {
            width: 50%;
            text-align: center;
        }

        .sig-line {
            width: 80%;
            margin: 0 auto 5px;
            border-top: 1px solid #000;
        }

        .sig-name {
            font-weight: bold;
            font-size: 10pt;
        }

        .sig-cargo {
            font-size: 8.5pt;
            color: #475569;
            text-transform: uppercase;
        }

        /* Table (Anexo) */
        .page-break {
            page-break-before: always;
        }

        .anexo-title {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 20px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        .items-table th {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px 5px;
            text-transform: uppercase;
            font-size: 8pt;
        }

        .items-table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: top;
        }

        .item-justificativa {
            font-style: italic;
            font-size: 8.5pt;
            color: #475569;
        }

        .observacoes-box {
            margin-top: 30px;
            padding: 15px;
            background: #f1f5f9;
            border-left: 5px solid #64748b;
            font-size: 9pt;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7.5pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Professional Institutional Header -->
    <table class="header-table">
        <tr>
            <td class="logo-container">
                @php
                    $logoPath = storage_path('app/public/img_ofc/logo agricultura.png');
                    $logoData = '';
                    if (file_exists($logoPath)) {
                        $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                    }
                @endphp
                @if($logoData)
                    <img src="{{ $logoData }}" alt="Logo">
                @endif
            </td>
            <td class="header-text">
                <h1 class="municipio-nome">Prefeitura Municipal de Coração de Maria</h1>
                <p class="secretaria-nome">Secretaria Municipal de Agricultura</p>
                <p class="setor-nome">Departamento de Infraestrutura e Logística</p>
            </td>
        </tr>
    </table>

    <div class="doc-meta">
        <div class="local-data">
            {{ $cidade }}, {{ $data->isoFormat('LL') }}
        </div>

        <div class="numero-oficio">
            OFÍCIO Nº {{ $numero_oficio ?? '____' }}/{{ $ano ?? now()->year }} - SEMAGRI/INFRA
        </div>

        <div class="assunto">
            ASSUNTO: Solicitação de Materiais e Insumos Operacionais.
        </div>
    </div>

    <div class="destinatario">
        <p>A SUA SENHORIA,</p>
        <p>{{ strtoupper($secretario_nome) }}</p>
        <p class="cargo-label">{{ $secretario_cargo }}</p>
        <p>Nesta.</p>
    </div>

    <div class="content">
        <p style="font-weight: bold; margin-bottom: 20px;">Senhor(a) Secretário(a),</p>

        <p class="texto">
            Cumprimentando-o(a) cordialmente, servimo-nos do presente para solicitar a Vossa Senhoria a aquisição e fornecimento dos materiais e insumos discriminados no <strong>Anexo I</strong>, parte integrante deste ofício.
        </p>

        <p class="texto">
            A referida solicitação faz-se necessária para a manutenção do cronograma de atividades programadas pelo Departamento de Infraestrutura, garantindo a eficiência operacional e o atendimento às demandas emergenciais e preventivas do setor agropecuário e de manutenção municipal.
        </p>

        <p class="texto">
            Ressaltamos que os itens solicitados foram criteriosamente selecionados para atender às especificações técnicas exigidas, visando o melhor custo-benefício e a durabilidade necessária para as operações de campo.
        </p>

        <p class="texto">
            Certos de podermos contar com vossa costumeira atenção e presteza no atendimento desta demanda, aproveitamos o ensejo para manifestar nossos protestos de elevada estima e consideração.
        </p>

        <p style="margin-top: 40px;">Atenciosamente,</p>
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="signature-box">
                    <div class="sig-line"></div>
                    <span class="sig-name">{{ $servidor_nome }}</span><br>
                    <span class="sig-cargo">{{ $servidor_cargo }}</span>
                </td>
                <td class="signature-box">
                    <div class="sig-line"></div>
                    <span class="sig-name">{{ $secretario_nome }}</span><br>
                    <span class="sig-cargo">{{ $secretario_cargo }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Appendix I (Items Table) -->
    <div class="page-break"></div>

    <div class="anexo-title">
        ANEXO I - ESPECIFICAÇÃO DOS MATERIAIS
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 8%;">Item</th>
                <th style="width: 50%;">Descrição do Material / Especificação</th>
                <th style="width: 12%; text-align: center;">Qtd.</th>
                <th style="width: 10%; text-align: center;">Unid.</th>
                <th style="width: 20%;">Justificativa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiais as $index => $item)
                @if($item['is_customizado'] ?? false)
                    <tr>
                        <td style="text-align: center;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <strong>{{ $item['nome_customizado'] }}</strong><br>
                            <span style="font-size: 8pt; color: #64748b;">{{ $item['especificacao_customizada'] ?? 'Não especificado' }}</span>
                        </td>
                        <td style="text-align: center;">{{ formatar_quantidade($item['quantidade'], $item['unidade_medida_customizada'] ?? null) }}</td>
                        <td style="text-align: center;">{{ strtoupper($item['unidade_medida_customizada']) }}</td>
                        <td class="item-justificativa">{{ $item['justificativa'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td style="text-align: center;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <strong>{{ $item['material']->nome }}</strong><br>
                            <span style="font-size: 8pt; color: #64748b;">{{ $item['material']->categoria_formatada ?? 'Insumos' }} @if($item['material']->codigo) - Ref: {{ $item['material']->codigo }} @endif</span>
                        </td>
                        <td style="text-align: center;">{{ formatar_quantidade($item['quantidade'], $item['material']->unidade_medida ?? null) }}</td>
                        <td style="text-align: center;">{{ strtoupper($item['material']->unidade_medida) }}</td>
                        <td class="item-justificativa">{{ $item['justificativa'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @if(!empty($observacoes))
        <div class="observacoes-box">
            <strong>OBSERVAÇÕES ADICIONAIS:</strong><br>
            {{ $observacoes }}
        </div>
    @endif

    <div class="footer">
        Documento gerado eletronicamente em {{ now()->format('d/m/Y H:i') }} | VERTEXSEMAGRI Admin
    </div>
</body>
</html>
