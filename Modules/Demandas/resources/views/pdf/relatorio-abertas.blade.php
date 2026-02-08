<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Demandas Abertas - VERTEX</title>
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
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        /* --- Header --- */
        .top-bar {
            background: #1e293b;
            color: white;
            padding: 12px 20px;
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
            color: #ef4444; /* Red accent for "Open" demands */
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
            color: #334155;
        }
        .inner-table tr:last-child td {
            border-bottom: none;
        }

        /* --- Main Data Table --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            table-layout: fixed;
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
            overflow: hidden;
            white-space: nowrap;
        }

        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
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
        .pill-gray { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .pill-red { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .pill-yellow { background: #fefce8; color: #b45309; border: 1px solid #fde047; }
        .pill-blue { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

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
                    <img src="{{ public_path('images/logo-icon.svg') }}" class="logo-img">
                    <div class="brand-info">
                        <span class="brand-text">VERTEX</span>
                        <span class="brand-subtext">Secretaria Municipal de Agricultura</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="report-title">
                    <h1>Relação de Demandas Abertas</h1>
                    <p>Controle de Pendências e Solicitações</p>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="section">
            <div class="summary-grid">
                <div class="summary-cell">
                    <span class="label">Total Abertas</span>
                    <div class="value" style="color: #ef4444;">{{ $estatisticas['total'] }}</div>
                </div>
                <div class="summary-cell">
                    <span class="label">Prioridade Alta/Urgente</span>
                    <div class="value">
                        {{ ($estatisticas['por_prioridade']['alta'] ?? 0) + ($estatisticas['por_prioridade']['urgente'] ?? 0) }}
                    </div>
                </div>
                <div class="summary-cell">
                    <span class="label">Data de Geração</span>
                    <div class="value">{{ $data_geracao->format('d/m/Y') }}</div>
                </div>
                <div class="summary-cell">
                    <span class="label">Responsável</span>
                    <div class="value">{{ $usuario->name ?? 'Sistema' }}</div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        @if($estatisticas['total'] > 0)
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">1. Visão Geral das Pendências</h2>
            </div>
            <div class="stats-grid">
                <div class="stats-col">
                    <span class="label">Por Tipo de Demanda</span>
                    <table class="inner-table">
                        @forelse($estatisticas['por_tipo'] as $tipo => $qty)
                            <tr>
                                <td>{{ ucfirst($tipo) }}</td>
                                <td class="text-right font-bold">{{ $qty }}</td>
                            </tr>
                        @empty
                             <tr><td colspan="2" style="font-style: italic; color: #94a3b8;">Nenhum registro.</td></tr>
                        @endforelse
                    </table>
                </div>
                <div class="stats-col">
                    <span class="label">Por Prioridade</span>
                    <table class="inner-table">
                        @forelse($estatisticas['por_prioridade'] as $prioridade => $qty)
                            @php
                                $color = match($prioridade) {
                                    'urgente' => '#ef4444',
                                    'alta' => '#f97316',
                                    'media' => '#eab308',
                                    default => '#334155'
                                };
                            @endphp
                            <tr>
                                <td>{{ ucfirst($prioridade) }}</td>
                                <td class="text-right font-bold" style="color: {{ $color }};">{{ $qty }}</td>
                            </tr>
                        @empty
                             <tr><td colspan="2" style="font-style: italic; color: #94a3b8;">Nenhum registro.</td></tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Table -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">2. Listagem de Demandas Pendentes</h2>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Código</th>
                        <th style="width: 22%;">Solicitante</th>
                        <th style="width: 20%;">Localidade</th>
                        <th style="width: 12%;">Tipo</th>
                        <th style="width: 10%;">Prioridade</th>
                        <th style="width: 10%;" class="text-center">Abertura</th>
                        <th style="width: 16%;">Motivo Resumido</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandas as $demanda)
                    <tr>
                        <td style="font-family: monospace; color: #64748b; font-weight: 700;">
                            {{ $demanda->codigo }}
                        </td>
                        <td class="font-bold">
                            {{ $demanda->solicitante_nome }}
                        </td>
                        <td>
                            {{ $demanda->localidade ? $demanda->localidade->nome : 'N/A' }}
                        </td>
                        <td>
                            <span class="pill pill-gray">{{ ucfirst($demanda->tipo) }}</span>
                        </td>
                        <td>
                            @php
                                $pClass = match($demanda->prioridade) {
                                    'urgente', 'alta' => 'pill-red',
                                    'media' => 'pill-yellow',
                                    default => 'pill-blue'
                                };
                            @endphp
                            <span class="pill {{ $pClass }}">{{ ucfirst($demanda->prioridade) }}</span>
                        </td>
                        <td class="text-center">
                            {{ $demanda->data_abertura ? $demanda->data_abertura->format('d/m/Y') : '-' }}
                        </td>
                        <td style="font-size: 8px; color: #64748b;">
                            {{ Str::limit($demanda->motivo, 45) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 20px; color: #94a3b8;">
                            Não há demandas abertas registradas.
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
                Gerado em {{ $data_geracao->format('d/m/Y \à\s H:i:s') }}
            </div>
        </div>
    </div>

</body>
</html>
