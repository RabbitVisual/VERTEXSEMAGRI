<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Campo - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-item .number {
            font-size: 24px;
            font-weight: bold;
            color: #4472C4;
        }
        .stat-item .label {
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Campo</h1>
        <p>Funcionário: {{ $user->name }}</p>
        <p>Gerado em: {{ $dataGeracao->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info">
        <h3>Período do Relatório</h3>
        @if(isset($filtros['data_inicio']) && isset($filtros['data_fim']))
            <p><strong>De:</strong> {{ \Carbon\Carbon::parse($filtros['data_inicio'])->format('d/m/Y') }}</p>
            <p><strong>Até:</strong> {{ \Carbon\Carbon::parse($filtros['data_fim'])->format('d/m/Y') }}</p>
        @else
            <p>Todas as ordens</p>
        @endif
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="number">{{ $estatisticas['total'] }}</div>
            <div class="label">Total</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ $estatisticas['pendentes'] }}</div>
            <div class="label">Pendentes</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ $estatisticas['em_execucao'] }}</div>
            <div class="label">Em Execução</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ $estatisticas['concluidas'] }}</div>
            <div class="label">Concluídas</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Prioridade</th>
                <th>Localidade</th>
                <th>Data Criação</th>
                <th>Data Conclusão</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordens as $ordem)
                <tr>
                    <td>{{ $ordem->numero }}</td>
                    <td>{{ Str::limit($ordem->descricao, 50) }}</td>
                    <td>{{ ucfirst($ordem->status) }}</td>
                    <td>{{ ucfirst($ordem->prioridade) }}</td>
                    <td>{{ $ordem->demanda->localidade->nome ?? 'N/A' }}</td>
                    <td>{{ $ordem->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $ordem->data_conclusao ? \Carbon\Carbon::parse($ordem->data_conclusao)->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhuma ordem encontrada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

