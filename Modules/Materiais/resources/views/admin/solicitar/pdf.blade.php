<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofício nº {{ $numero_oficio ?? '...' }} - Solicitação de Materiais</title>
    <style>
        @page {
            margin: 1.5cm;
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
            line-height: 1.6;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        /* Branding Header */
        .branding {
            text-align: center;
            border-bottom: 2px solid #10b981;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .branding h1 {
            color: #0d9488;
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .branding p {
            font-size: 9pt;
            color: #64748b;
            margin: 5px 0 0;
            font-weight: bold;
        }

        /* Official Document Header */
        .doc-header {
            margin-bottom: 40px;
        }

        .numero-oficio {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 20px;
        }

        .identificacao {
            margin-bottom: 25px;
        }

        .label {
            font-weight: bold;
            color: #475569;
            width: 100px;
            display: inline-block;
        }

        /* Content */
        .content {
            text-align: justify;
            margin-bottom: 40px;
        }

        .vocativo {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .texto {
            text-indent: 1.5cm;
            margin-bottom: 15px;
        }

        .justificativa-box {
            background-color: #f8fafc;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            font-style: italic;
            font-size: 10pt;
        }

        /* Signatures */
        .signature-section {
            margin-top: 60px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-line {
            border-top: 1px solid #94a3b8;
            padding-top: 8px;
            text-align: center;
            font-size: 10pt;
            width: 80%;
            margin: 0 auto;
        }

        .cargo {
            font-size: 8.5pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Table Style (Appendix) */
        .page-break {
            page-break-before: always;
        }

        .anexo-header {
            margin-bottom: 25px;
            text-align: center;
        }

        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            font-size: 9.5pt;
        }

        .items-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            text-align: left;
            padding: 12px 8px;
            border-bottom: 2px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 8pt;
        }

        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .items-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .item-nome {
            font-weight: bold;
            color: #0f172a;
        }

        .item-spec {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 3px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 7.5pt;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <!-- Official Branding -->
    <div class="branding">
        <h1>Prefeitura Municipal de Coração de Maria</h1>
        <p>Secretaria Municipal de Agricultura | Setor de Infraestrutura</p>
    </div>

    <!-- Official Document Header -->
    <div class="doc-header">
        <div class="numero-oficio">
            OFÍCIO Nº {{ $numero_oficio ?? '____' }}/{{ $ano ?? now()->year }} - SI/SA
        </div>

        <div class="identificacao">
            <div><span class="label">DATA:</span> {{ $data->format('d/m/Y') }}</div>
            <div><span class="label">PARA:</span> <strong>{{ $secretario_nome }}</strong></div>
            <div style="margin-left: 100px;" class="cargo">{{ $secretario_cargo }}</div>
            <div style="margin-top: 10px;">
                <span class="label">ASSUNTO:</span> <strong>Solicitação de Materiais e Insumos</strong>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content">
        <p class="vocativo">Senhor(a) Secretário(a),</p>

        <p class="texto">
            Vimos, por meio deste, solicitar a aquisição dos materiais e equipamentos listados no <strong>Anexo I</strong> deste documento. Esta demanda é essencial para assegurar a continuidade das operações do Setor de Infraestrutura desta Secretaria, visando o atendimento eficiente das demandas de campo e a manutenção preventiva de nossos ativos.
        </p>

        <p class="texto">
            A referida solicitação justifica-se pela necessidade de manter os níveis operacionais de estoque e atender a projetos específicos em andamento, como detalhado nas justificativas individuais de cada item.
        </p>

        <p class="texto">
            Certos de vossa compreensão e apoio constante às atividades de infraestrutura agrícola de nosso município, aguardamos as providências administrativas necessárias.
        </p>

        <p style="margin-top: 30px;">Respeitosamente,</p>
    </div>

    <!-- Signatures -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 50%;">
                    <div class="signature-line">
                        <strong>{{ $servidor_nome }}</strong><br>
                        <span class="cargo">{{ $servidor_cargo }}</span>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="signature-line">
                        <strong>{{ $secretario_nome }}</strong><br>
                        <span class="cargo">{{ $secretario_cargo }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Page Break for Appendix -->
    <div class="page-break"></div>

    <div class="anexo-header">
        <h2 style="font-size: 13pt; margin-bottom: 5px;">ANEXO I</h2>
        <p class="cargo" style="color: #94a3b8;">Relação Detalhada de Itens Solicitados</p>
        <p style="font-size: 8pt; color: #cbd5e1;">Ofício nº {{ $numero_oficio ?? '...' }}</p>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">Item</th>
                <th style="width: 45%;">Material / Identificação</th>
                <th style="width: 15%; text-align: center;">Qtd / Unid</th>
                <th style="width: 35%;">Justificativa Operacional</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiais as $index => $item)
                @if($item['is_customizado'] ?? false)
                    <tr>
                        <td style="text-align: center;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="item-nome">{{ $item['nome_customizado'] }}</div>
                            <div class="item-spec">{{ $item['especificacao_customizada'] ?? 'Material de uso geral' }}</div>
                        </td>
                        <td style="text-align: center;">
                            <strong>{{ formatar_quantidade($item['quantidade'], $item['unidade_medida_customizada'] ?? null) }}</strong><br>
                            <span class="cargo" style="font-size: 7pt;">{{ strtoupper($item['unidade_medida_customizada']) }}</span>
                        </td>
                        <td><div class="item-spec" style="color: #1e293b; font-style: italic;">{{ $item['justificativa'] }}</div></td>
                    </tr>
                @else
                    <tr>
                        <td style="text-align: center;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="item-nome">{{ $item['material']->nome }}</div>
                            <div class="item-spec">
                                {{ $item['material']->categoria_formatada ?? 'Insumos' }}
                                @if($item['material']->codigo) | Cód: {{ $item['material']->codigo }} @endif
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <strong>{{ formatar_quantidade($item['quantidade'], $item['material']->unidade_medida) }}</strong><br>
                            <span class="cargo" style="font-size: 7pt;">{{ strtoupper($item['material']->unidade_medida) }}</span>
                        </td>
                        <td><div class="item-spec" style="color: #1e293b; font-style: italic;">{{ $item['justificativa'] }}</div></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @if(!empty($observacoes))
        <div class="justificativa-box">
            <strong style="font-style: normal; color: #475569; text-transform: uppercase; font-size: 8pt;">Observações Adicionais:</strong><br>
            {{ $observacoes }}
        </div>
    @endif

    <div class="footer">
        Este documento é de uso interno da Secretaria Municipal de Agricultura. Gerado pelo Sistema VERTEXSEMAGRI em {{ now()->format('d/m/Y H:i') }}.
    </div>
</body>
</html>
