<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo Diário de Atendimentos - VERTEX</title>
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
            font-size: 9px;
            line-height: 1.3;
            color: #1e293b;
            background: white;
        }

        /* Container Principal */
        .document-container {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 8px; /* Slightly smaller radius for professional look */
            overflow: hidden;
            background: white;
        }

        /* --- Header --- */
        .top-bar {
            background: #1e293b;
            color: white;
            padding: 12px 20px;
            /* Table layout for header ensures alignment in DOMPDF */
            display: table;
            width: 100%;
            border-bottom: 2px solid #0f172a;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 50%;
        }

        .brand-wrapper {
            display: inline-block;
        }

        .logo-img {
            vertical-align: middle;
            width: 32px;
            height: 32px;
            margin-right: 10px;
            display: inline-block;
        }

        .brand-info {
            display: inline-block;
            vertical-align: middle;
        }

        .brand-text {
            font-size: 16px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            color: #fff;
            display: block;
        }

        .brand-subtext {
            font-size: 8px;
            opacity: 0.7;
            font-weight: 600;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }

        .report-title h1 {
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #60a5fa; /* Blue accent */
            margin: 0;
        }

        .report-title p {
            font-size: 8px;
            opacity: 0.8;
            font-weight: 700;
            margin-top: 2px;
            color: #cbd5e1;
            text-transform: uppercase;
        }

        /* --- Sections --- */
        .section {
            width: 100%;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-header {
            background: #f8fafc;
            padding: 6px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 9px;
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* --- Summary Grid --- */
        .summary-grid {
            width: 100%;
            display: table;
            table-layout: fixed;
            background: #fff;
        }

        .summary-cell {
            display: table-cell;
            padding: 10px 20px;
            border-right: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .summary-cell:last-child {
            border-right: none;
        }

        .label {
            font-size: 7px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            display: block;
            margin-bottom: 4px;
        }

        .value {
            font-size: 11px;
            font-weight: 800;
            color: #0f172a;
        }

        /* --- Statistics Grid --- */
        .stats-grid {
            width: 100%;
            display: table;
            table-layout: fixed;
        }

        .stats-col {
            display: table-cell;
            padding: 10px 20px;
            vertical-align: top;
            width: 50%;
        }

        .stats-col:first-child {
            border-right: 1px solid #e2e8f0;
        }

        .inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inner-table td {
            padding: 3px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 9px;
        }
        .inner-table tr:last-child td {
            border-bottom: none;
        }

        /* --- Main Data Table --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .data-table th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 8px;
            text-align: left;
            padding: 8px 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:nth-child(even) {
            background: #fdfdfd;
        }

        /* --- Badges & Utility --- */
        .pill {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 8px;
            text-transform: uppercase;
        }
        .pill-blue { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .pill-gray { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }

        .footer {
            background: #f8fafc;
            padding: 10px 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 8px;
            color: #94a3b8;
            display: table;
            width: 100%;
        }

        .footer-left { display: table-cell; text-align: left; }
        .footer-right { display: table-cell; text-align: right; }

        .page-break { page-break-before: always; }
    </style>
</head>
<body>

    <div class="document-container">
        <!-- Header -->
        <div class="top-bar">
            <div class="header-left">
                <div class="brand-wrapper">
                    <!-- Ensure logo path is correct and accessible -->
                    <img src="{{ public_path('images/logo-icon.svg') }}" class="logo-img">
                    <div class="brand-info">
                        <span class="brand-text">VERTEX</span>
                        <span class="brand-subtext">Secretaria Municipal de Agricultura</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="report-title">
                    <h1>Resumo Diário de Atendimentos</h1>
                    <p>Relatório Técnico de Demandas Concluídas {{ $data->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="section">
            <div class="summary-grid">
                <div class="summary-cell">
                    <span class="label">Data Referência</span>
                    <div class="value">{{ $data->format('d/m/Y') }}</div>
                </div>
                <div class="summary-cell">
                    <span class="label">Total Ordens</span>
                    <div class="value">{{ $estatisticas['total_os'] }}</div>
                </div>
                <div class="summary-cell">
                    <span class="label">Demandas Únicas</span>
                    <div class="value">{{ $estatisticas['total_demandas'] }}</div>
                </div>
                <div class="summary-cell">
                    <span class="label">Tempo Médio Execução</span>
                    <div class="value">
                        @php
                            $tempoMedio = $estatisticas['tempo_medio'] ?? 0;
                            $h = floor($tempoMedio / 60);
                            $m = $tempoMedio % 60;
                            echo $h > 0 ? "{$h}h {$m}min" : "{$m}min";
                        @endphp
                    </div>
                </div>
                <div class="summary-cell">
                    <span class="label">Tempo Total (Homens-Hora)</span>
                    <div class="value">
                         @php
                            $tempoTotal = $estatisticas['tempo_total'] ?? 0;
                            $ht = floor($tempoTotal / 60);
                            $mt = $tempoTotal % 60;
                            echo "{$ht}h {$mt}min";
                        @endphp
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">1. Visão Geral da Produtividade</h2>
            </div>
            <div class="stats-grid">
                <div class="stats-col">
                    <span class="label">Por Localidade / Comunidade</span>
                    <table class="inner-table">
                        @forelse($estatisticas['por_localidade'] as $loc => $qty)
                            <tr>
                                <td>{{ $loc }}</td>
                                <td class="text-right font-bold" style="color: #3b82f6;">{{ $qty }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" style="font-style: italic; color: #94a3b8;">Nenhum dado registrado.</td></tr>
                        @endforelse
                    </table>
                </div>
                <div class="stats-col">
                    <span class="label">Por Tipo de Serviço</span>
                    <table class="inner-table">
                         @forelse($estatisticas['por_tipo'] as $tipo => $qty)
                            <tr>
                                <td>{{ ucfirst($tipo) }}</td>
                                <td class="text-right font-bold" style="color: #10b981;">{{ $qty }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" style="font-style: italic; color: #94a3b8;">Nenhum dado registrado.</td></tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">2. Detalhamento das Ordens de Serviço</h2>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">OS #</th>
                        <th style="width: 10%;">Cód. Demanda</th>
                        <th style="width: 15%;">Tipo Serviço</th>
                        <th style="width: 25%;">Localidade</th>
                        <th style="width: 25%;">Solicitante / Beneficiário</th>
                        <th style="width: 7%;" class="text-center">Hora</th>
                        <th style="width: 10%;" class="text-center">Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordens as $ordem)
                    <tr>
                        <td>
                            <span class="pill pill-blue">{{ $ordem->numero }}</span>
                        </td>
                        <td style="color: #64748b; font-family: monospace;">
                            {{ $ordem->demanda->codigo ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="pill pill-gray">{{ $ordem->tipo_servico }}</span>
                        </td>
                        <td class="font-bold">
                            {{ $ordem->demanda->localidade->nome ?? 'N/A' }}
                        </td>
                        <td>
                            {{ \App\Helpers\LgpdHelper::maskName($ordem->demanda->solicitante_nome ?? 'N/A') }}
                        </td>
                        <td class="text-center font-bold" style="color: #334155;">
                            {{ $ordem->data_conclusao ? $ordem->data_conclusao->format('H:i') : '-' }}
                        </td>
                        <td class="text-center" style="color: #64748b;">
                            {{ $ordem->tempo_execucao_formatado ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 20px; color: #94a3b8;">
                            Nenhuma ordem de serviço concluída neste período.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-left">
                <strong>SISTEMA VERTEX</strong> &bull; Gestão Integrada SEMAGRI
            </div>
            <div class="footer-right">
                Gerado em {{ $data_geracao->format('d/m/Y \à\s H:i:s') }} por {{ $usuario->name ?? 'Sistema' }}
            </div>
        </div>

    </div>

    @if($estatisticas['por_localidade']->count() > 10)
    <div class="page-break"></div>
    <div class="document-container">
        <div class="section-header">
            <h2 class="section-title">Anexo: Estatísticas Completas de Localidade</h2>
        </div>
        <div style="padding: 20px;">
            <!-- Simple table for extended stats -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Localidade / Comunidade</th>
                        <th class="text-right">Total Atendimentos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estatisticas['por_localidade'] as $loc => $qty)
                    <tr>
                        <td>{{ $loc }}</td>
                        <td class="text-right font-bold">{{ $qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</body>
</html>
