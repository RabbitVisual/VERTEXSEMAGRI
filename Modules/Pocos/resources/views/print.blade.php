<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poço {{ $poco->codigo ?? '#' . $poco->id }} - Impressão</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .print-container {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Cabeçalho */
        .header {
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .logo-section h1 {
            font-size: 24pt;
            color: #2c3e50;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .logo-section p {
            font-size: 10pt;
            color: #666;
        }

        .document-info {
            text-align: right;
            border: 2px solid #2c3e50;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .document-info .doc-type {
            font-size: 12pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .document-info .doc-code {
            font-size: 18pt;
            font-weight: bold;
            color: #3498db;
            letter-spacing: 1px;
        }

        /* Seções */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #34495e;
            color: #fff;
            padding: 8px 12px;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 12px;
            border-left: 5px solid #3498db;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-item {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 9pt;
            margin-bottom: 3px;
        }

        .info-value {
            color: #333;
            font-size: 11pt;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10pt;
        }

        .status-ativo {
            background: #d4edda;
            color: #155724;
        }

        .status-inativo {
            background: #f8f9fa;
            color: #6c757d;
        }

        .status-manutencao {
            background: #fff3cd;
            color: #856404;
        }

        .status-bomba_queimada {
            background: #f8d7da;
            color: #721c24;
        }

        /* Observações */
        .observacoes {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin-top: 15px;
        }

        /* Rodapé */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }

        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Cabeçalho -->
        <div class="header">
            <div class="header-top">
                <div class="logo-section">
                    <h1>PREFEITURA MUNICIPAL</h1>
                    <p>Coração de Maria - Bahia</p>
                    <p>Secretaria de Agricultura e Meio Ambiente</p>
                </div>
                <div class="document-info">
                    <div class="doc-type">FICHA TÉCNICA</div>
                    <div class="doc-code">{{ $poco->codigo ?? '#' . $poco->id }}</div>
                </div>
            </div>
        </div>

        <!-- Informações Básicas -->
        <div class="section">
            <div class="section-title">INFORMAÇÕES BÁSICAS</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Código</div>
                    <div class="info-value">{{ $poco->codigo ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $poco->status }}">
                            {{ ucfirst(str_replace('_', ' ', $poco->status)) }}
                        </span>
                    </div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">Localidade</div>
                    <div class="info-value">
                        <strong>{{ $poco->localidade->nome ?? 'N/A' }}</strong>
                        @if($poco->localidade && $poco->localidade->codigo)
                            ({{ $poco->localidade->codigo }})
                        @endif
                    </div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">Endereço</div>
                    <div class="info-value">{{ $poco->endereco }}</div>
                </div>
                @if($poco->latitude && $poco->longitude)
                <div class="info-item">
                    <div class="info-label">Latitude</div>
                    <div class="info-value">{{ $poco->latitude }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Longitude</div>
                    <div class="info-value">{{ $poco->longitude }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Características Técnicas -->
        <div class="section">
            <div class="section-title">CARACTERÍSTICAS TÉCNICAS</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Profundidade</div>
                    <div class="info-value">
                        <strong>{{ number_format($poco->profundidade_metros, 2, ',', '.') }} metros</strong>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Vazão</div>
                    <div class="info-value">
                        @if($poco->vazao_litros_hora)
                            <strong>{{ number_format($poco->vazao_litros_hora, 2, ',', '.') }} L/h</strong>
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                @if($poco->diametro)
                <div class="info-item">
                    <div class="info-label">Diâmetro</div>
                    <div class="info-value">{{ $poco->diametro }}</div>
                </div>
                @endif
                @if($poco->data_perfuracao)
                <div class="info-item">
                    <div class="info-label">Data de Perfuração</div>
                    <div class="info-value">{{ $poco->data_perfuracao->format('d/m/Y') }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Informações da Bomba -->
        @if($poco->tipo_bomba || $poco->potencia_bomba)
        <div class="section">
            <div class="section-title">INFORMAÇÕES DA BOMBA</div>
            <div class="info-grid">
                @if($poco->tipo_bomba)
                <div class="info-item">
                    <div class="info-label">Tipo de Bomba</div>
                    <div class="info-value">{{ $poco->tipo_bomba }}</div>
                </div>
                @endif
                @if($poco->potencia_bomba)
                <div class="info-item">
                    <div class="info-label">Potência</div>
                    <div class="info-value">{{ $poco->potencia_bomba }} HP</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Manutenção -->
        @if($poco->ultima_manutencao || $poco->proxima_manutencao || $poco->equipeResponsavel)
        <div class="section">
            <div class="section-title">MANUTENÇÃO E RESPONSABILIDADE</div>
            <div class="info-grid">
                @if($poco->equipeResponsavel)
                <div class="info-item full-width">
                    <div class="info-label">Equipe Responsável</div>
                    <div class="info-value">
                        <strong>{{ $poco->equipeResponsavel->nome }}</strong>
                        @if($poco->equipeResponsavel->codigo)
                            ({{ $poco->equipeResponsavel->codigo }})
                        @endif
                    </div>
                </div>
                @endif
                @if($poco->ultima_manutencao)
                <div class="info-item">
                    <div class="info-label">Última Manutenção</div>
                    <div class="info-value">{{ $poco->ultima_manutencao->format('d/m/Y') }}</div>
                </div>
                @endif
                @if($poco->proxima_manutencao)
                <div class="info-item">
                    <div class="info-label">Próxima Manutenção</div>
                    <div class="info-value">
                        <strong>{{ $poco->proxima_manutencao->format('d/m/Y') }}</strong>
                        @if($poco->precisaManutencao())
                            <span style="color: #e74c3c; font-weight: bold;">⚠ ATENÇÃO</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Observações -->
        @if($poco->observacoes)
        <div class="section">
            <div class="section-title">OBSERVAÇÕES</div>
            <div class="observacoes">
                {{ $poco->observacoes }}
            </div>
        </div>
        @endif

        <!-- Rodapé -->
        <div class="footer">
            <p>Documento gerado em {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>VERTEXSEMAGRI - Sistema de Gestão de Demandas Públicas</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
