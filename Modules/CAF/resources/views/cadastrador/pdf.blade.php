<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário CAF - {{ $cadastro->protocolo ?? $cadastro->codigo }}</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f0f0f0;
            padding: 8px;
            font-weight: bold;
            margin-bottom: 10px;
            border-left: 4px solid #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CADASTRO DE AGRICULTOR FAMILIAR (CAF)</h1>
        <p><strong>Protocolo:</strong> {{ $cadastro->protocolo ?? 'N/A' }} | <strong>Código:</strong> {{ $cadastro->codigo }}</p>
        <p><strong>Data de Cadastro:</strong> {{ $cadastro->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Dados do Agricultor -->
    <div class="section">
        <div class="section-title">1. DADOS DO AGRICULTOR</div>
        <table>
            <tr>
                <td><span class="label">Nome Completo:</span> {{ $cadastro->nome_completo }}</td>
                <td><span class="label">CPF:</span> {{ $cadastro->cpf }}</td>
            </tr>
            <tr>
                <td><span class="label">RG:</span> {{ $cadastro->rg ?? 'N/A' }}</td>
                <td><span class="label">Data de Nascimento:</span> {{ $cadastro->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><span class="label">Sexo:</span> {{ $cadastro->sexo ?? 'N/A' }}</td>
                <td><span class="label">Estado Civil:</span> {{ $cadastro->estado_civil_texto }}</td>
            </tr>
            <tr>
                <td><span class="label">Telefone:</span> {{ $cadastro->telefone ?? 'N/A' }}</td>
                <td><span class="label">Celular:</span> {{ $cadastro->celular ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">E-mail:</span> {{ $cadastro->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Endereço:</span> {{ $cadastro->logradouro ?? '' }} {{ $cadastro->numero ?? '' }}, {{ $cadastro->bairro ?? '' }} - {{ $cadastro->cidade ?? '' }}/{{ $cadastro->uf ?? '' }}</td>
            </tr>
            <tr>
                <td><span class="label">CEP:</span> {{ $cadastro->cep ?? 'N/A' }}</td>
                <td><span class="label">Localidade:</span> {{ $cadastro->localidade?->nome ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    @if($cadastro->conjuge)
    <!-- Dados do Cônjuge -->
    <div class="section">
        <div class="section-title">2. DADOS DO CÔJUGE</div>
        <table>
            <tr>
                <td><span class="label">Nome Completo:</span> {{ $cadastro->conjuge->nome_completo }}</td>
                <td><span class="label">CPF:</span> {{ $cadastro->conjuge->cpf ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><span class="label">Data de Nascimento:</span> {{ $cadastro->conjuge->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</td>
                <td><span class="label">Profissão:</span> {{ $cadastro->conjuge->profissao ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Renda Mensal:</span> R$ {{ number_format($cadastro->conjuge->renda_mensal ?? 0, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    @endif

    @if($cadastro->familiares && $cadastro->familiares->count() > 0)
    <!-- Familiares -->
    <div class="section">
        <div class="section-title">3. FAMILIARES ({{ $cadastro->familiares->count() }})</div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data Nascimento</th>
                    <th>Parentesco</th>
                    <th>Escolaridade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cadastro->familiares as $familiar)
                    <tr>
                        <td>{{ $familiar->nome_completo }}</td>
                        <td>{{ $familiar->cpf ?? 'N/A' }}</td>
                        <td>{{ $familiar->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</td>
                        <td>{{ $familiar->parentesco_texto }}</td>
                        <td>{{ $familiar->escolaridade ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($cadastro->imovel)
    <!-- Dados do Imóvel -->
    <div class="section">
        <div class="section-title">4. DADOS DO IMÓVEL</div>
        <table>
            <tr>
                <td><span class="label">Tipo de Posse:</span> {{ $cadastro->imovel->tipo_posse_texto }}</td>
                <td><span class="label">Localidade:</span> {{ $cadastro->imovel->localidade?->nome ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><span class="label">Área Total:</span> {{ number_format($cadastro->imovel->area_total_hectares ?? 0, 2, ',', '.') }} ha</td>
                <td><span class="label">Área Agricultável:</span> {{ number_format($cadastro->imovel->area_agricultavel_hectares ?? 0, 2, ',', '.') }} ha</td>
            </tr>
            <tr>
                <td><span class="label">Área de Pastagem:</span> {{ number_format($cadastro->imovel->area_pastagem_hectares ?? 0, 2, ',', '.') }} ha</td>
                <td><span class="label">Área Reserva Legal:</span> {{ number_format($cadastro->imovel->area_reserva_legal_hectares ?? 0, 2, ',', '.') }} ha</td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Atividades:</span> 
                    @if($cadastro->imovel->producao_vegetal) Produção Vegetal; @endif
                    @if($cadastro->imovel->producao_animal) Produção Animal; @endif
                    @if($cadastro->imovel->extrativismo) Extrativismo; @endif
                    @if($cadastro->imovel->aquicultura) Aquicultura; @endif
                </td>
            </tr>
        </table>
    </div>
    @endif

    @if($cadastro->rendaFamiliar)
    <!-- Renda Familiar -->
    <div class="section">
        <div class="section-title">5. RENDA FAMILIAR</div>
        <table>
            <tr>
                <td><span class="label">Renda Total Mensal:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_total_mensal ?? 0, 2, ',', '.') }}</td>
                <td><span class="label">Renda Per Capita:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_per_capita ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><span class="label">Número de Membros:</span> {{ $cadastro->rendaFamiliar->numero_membros ?? 0 }}</td>
                <td></td>
            </tr>
            <tr>
                <td><span class="label">Renda Agricultura:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_agricultura ?? 0, 2, ',', '.') }}</td>
                <td><span class="label">Renda Pecuária:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_pecuaria ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><span class="label">Renda Extrativismo:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_extrativismo ?? 0, 2, ',', '.') }}</td>
                <td><span class="label">Renda Aposentadoria:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_aposentadoria ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><span class="label">Renda Bolsa Família:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_bolsa_familia ?? 0, 2, ',', '.') }}</td>
                <td><span class="label">Outras Rendas:</span> R$ {{ number_format($cadastro->rendaFamiliar->renda_outros ?? 0, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    @endif

    @if($cadastro->observacoes)
    <!-- Observações -->
    <div class="section">
        <div class="section-title">6. OBSERVAÇÕES</div>
        <p>{{ $cadastro->observacoes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y H:i') }} | Sistema VERTEXSEMAGRI - Módulo CAF</p>
        <p>Este documento é uma cópia do cadastro pré-registrado no sistema municipal.</p>
    </div>
</body>
</html>

