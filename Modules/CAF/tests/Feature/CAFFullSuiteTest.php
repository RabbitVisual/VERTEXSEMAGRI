<?php

namespace Modules\CAF\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Modules\CAF\App\Models\CadastroCAF;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Localidades\App\Models\Localidade;
use Modules\Funcionarios\App\Models\Funcionario;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class CAFFullSuiteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $localidade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('module:enable', ['module' => 'CAF']);
        $this->artisan('module:enable', ['module' => 'Pessoas']);
        $this->artisan('module:enable', ['module' => 'Localidades']);

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->localidade = Localidade::create(['nome' => 'Vila Rural', 'ativo' => true]);
    }

    #[Test]
    public function can_search_pessoa_for_caf_registration()
    {
        PessoaCad::create([
            'nom_pessoa' => 'Agricultor João',
            'num_cpf_pessoa' => '12345678909',
            'ativo' => true,
            'localidade_id' => $this->localidade->id
        ]);

        $response = $this->actingAs($this->admin)->getJson(route('caf.cadastrador.buscar-pessoa', ['q' => 'Agricultor']));

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Agricultor João']);
    }

    #[Test]
    public function can_complete_full_caf_wizard_flow()
    {
        // Etapa 1: Dados Pessoais
        $etapa1Data = [
            'nome_completo' => 'Agricultor Silva',
            'cpf' => '12345678909',
            'data_nascimento' => '1980-05-10',
            'sexo' => 'M',
            'estado_civil' => 'casado',
            'localidade_id' => $this->localidade->id,
            'logradouro' => 'Rua do Sítio',
            'cidade' => 'Sertãozinho',
            'uf' => 'PR'
        ];

        $response = $this->actingAs($this->admin)->post(route('caf.cadastrador.store-etapa1'), $etapa1Data);

        $cadastro = CadastroCAF::where('cpf', '12345678909')->first();
        $this->assertNotNull($cadastro);
        $response->assertRedirect(route('caf.cadastrador.etapa2', $cadastro->id));

        // Etapa 2: Cônjuge
        $conjugeData = [
            'nome_completo' => 'Esposa Silva',
            'cpf' => '11223344517',
            'data_nascimento' => '1982-03-15',
            'sexo' => 'F',
        ];
        $this->actingAs($this->admin)->post(route('caf.cadastrador.store-etapa2', $cadastro->id), $conjugeData)
             ->assertRedirect(route('caf.cadastrador.etapa3', $cadastro->id));

        // Etapa 3: Familiares
        $familiaData = [
            'familiares' => [
                [
                    'nome_completo' => 'Filho Silva',
                    'parentesco' => 'Filho',
                    'sexo' => 'M',
                    'data_nascimento' => '2010-01-01',
                    'trabalha' => false
                ]
            ]
        ];
        $this->actingAs($this->admin)->post(route('caf.cadastrador.store-etapa3', $cadastro->id), $familiaData)
             ->assertRedirect(route('caf.cadastrador.etapa4', $cadastro->id));

        // Etapa 4: Imóvel
        $imovelData = [
            'tipo_posse' => 'proprio',
            'area_total_hectares' => 15.5,
            'area_agricultavel_hectares' => 10.0,
            'producao_vegetal' => true,
        ];
        $response = $this->actingAs($this->admin)->post(route('caf.cadastrador.store-etapa4', $cadastro->id), $imovelData);

        $response->assertRedirect(route('caf.cadastrador.etapa5', $cadastro->id));

        // Etapa 5: Renda e Finalização
        $rendaData = [
            'numero_membros' => 3,
            'renda_agricultura' => 3000,
            'renda_aposentadoria' => 0,
            'recebe_bolsa_familia' => false
        ];
        $this->actingAs($this->admin)->post(route('caf.cadastrador.store-etapa5', $cadastro->id), $rendaData)
             ->assertRedirect(route('caf.cadastrador.etapa6', $cadastro->id));

        $cadastro->refresh();
        $this->assertEquals('completo', $cadastro->status);
        $this->assertTrue($cadastro->estaCompleto());
    }

    #[Test]
    public function admin_can_approve_completed_cadastro()
    {
        $cadastro = CadastroCAF::create([
            'nome_completo' => 'Teste Admin Approved',
            'cpf' => '99887766554',
            'status' => 'completo',
            'created_by' => $this->admin->id
        ]);

        // Criar dependências manuais para passar no estaCompleto()
        $cadastro->conjuge()->create(['nome_completo' => 'Conjuge Teste']);
        $cadastro->familiares()->create(['nome_completo' => 'Familiar Teste', 'parentesco' => 'Filho']);
        $cadastro->imovel()->create(['tipo_posse' => 'proprio']);
        $cadastro->rendaFamiliar()->create(['numero_membros' => 2, 'renda_total_mensal' => 2000]);

        $this->assertTrue($cadastro->fresh()->estaCompleto(), 'Cadastro deveria estar completo antes do teste');

        $response = $this->actingAs($this->admin)->post(route('admin.caf.aprovar', $cadastro->id));

        $response->assertSessionHas('success');
        $this->assertEquals('aprovado', $cadastro->fresh()->status);
    }

    #[Test]
    public function admin_can_reject_cadastro_with_observations()
    {
        $cadastro = CadastroCAF::create([
            'nome_completo' => 'Teste Rejeição',
            'cpf' => '44556677889',
            'status' => 'em_andamento',
            'created_by' => $this->admin->id
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.caf.rejeitar', $cadastro->id), [
            'observacoes' => 'Falta documento do imóvel'
        ]);

        $this->assertEquals('rejeitado', $cadastro->fresh()->status);
        $this->assertEquals('Falta documento do imóvel', $cadastro->fresh()->observacoes);
    }

    #[Test]
    public function cannot_delete_sent_caf_registration()
    {
        $cadastro = CadastroCAF::create([
            'nome_completo' => 'Enviado Nacional',
            'cpf' => '00011122233',
            'status' => 'enviado_caf',
            'created_by' => $this->admin->id
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.caf.destroy', $cadastro->id));

        $this->assertDatabaseHas('cadastros_caf', ['id' => $cadastro->id]);
        $response->assertSessionHas('error');
    }

    #[Test]
    public function can_generate_pdf_for_cadastro()
    {
         $cadastro = CadastroCAF::create([
            'nome_completo' => 'Agricultor PDF',
            'cpf' => '55544433321',
            'status' => 'completo',
            'created_by' => $this->admin->id
        ]);

        $response = $this->actingAs($this->admin)->get(route('caf.cadastrador.pdf', $cadastro->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
