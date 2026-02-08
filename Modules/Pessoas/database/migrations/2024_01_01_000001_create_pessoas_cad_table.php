<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Criar tabela de pessoas do Cadastro Único
        Schema::create('pessoas_cad', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cd_ibge')->nullable()->index(); // Código IBGE do município
            $table->string('cod_familiar_fam', 11)->nullable()->index(); // Código da família
            $table->tinyInteger('cod_est_cadastral_memb')->nullable(); // Estado cadastral
            $table->tinyInteger('ind_trabalho_infantil_pessoa')->nullable(); // Trabalho infantil
            $table->string('nom_pessoa', 70)->nullable()->index(); // Nome
            $table->string('num_nis_pessoa_atual', 11)->nullable()->unique(); // NIS
            $table->string('nom_apelido_pessoa', 34)->nullable(); // Apelido/Nome Social
            $table->tinyInteger('cod_sexo_pessoa')->nullable(); // Sexo
            $table->string('dta_nasc_pessoa', 8)->nullable(); // Data nascimento (DDMMAAAA)
            $table->tinyInteger('cod_parentesco_rf_pessoa')->nullable(); // Parentesco
            $table->tinyInteger('cod_raca_cor_pessoa')->nullable(); // Raça/Cor
            $table->string('nom_completo_mae_pessoa', 70)->nullable(); // Nome da mãe
            $table->string('nom_completo_pai_pessoa', 70)->nullable(); // Nome do pai
            $table->tinyInteger('cod_local_nascimento_pessoa')->nullable(); // Local nascimento
            $table->string('sig_uf_munic_nasc_pessoa', 2)->nullable(); // UF nascimento
            $table->string('nom_ibge_munic_nasc_pessoa', 35)->nullable(); // Município nascimento
            $table->integer('cod_ibge_munic_nasc_pessoa')->nullable(); // Código IBGE nascimento
            $table->string('nom_pais_origem_pessoa', 40)->nullable(); // País origem
            $table->tinyInteger('cod_pais_origem_pessoa')->nullable(); // Código país
            $table->tinyInteger('cod_certidao_registrada_pessoa')->nullable(); // Certidão registrada
            $table->tinyInteger('fx_idade')->nullable(); // Faixa etária
            $table->string('marc_pbf', 1)->nullable(); // Recebe PBF
            $table->tinyInteger('ind_identidade_genero')->nullable(); // Identidade de gênero
            $table->tinyInteger('ind_transgenero')->nullable(); // Transgênero
            $table->tinyInteger('ind_tipo_identidade_genero')->nullable(); // Tipo identidade gênero
            $table->tinyInteger('cod_certidao_civil_pessoa')->nullable(); // Tipo certidão
            $table->string('cod_livro_termo_certid_pessoa', 8)->nullable(); // Livro certidão
            $table->string('cod_folha_termo_certid_pessoa', 4)->nullable(); // Folha certidão
            $table->string('cod_termo_matricula_certid_pessoa', 32)->nullable(); // Termo certidão
            $table->string('nom_munic_certid_pessoa', 35)->nullable(); // Município certidão
            $table->string('cod_ibge_munic_certid_pessoa', 7)->nullable(); // IBGE certidão
            $table->string('cod_cartorio_certid_pessoa', 15)->nullable(); // Cartório certidão
            $table->string('num_cpf_pessoa', 11)->nullable()->index(); // CPF
            $table->string('num_identidade_pessoa', 20)->nullable(); // RG
            $table->string('cod_complemento_pessoa', 5)->nullable(); // Complemento RG
            $table->string('dta_emissao_ident_pessoa', 8)->nullable(); // Data emissão RG
            $table->string('sig_uf_ident_pessoa', 2)->nullable(); // UF RG
            $table->string('sig_orgao_emissor_pessoa', 8)->nullable(); // Órgão emissor RG
            $table->string('num_cart_trab_prev_soc_pessoa', 7)->nullable(); // CTPS
            $table->string('num_serie_trab_prev_soc_pessoa', 5)->nullable(); // Série CTPS
            $table->string('dta_emissao_cart_trab_pessoa', 8)->nullable(); // Data CTPS
            $table->string('sig_uf_cart_trab_pessoa', 2)->nullable(); // UF CTPS
            $table->string('num_titulo_eleitor_pessoa', 13)->nullable(); // Título eleitor
            $table->string('num_zona_tit_eleitor_pessoa', 4)->nullable(); // Zona título
            $table->string('num_secao_tit_eleitor_pessoa', 4)->nullable(); // Seção título
            $table->tinyInteger('cod_deficiencia_memb')->nullable(); // Tem deficiência
            $table->tinyInteger('ind_def_cegueira_memb')->nullable(); // Cegueira
            $table->tinyInteger('ind_def_baixa_visao_memb')->nullable(); // Baixa visão
            $table->tinyInteger('ind_def_surdez_profunda_memb')->nullable(); // Surdez profunda
            $table->tinyInteger('ind_def_surdez_leve_memb')->nullable(); // Surdez leve
            $table->tinyInteger('ind_def_fisica_memb')->nullable(); // Deficiência física
            $table->tinyInteger('ind_def_mental_memb')->nullable(); // Deficiência mental
            $table->tinyInteger('ind_def_sindrome_down_memb')->nullable(); // Síndrome de Down
            $table->tinyInteger('ind_def_transtorno_mental_memb')->nullable(); // Transtorno mental
            $table->tinyInteger('ind_ajuda_nao_memb')->nullable(); // Não recebe ajuda
            $table->tinyInteger('ind_ajuda_familia_memb')->nullable(); // Ajuda da família
            $table->tinyInteger('ind_ajuda_especializado_memb')->nullable(); // Ajuda especializada
            $table->tinyInteger('ind_ajuda_vizinho_memb')->nullable(); // Ajuda vizinho
            $table->tinyInteger('ind_ajuda_instituicao_memb')->nullable(); // Ajuda instituição
            $table->tinyInteger('ind_ajuda_outra_memb')->nullable(); // Outra ajuda
            $table->tinyInteger('cod_sabe_ler_escrever_memb')->nullable(); // Sabe ler/escrever
            $table->tinyInteger('ind_frequenta_escola_memb')->nullable(); // Frequenta escola
            $table->string('nom_escola_memb', 70)->nullable(); // Nome escola
            $table->tinyInteger('cod_escola_local_memb')->nullable(); // Escola no município
            $table->string('sig_uf_escola_memb', 2)->nullable(); // UF escola
            $table->string('nom_munic_escola_memb', 35)->nullable(); // Município escola
            $table->integer('cod_ibge_munic_escola_memb')->nullable(); // IBGE escola
            $table->string('cod_censo_inep_memb', 8)->nullable(); // Código INEP
            $table->tinyInteger('cod_curso_frequenta_memb')->nullable(); // Curso frequenta
            $table->tinyInteger('cod_ano_serie_frequenta_memb')->nullable(); // Ano/série frequenta
            $table->tinyInteger('cod_curso_frequentou_pessoa_memb')->nullable(); // Curso frequentou
            $table->tinyInteger('cod_ano_serie_frequentou_memb')->nullable(); // Ano/série frequentou
            $table->tinyInteger('cod_concluiu_frequentou_memb')->nullable(); // Concluiu curso
            $table->tinyInteger('grau_instrucao')->nullable(); // Grau instrução
            $table->tinyInteger('cod_trabalhou_memb')->nullable(); // Trabalhou semana passada
            $table->tinyInteger('cod_afastado_trab_memb')->nullable(); // Afastado trabalho
            $table->tinyInteger('cod_agricultura_trab_memb')->nullable(); // Agricultura
            $table->tinyInteger('cod_principal_trab_memb')->nullable(); // Função principal
            $table->tinyInteger('cod_trabalho_12_meses_memb')->nullable(); // Trabalho 12 meses
            $table->tinyInteger('qtd_meses_12_meses_memb')->nullable(); // Meses trabalhados
            $table->integer('fx_renda_individual_805')->nullable(); // Faixa renda trabalho
            $table->integer('fx_renda_individual_808')->nullable(); // Faixa renda 12 meses
            $table->integer('fx_renda_individual_809_1')->nullable(); // Faixa doação
            $table->integer('fx_renda_individual_809_2')->nullable(); // Faixa aposentadoria
            $table->integer('fx_renda_individual_809_3')->nullable(); // Faixa seguro desemprego
            $table->integer('fx_renda_individual_809_4')->nullable(); // Faixa pensão
            $table->integer('fx_renda_individual_809_5')->nullable(); // Faixa outras fontes
            $table->tinyInteger('marc_sit_rua')->nullable(); // Situação de rua
            $table->tinyInteger('ind_dormir_rua_memb')->nullable(); // Dorme na rua
            $table->tinyInteger('qtd_dormir_freq_rua_memb')->nullable(); // Frequência rua
            $table->tinyInteger('ind_dormir_albergue_memb')->nullable(); // Dorme albergue
            $table->tinyInteger('qtd_dormir_freq_albergue_memb')->nullable(); // Frequência albergue
            $table->tinyInteger('ind_dormir_dom_part_memb')->nullable(); // Dorme domicílio
            $table->tinyInteger('qtd_dormir_freq_dom_part_memb')->nullable(); // Frequência domicílio
            $table->tinyInteger('ind_outro_memb')->nullable(); // Outro local
            $table->tinyInteger('qtd_freq_outro_memb')->nullable(); // Frequência outro
            $table->tinyInteger('cod_tempo_rua_memb')->nullable(); // Tempo na rua
            $table->tinyInteger('ind_motivo_perda_memb')->nullable(); // Motivo perda moradia
            $table->tinyInteger('ind_motivo_ameaca_memb')->nullable(); // Motivo ameaça
            $table->tinyInteger('ind_motivo_probs_fam_memb')->nullable(); // Motivo problemas família
            $table->tinyInteger('ind_motivo_alcool_memb')->nullable(); // Motivo alcoolismo
            $table->tinyInteger('ind_motivo_desemprego_memb')->nullable(); // Motivo desemprego
            $table->tinyInteger('ind_motivo_trabalho_memb')->nullable(); // Motivo trabalho
            $table->tinyInteger('ind_motivo_saude_memb')->nullable(); // Motivo saúde
            $table->tinyInteger('ind_motivo_pref_memb')->nullable(); // Motivo preferência
            $table->tinyInteger('ind_motivo_outro_memb')->nullable(); // Motivo outro
            $table->tinyInteger('ind_motivo_nao_sabe_memb')->nullable(); // Não sabe motivo
            $table->tinyInteger('ind_motivo_nao_resp_memb')->nullable(); // Não respondeu motivo
            $table->tinyInteger('cod_tempo_cidade_memb')->nullable(); // Tempo na cidade
            $table->tinyInteger('cod_vive_fam_rua_memb')->nullable(); // Vive com família na rua
            $table->tinyInteger('cod_contato_parente_memb')->nullable(); // Contato parente
            $table->tinyInteger('ind_ativ_com_escola_memb')->nullable(); // Atividade escola
            $table->tinyInteger('ind_ativ_com_coop_memb')->nullable(); // Atividade cooperativa
            $table->tinyInteger('ind_ativ_com_mov_soc_memb')->nullable(); // Atividade movimento social
            $table->tinyInteger('ind_ativ_com_nao_sabe_memb')->nullable(); // Não sabe atividade
            $table->tinyInteger('ind_ativ_com_nao_resp_memb')->nullable(); // Não respondeu atividade
            $table->tinyInteger('ind_atend_cras_memb')->nullable(); // Atendido CRAS
            $table->tinyInteger('ind_atend_creas_memb')->nullable(); // Atendido CREAS
            $table->tinyInteger('ind_atend_centro_ref_rua_memb')->nullable(); // Atendido centro ref rua
            $table->tinyInteger('ind_atend_inst_gov_memb')->nullable(); // Atendido instituição gov
            $table->tinyInteger('ind_atend_inst_nao_gov_memb')->nullable(); // Atendido instituição não-gov
            $table->tinyInteger('ind_atend_hospital_geral_memb')->nullable(); // Atendido hospital
            $table->tinyInteger('cod_cart_assinada_memb')->nullable(); // Carteira assinada
            $table->tinyInteger('ind_dinh_const_memb')->nullable(); // Dinheiro construção
            $table->tinyInteger('ind_dinh_flanelhinha_memb')->nullable(); // Dinheiro guardador carro
            $table->tinyInteger('ind_dinh_carregador_memb')->nullable(); // Dinheiro carregador
            $table->tinyInteger('ind_dinh_catador_memb')->nullable(); // Dinheiro catador
            $table->tinyInteger('ind_dinh_servs_gerais_memb')->nullable(); // Dinheiro serviços gerais
            $table->tinyInteger('ind_dinh_pede_memb')->nullable(); // Dinheiro pedinte
            $table->tinyInteger('ind_dinh_vendas_memb')->nullable(); // Dinheiro vendas
            $table->tinyInteger('ind_dinh_outro_memb')->nullable(); // Dinheiro outro
            $table->tinyInteger('ind_dinh_nao_resp_memb')->nullable(); // Não respondeu dinheiro
            $table->tinyInteger('ind_atend_nenhum_memb')->nullable(); // Não foi atendido
            $table->integer('ref_cad')->nullable()->index(); // Referência Cadastro Único
            $table->integer('ref_pbf')->nullable()->index(); // Referência Bolsa Família
            
            // Campos adicionais para integração com o sistema
            $table->foreignId('localidade_id')->nullable()->constrained('localidades')->onDelete('set null');
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Índices adicionais
            $table->index('localidade_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoas_cad');
    }
};

