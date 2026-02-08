<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Equipes\App\Models\Equipe;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class FuncionarioUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar role 'campo'
        $roleCampo = Role::where('name', 'campo')->first();
        
        if (!$roleCampo) {
            $this->command->warn('Role "campo" não encontrada. Execute primeiro o RolesPermissionsSeeder.');
            return;
        }

        // Buscar ou criar uma equipe para o funcionário
        $equipe = Equipe::where('ativo', true)->first();
        
        if (!$equipe) {
            $this->command->warn('Nenhuma equipe ativa encontrada. Crie uma equipe primeiro.');
            return;
        }

        // Criar usuário funcionário
        $user = User::firstOrCreate(
            ['email' => 'funcionario@vertexsemagri.com'],
            [
                'name' => 'Funcionário de Campo',
                'password' => bcrypt('funcionario123'),
                'active' => true,
            ]
        );
        
        // Atribuir role
        if (!$user->hasRole('campo')) {
            $user->assignRole('campo');
        }

        // Criar funcionário correspondente
        $funcionario = Funcionario::firstOrCreate(
            ['email' => 'funcionario@vertexsemagri.com'],
            [
                'nome' => 'Funcionário de Campo',
                'cpf' => '000.000.000-00',
                'telefone' => '(75) 99999-9999',
                'funcao' => 'Eletricista',
                'ativo' => true,
            ]
        );

        // Vincular funcionário à equipe se ainda não estiver vinculado
        $jaVinculado = DB::table('equipe_funcionarios')
            ->where('equipe_id', $equipe->id)
            ->where('funcionario_id', $funcionario->id)
            ->exists();

        if (!$jaVinculado) {
            DB::table('equipe_funcionarios')->insert([
                'equipe_id' => $equipe->id,
                'funcionario_id' => $funcionario->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Vincular usuário à equipe (via equipe_membros)
        $jaMembro = DB::table('equipe_membros')
            ->where('equipe_id', $equipe->id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$jaMembro) {
            DB::table('equipe_membros')->insert([
                'equipe_id' => $equipe->id,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Usuário funcionário criado com sucesso!');
        $this->command->info('Email: funcionario@vertexsemagri.com');
        $this->command->info('Senha: funcionario123');
        $this->command->info('Equipe: ' . $equipe->nome);
    }
}
