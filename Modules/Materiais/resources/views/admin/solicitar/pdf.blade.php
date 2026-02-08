<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de Materiais</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header .numero-oficio {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-block {
            margin-bottom: 12px;
        }

        .info-line {
            margin-bottom: 4px;
            font-size: 11pt;
        }

        .info-label {
            font-weight: bold;
        }

        .content {
            text-align: justify;
            margin-bottom: 12px;
        }

        .content p {
            margin-bottom: 8px;
            text-indent: 1cm;
            font-size: 11pt;
        }

        .content .no-indent {
            text-indent: 0;
        }

        .content h3 {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 6px;
            text-indent: 0;
        }

        .content ol, .content ul {
            margin-left: 1cm;
            margin-bottom: 8px;
            padding-left: 1.5cm;
        }

        .content li {
            margin-bottom: 4px;
            font-size: 10.5pt;
        }

        .signature-block {
            margin-top: 20px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 400px;
            margin: 30px auto 5px;
            padding-top: 5px;
            font-size: 10.5pt;
        }

        .table-container {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9pt;
        }

        table thead {
            background-color: #f0f0f0;
        }

        table th {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-weight: bold;
            font-size: 9pt;
        }

        table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-size: 9pt;
        }

        table td:first-child {
            text-align: center;
            width: 35px;
        }

        table td:nth-child(4),
        table td:nth-child(5) {
            text-align: center;
            width: 60px;
        }

        table td:nth-child(6) {
            font-size: 8.5pt;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            margin-top: 15px;
            font-size: 8pt;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>OFÍCIO DE SOLICITAÇÃO DE MATERIAIS</h1>
        @if($numero_oficio)
            <div class="numero-oficio">N.º {{ $numero_oficio }}/{{ $ano }} - SI/SA</div>
        @else
            <div class="numero-oficio">SI/SA</div>
        @endif
    </div>

    <!-- Informações do Ofício -->
    <div class="info-block">
        <div class="info-line">
            <span class="info-label">Local e Data:</span> {{ $cidade }}, {{ $data->format('d') }} de {{ $data->translatedFormat('F') }} de {{ $data->format('Y') }}.
        </div>
        <div class="info-line">
            <span class="info-label">Para:</span> À Sua Excelência, o(a) Senhor(a)
        </div>
        <div class="info-line" style="margin-left: 20px;">
            <strong>{{ $secretario_nome }}</strong>
        </div>
        <div class="info-line" style="margin-left: 20px;">
            {{ $secretario_cargo }}
        </div>
        <div class="info-line">
            <span class="info-label">Assunto:</span> Solicitação de materiais e equipamentos para o Setor de Infraestrutura - Secretaria de Agricultura.
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <p class="no-indent"><strong>Prezado(a) Senhor(a) Secretário(a),</strong></p>

        <p>O <strong>Setor de Infraestrutura (SI)</strong>, vinculado à <strong>Secretaria Municipal de Agricultura (SA)</strong>, vem solicitar a aquisição e/ou reposição dos materiais e equipamentos listados abaixo, necessários para a manutenção e operação dos serviços essenciais deste Setor.</p>

        <p><strong>Justificativa:</strong> A solicitação fundamenta-se na necessidade de: (1) Repor itens abaixo do nível mínimo de segurança; (2) Substituir materiais danificados ou com vida útil esgotada; (3) Garantir conformidade com Normas Regulamentadoras (NRs) através da aquisição de EPIs.</p>

        <p>Os itens solicitados destinam-se exclusivamente à utilização em projetos de infraestrutura agrícola, em observância aos princípios da Administração Pública.</p>

        <p>Solicitamos o encaminhamento desta demanda ao setor competente para <strong>autorização, empenho e providências financeiras</strong> cabíveis.</p>

        <p class="no-indent">Atenciosamente,</p>
    </div>

    <!-- Assinatura -->
    <div class="signature-block">
        <div class="signature-line">
            {{ $servidor_nome }}<br>
            {{ $servidor_cargo }}<br>
            Secretaria Municipal de Agricultura
            @if($servidor_telefone || $servidor_email)
                <br>
                @if($servidor_telefone)
                    {{ $servidor_telefone }}
                @endif
                @if($servidor_telefone && $servidor_email)
                    /
                @endif
                @if($servidor_email)
                    {{ $servidor_email }}
                @endif
            @endif
        </div>
    </div>

    <!-- Página 2 - Anexo -->
    <div class="page-break"></div>

    <div class="header">
        <h1>ANEXO I - RELAÇÃO DE MATERIAIS E EQUIPAMENTOS</h1>
        @if(isset($numero_oficio) && !empty($numero_oficio))
            <div style="font-size: 10pt; margin-top: 5px; color: #666;">
                Anexo ao Ofício N.º {{ $numero_oficio }}
            </div>
        @endif
    </div>

    <div class="content" style="margin-bottom: 15px;">
        <p class="no-indent" style="font-size: 10.5pt;">Relação detalhada dos materiais e equipamentos solicitados:</p>
    </div>

    <!-- Tabela de Materiais -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Material/Equipamento</th>
                    <th>Especificação</th>
                    <th>Qtd.</th>
                    <th>Un.</th>
                    <th>Justificativa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materiais as $index => $item)
                    @if($item['is_customizado'] ?? false)
                        {{-- Material Customizado (Não Cadastrado) --}}
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $item['nome_customizado'] }}</strong></td>
                            <td style="font-size: 8.5pt;">
                                {{ $item['especificacao_customizada'] ?? '-' }}
                            </td>
                            <td>{{ formatar_quantidade($item['quantidade'], $item['unidade_medida_customizada'] ?? null) }}</td>
                            <td>{{ ucfirst($item['unidade_medida_customizada']) }}</td>
                            <td style="font-size: 8.5pt;">{{ $item['justificativa'] }}</td>
                        </tr>
                    @else
                        {{-- Material do Sistema --}}
                        @php
                            $material = $item['material'];
                            $camposEspecificos = $material->campos_especificos ?? [];
                            $especificacoes = [];

                            // Montar especificações técnicas
                            if (!empty($camposEspecificos)) {
                                foreach ($camposEspecificos as $key => $value) {
                                    if ($value) {
                                        $label = ucfirst(str_replace('_', ' ', $key));
                                        $especificacoes[] = "{$label}: {$value}";
                                    }
                                }
                            }

                            $especificacaoTexto = !empty($especificacoes)
                                ? implode('; ', $especificacoes)
                                : ($material->categoria_formatada ?? '');
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $material->nome }}</strong></td>
                            <td style="font-size: 8.5pt;">
                                {{ $especificacaoTexto }}
                                @if($material->codigo)
                                    <br><small>Cód: {{ $material->codigo }}</small>
                                @endif
                            </td>
                            <td>{{ formatar_quantidade($item['quantidade'], $material->unidade_medida) }}</td>
                            <td>{{ ucfirst($material->unidade_medida) }}</td>
                            <td style="font-size: 8.5pt;">{{ $item['justificativa'] }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    @if(!empty($observacoes))
    <div class="content" style="margin-top: 10px;">
        <p class="no-indent" style="font-size: 10pt;"><strong>Observações:</strong> {{ $observacoes }}</p>
    </div>
    @endif

    <!-- Rodapé -->
    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y H:i') }} por {{ $usuario->name ?? 'Sistema' }}</p>
    </div>
</body>
</html>

