<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar Permissões por Módulo
        $modulos = [
            'localidades',
            'iluminacao',
            'postes',
            'agua',
            'pocos',
            'estradas',
            'equipes',
            'materiais',
            'demandas',
            'ordens',
            'relatorios',
            'pessoas',
            'funcionarios',
            'notificacoes',
            'programasagricultura',
            'caf',
            'lider-comunidade',
        ];

        $acoes = ['view', 'create', 'edit', 'delete', 'approve'];

        foreach ($modulos as $modulo) {
            foreach ($acoes as $acao) {
                Permission::firstOrCreate(['name' => "{$modulo}.{$acao}"]);
            }
        }

        // Permissões especiais
        Permission::firstOrCreate(['name' => 'admin.*']);
        Permission::firstOrCreate(['name' => 'usuarios.manage']);
        Permission::firstOrCreate(['name' => 'sistema.config']);

        // Permissões adicionais para consulta
        Permission::firstOrCreate(['name' => 'homepage.view']);
        Permission::firstOrCreate(['name' => 'carousel.view']);
        Permission::firstOrCreate(['name' => 'admin.dashboard.view']);
        Permission::firstOrCreate(['name' => 'audit.view']);

        // Permissões específicas para líder comunitário
        $permissionsLiderComunidade = [
            'lider-comunidade.dashboard.view',
            'lider-comunidade.usuarios.view',
            'lider-comunidade.usuarios.create',
            'lider-comunidade.usuarios.edit',
            'lider-comunidade.usuarios.delete',
            'lider-comunidade.mensalidades.view',
            'lider-comunidade.mensalidades.create',
            'lider-comunidade.mensalidades.edit',
            'lider-comunidade.pagamentos.view',
            'lider-comunidade.pagamentos.create',
            'lider-comunidade.pagamentos.edit',
            'lider-comunidade.pagamentos.delete',
            'lider-comunidade.relatorios.view',
            'pocos.view',
            'pessoas.view',
        ];

        foreach ($permissionsLiderComunidade as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Criar Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $coAdmin = Role::firstOrCreate(['name' => 'co-admin']);
        $campo = Role::firstOrCreate(['name' => 'campo']);
        $consulta = Role::firstOrCreate(['name' => 'consulta']);
        $liderComunidade = Role::firstOrCreate(['name' => 'lider-comunidade']);

        // Admin - Todas as permissões
        $admin->syncPermissions(Permission::all());

        // Co-Admin - Acesso a relatórios e aprovações
        $permissionsCoAdmin = [
            'localidades.view',
            'localidades.create',
            'localidades.edit',
            'iluminacao.view',
            'agua.view',
            'pocos.view',
            'estradas.view',
            'equipes.view',
            'materiais.view',
            'materiais.create',
            'materiais.edit',
            'demandas.view',
            'demandas.approve',
            'ordens.view',
            'ordens.approve',
            'relatorios.view',
            'relatorios.create',
        ];
        // Filtrar apenas permissões que existem
        $permissionsCoAdmin = Permission::whereIn('name', $permissionsCoAdmin)->pluck('name')->toArray();
        $coAdmin->syncPermissions($permissionsCoAdmin);

        // Campo - Apenas visualização e execução
        $permissionsCampo = [
            'ordens.view',
            'ordens.edit', // Para atualizar status e relatório
            'materiais.view',
        ];
        // Filtrar apenas permissões que existem
        $permissionsCampo = Permission::whereIn('name', $permissionsCampo)->pluck('name')->toArray();
        $campo->syncPermissions($permissionsCampo);

        // Consulta - Apenas visualização (somente leitura)
        $permissionsForConsulta = [];
        foreach ($modulos as $modulo) {
            $permissionsForConsulta[] = "{$modulo}.view";
        }
        // Adicionar permissões de visualização para homepage, carousel, dashboard admin e audit logs
        $permissionsForConsulta[] = 'homepage.view';
        $permissionsForConsulta[] = 'carousel.view';
        $permissionsForConsulta[] = 'admin.dashboard.view';
        $permissionsForConsulta[] = 'audit.view';

        // Filtrar apenas permissões que existem
        $permissionsForConsulta = Permission::whereIn('name', $permissionsForConsulta)->pluck('name')->toArray();
        $consulta->syncPermissions($permissionsForConsulta);

        // Líder de Comunidade - Permissões específicas para gerenciar poços
        $permissionsForLiderComunidade = Permission::whereIn('name', $permissionsLiderComunidade)->pluck('name')->toArray();
        $liderComunidade->syncPermissions($permissionsForLiderComunidade);

        // Criar usuário admin padrão
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@vertexsemagri.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('admin123'),
                'active' => true,
            ]
        );
        $userAdmin->assignRole('admin');

        // Criar usuário co-admin de exemplo
        $userCoAdmin = User::firstOrCreate(
            ['email' => 'coadmin@vertexsemagri.com'],
            [
                'name' => 'Co-Administrador',
                'password' => bcrypt('coadmin123'),
                'active' => true,
            ]
        );
        $userCoAdmin->assignRole('co-admin');

        // Criar usuário consulta de exemplo
        $userConsulta = User::firstOrCreate(
            ['email' => 'consulta@vertexsemagri.com'],
            [
                'name' => 'Usuário Consulta',
                'password' => bcrypt('consulta123'),
                'active' => true,
            ]
        );
        $userConsulta->assignRole('consulta');
    }
}
