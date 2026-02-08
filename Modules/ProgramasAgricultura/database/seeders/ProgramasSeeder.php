<?php

namespace Modules\ProgramasAgricultura\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Carbon\Carbon;

class ProgramasSeeder extends Seeder
{
    public function run(): void
    {
        $programas = [
            [
                'codigo' => 'PROG-SEG-2025-001',
                'nome' => 'Seguro Safra 2025',
                'descricao' => 'Programa de seguro agrícola que garante proteção financeira aos agricultores familiares em caso de perda de produção devido a fenômenos climáticos adversos.',
                'tipo' => 'seguro_safra',
                'status' => 'ativo',
                'data_inicio' => Carbon::now()->startOfYear(),
                'data_fim' => Carbon::now()->endOfYear(),
                'vagas_disponiveis' => 500,
                'vagas_preenchidas' => 0,
                'requisitos' => 'Ser agricultor familiar, possuir DAP (Declaração de Aptidão ao Pronaf), estar cadastrado no CadÚnico, ter área de até 4 módulos fiscais.',
                'documentos_necessarios' => 'CPF, RG, Comprovante de Residência, DAP, Declaração de Imposto de Renda (se aplicável), Comprovante de Cadastro no CadÚnico.',
                'beneficios' => 'Proteção financeira em caso de perda de produção por seca, excesso de chuva, granizo, geada ou outros fenômenos climáticos. Valor do seguro proporcional à área plantada.',
                'orgao_responsavel' => 'Ministério da Agricultura, Pecuária e Abastecimento',
                'publico' => true,
            ],
            [
                'codigo' => 'PROG-PRONAF-2025-001',
                'nome' => 'PRONAF - Programa Nacional de Fortalecimento da Agricultura Familiar',
                'descricao' => 'Linha de crédito especial para agricultores familiares com juros reduzidos para investimento em infraestrutura, equipamentos e melhorias na produção.',
                'tipo' => 'pronaf',
                'status' => 'ativo',
                'data_inicio' => Carbon::now()->startOfYear(),
                'data_fim' => null,
                'vagas_disponiveis' => null,
                'vagas_preenchidas' => 0,
                'requisitos' => 'Ser agricultor familiar, possuir DAP, renda familiar anual de até R$ 500.000,00, estar cadastrado no CadÚnico.',
                'documentos_necessarios' => 'CPF, RG, Comprovante de Residência, DAP, Declaração de Imposto de Renda, Comprovante de Cadastro no CadÚnico, Comprovante de renda.',
                'beneficios' => 'Crédito com juros reduzidos (até 2,5% ao ano) para investimento em infraestrutura, máquinas, equipamentos, melhorias na produção e comercialização.',
                'orgao_responsavel' => 'Banco do Brasil / Banco do Nordeste',
                'publico' => true,
            ],
            [
                'codigo' => 'PROG-SEMENTES-2025-001',
                'nome' => 'Distribuição de Sementes para Plantio',
                'descricao' => 'Programa municipal de distribuição gratuita de sementes de milho, feijão e outras culturas para agricultores familiares do município.',
                'tipo' => 'distribuicao_sementes',
                'status' => 'ativo',
                'data_inicio' => Carbon::now()->startOfYear(),
                'data_fim' => Carbon::now()->addMonths(3),
                'vagas_disponiveis' => 300,
                'vagas_preenchidas' => 0,
                'requisitos' => 'Ser agricultor familiar cadastrado no município, possuir área para plantio, estar cadastrado no CadÚnico.',
                'documentos_necessarios' => 'CPF, RG, Comprovante de Residência, Comprovante de Cadastro no CadÚnico.',
                'beneficios' => 'Recebimento gratuito de sementes de milho, feijão e outras culturas adequadas à região, com orientação técnica sobre plantio.',
                'orgao_responsavel' => 'Secretaria Municipal de Agricultura e Meio Ambiente - SEMAGRI',
                'publico' => true,
            ],
            [
                'codigo' => 'PROG-INSUMOS-2025-001',
                'nome' => 'Distribuição de Insumos Agrícolas',
                'descricao' => 'Programa de distribuição de fertilizantes, defensivos agrícolas e outros insumos para apoiar a produção agrícola familiar.',
                'tipo' => 'distribuicao_insumos',
                'status' => 'ativo',
                'data_inicio' => Carbon::now()->startOfYear(),
                'data_fim' => Carbon::now()->addMonths(6),
                'vagas_disponiveis' => 200,
                'vagas_preenchidas' => 0,
                'requisitos' => 'Ser agricultor familiar cadastrado, possuir área em produção, estar cadastrado no CadÚnico.',
                'documentos_necessarios' => 'CPF, RG, Comprovante de Residência, Comprovante de Cadastro no CadÚnico.',
                'beneficios' => 'Recebimento de fertilizantes, defensivos agrícolas e outros insumos necessários para a produção, com orientação técnica sobre uso adequado.',
                'orgao_responsavel' => 'Secretaria Municipal de Agricultura e Meio Ambiente - SEMAGRI',
                'publico' => true,
            ],
            [
                'codigo' => 'PROG-AT-2025-001',
                'nome' => 'Assistência Técnica Rural',
                'descricao' => 'Serviço de assistência técnica gratuita para agricultores familiares, com visitas técnicas, orientações sobre manejo, plantio e colheita.',
                'tipo' => 'assistencia_tecnica',
                'status' => 'ativo',
                'data_inicio' => Carbon::now()->startOfYear(),
                'data_fim' => null,
                'vagas_disponiveis' => null,
                'vagas_preenchidas' => 0,
                'requisitos' => 'Ser agricultor familiar cadastrado no município.',
                'documentos_necessarios' => 'CPF, RG, Comprovante de Residência.',
                'beneficios' => 'Visitas técnicas gratuitas, orientações sobre manejo adequado do solo, plantio, colheita, controle de pragas e doenças, e melhorias na produção.',
                'orgao_responsavel' => 'Secretaria Municipal de Agricultura e Meio Ambiente - SEMAGRI',
                'publico' => true,
            ],
            [
                'codigo' => 'PROG-CRED-2025-001',
                'nome' => 'Crédito Rural para Agricultura Familiar',
                'descricao' => 'Linha de crédito especial com juros reduzidos para investimento em infraestrutura rural, máquinas e equipamentos agrícolas.',
                'tipo' => 'credito_rural',
                'status' => 'ativo',
                'data_inicio' => Carbon::now()->startOfYear(),
                'data_fim' => null,
                'vagas_disponiveis' => null,
                'vagas_preenchidas' => 0,
                'requisitos' => 'Ser agricultor familiar, possuir DAP, estar cadastrado no CadÚnico, comprovar renda.',
                'documentos_necessarios' => 'CPF, RG, Comprovante de Residência, DAP, Declaração de Imposto de Renda, Comprovante de Cadastro no CadÚnico, Comprovante de renda, Projeto técnico.',
                'beneficios' => 'Crédito com juros reduzidos para aquisição de máquinas, equipamentos, construção de benfeitorias, investimento em infraestrutura e melhorias na produção.',
                'orgao_responsavel' => 'Banco do Brasil / Banco do Nordeste',
                'publico' => true,
            ],
        ];

        foreach ($programas as $programa) {
            Programa::create($programa);
        }
    }
}

