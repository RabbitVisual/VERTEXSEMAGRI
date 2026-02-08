<?php

namespace Modules\ProgramasAgricultura\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ProgramasAgricultura\App\Models\Evento;
use Carbon\Carbon;

class EventosSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            [
                'codigo' => 'EVT-CAP-2025-001',
                'titulo' => 'Capacitação em Manejo Sustentável do Solo',
                'descricao' => 'Curso prático sobre técnicas de manejo sustentável do solo, conservação, adubação orgânica e preparo adequado para plantio.',
                'tipo' => 'capacitacao',
                'data_inicio' => Carbon::now()->addDays(15),
                'data_fim' => Carbon::now()->addDays(15),
                'hora_inicio' => Carbon::createFromTime(8, 0),
                'hora_fim' => Carbon::createFromTime(17, 0),
                'vagas_totais' => 50,
                'vagas_preenchidas' => 0,
                'status' => 'agendado',
                'publico_alvo' => 'Agricultores familiares, técnicos agrícolas e interessados em agricultura sustentável.',
                'conteudo_programatico' => 'Introdução ao manejo sustentável, análise de solo, adubação orgânica, técnicas de conservação, práticas de plantio, controle de erosão.',
                'instrutor_palestrante' => 'Eng. Agrônomo da SEMAGRI',
                'materiais_necessarios' => 'Caderno para anotações, caneta, protetor solar, chapéu.',
                'publico' => true,
                'inscricao_aberta' => true,
                'data_limite_inscricao' => Carbon::now()->addDays(10),
            ],
            [
                'codigo' => 'EVT-PAL-2025-001',
                'titulo' => 'Palestra: Novas Tecnologias na Agricultura Familiar',
                'descricao' => 'Palestra sobre o uso de tecnologias modernas na agricultura familiar, incluindo irrigação, cultivo protegido e técnicas de aumento de produtividade.',
                'tipo' => 'palestra',
                'data_inicio' => Carbon::now()->addDays(20),
                'data_fim' => Carbon::now()->addDays(20),
                'hora_inicio' => Carbon::createFromTime(14, 0),
                'hora_fim' => Carbon::createFromTime(17, 0),
                'vagas_totais' => 100,
                'vagas_preenchidas' => 0,
                'status' => 'agendado',
                'publico_alvo' => 'Agricultores familiares e interessados em tecnologia agrícola.',
                'conteudo_programatico' => 'Tecnologias de irrigação, cultivo protegido, uso de aplicativos agrícolas, técnicas de aumento de produtividade, cases de sucesso.',
                'instrutor_palestrante' => 'Especialista em Tecnologia Agrícola',
                'materiais_necessarios' => 'Caderno para anotações, caneta.',
                'publico' => true,
                'inscricao_aberta' => true,
                'data_limite_inscricao' => Carbon::now()->addDays(15),
            ],
            [
                'codigo' => 'EVT-FEIRA-2025-001',
                'titulo' => 'Feira de Produtos da Agricultura Familiar',
                'descricao' => 'Feira para comercialização de produtos da agricultura familiar, com espaço para exposição e venda de produtos locais.',
                'tipo' => 'feira',
                'data_inicio' => Carbon::now()->addDays(30),
                'data_fim' => Carbon::now()->addDays(30),
                'hora_inicio' => Carbon::createFromTime(6, 0),
                'hora_fim' => Carbon::createFromTime(18, 0),
                'vagas_totais' => 80,
                'vagas_preenchidas' => 0,
                'status' => 'agendado',
                'publico_alvo' => 'Agricultores familiares que desejam comercializar seus produtos.',
                'conteudo_programatico' => 'Exposição e comercialização de produtos da agricultura familiar, troca de experiências, networking entre produtores.',
                'instrutor_palestrante' => null,
                'materiais_necessarios' => 'Produtos para venda, mesa, cadeira (se necessário), material de exposição.',
                'publico' => true,
                'inscricao_aberta' => true,
                'data_limite_inscricao' => Carbon::now()->addDays(25),
            ],
            [
                'codigo' => 'EVT-DIA-CAMPO-2025-001',
                'titulo' => 'Dia de Campo: Técnicas de Produção Orgânica',
                'descricao' => 'Visita técnica a propriedade modelo para demonstração prática de técnicas de produção orgânica e manejo sustentável.',
                'tipo' => 'dia_campo',
                'data_inicio' => Carbon::now()->addDays(45),
                'data_fim' => Carbon::now()->addDays(45),
                'hora_inicio' => Carbon::createFromTime(7, 0),
                'hora_fim' => Carbon::createFromTime(16, 0),
                'vagas_totais' => 40,
                'vagas_preenchidas' => 0,
                'status' => 'agendado',
                'publico_alvo' => 'Agricultores familiares interessados em produção orgânica.',
                'conteudo_programatico' => 'Visita a propriedade modelo, demonstração prática de técnicas orgânicas, manejo de solo, controle biológico de pragas, adubação orgânica.',
                'instrutor_palestrante' => 'Eng. Agrônomo Especialista em Produção Orgânica',
                'materiais_necessarios' => 'Roupas adequadas para campo, protetor solar, chapéu, água, caderno para anotações.',
                'publico' => true,
                'inscricao_aberta' => true,
                'data_limite_inscricao' => Carbon::now()->addDays(40),
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }
    }
}

