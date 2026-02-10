<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Demandas Abertas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 16px; font-weight: bold; }
        .date { font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; padding: 10px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Relatório de Demandas Abertas</div>
        <div class="date">Gerado em: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Solicitante</th>
                <th>Tipo</th>
                <th>Localidade</th>
                <th>Data Abertura</th>
                <th>Prioridade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($demandas as $demanda)
            <tr>
                <td>{{ $demanda->codigo }}</td>
                <td>{{ $demanda->solicitante_nome }}</td>
                <td>{{ ucfirst($demanda->tipo) }}</td>
                <td>{{ $demanda->localidade_nome ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($demanda->data_abertura)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($demanda->prioridade) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Nenhuma demanda aberta encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        VERTEXSEMAGRI - Sistema de Gestão Municipal
    </div>
</body>
</html>
