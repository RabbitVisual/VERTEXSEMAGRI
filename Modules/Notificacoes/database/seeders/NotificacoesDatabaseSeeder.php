<?php

namespace Modules\Notificacoes\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notificacoes\App\Services\NotificacaoService;
use App\Models\User;

class NotificacoesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = app(NotificacaoService::class);

        // Criar notificações de demonstração para todos os usuários
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Crie usuários primeiro.');
            return;
        }

        $notificationsCreated = 0;

        foreach ($users as $user) {
            try {
                // Carregar relacionamentos necessários
                $user->load('roles');

                // Notificação de sucesso
                $dashboardUrl = null;
                if (\Illuminate\Support\Facades\Route::has('notificacoes.index')) {
                    $dashboardUrl = route('notificacoes.index');
                }

                $service->sendToUser(
                    $user->id,
                    'success',
                    'Bem-vindo ao Sistema de Notificações!',
                    'Este é um exemplo de notificação de sucesso. O sistema está funcionando perfeitamente!',
                    $dashboardUrl,
                    ['demo' => true],
                    'Notificacoes',
                    'User',
                    $user->id
                );
                $notificationsCreated++;

                // Notificação de informação
                $dashboardRoute = null;
                if ($user->hasRole('admin') && \Illuminate\Support\Facades\Route::has('admin.dashboard')) {
                    $dashboardRoute = route('admin.dashboard');
                } elseif ($user->hasRole('co-admin') && \Illuminate\Support\Facades\Route::has('co-admin.dashboard')) {
                    $dashboardRoute = route('co-admin.dashboard');
                } elseif ($user->hasRole('campo') && \Illuminate\Support\Facades\Route::has('campo.dashboard')) {
                    $dashboardRoute = route('campo.dashboard');
                } elseif ($user->hasRole('consulta') && \Illuminate\Support\Facades\Route::has('consulta.dashboard')) {
                    $dashboardRoute = route('consulta.dashboard');
                } elseif (\Illuminate\Support\Facades\Route::has('login')) {
                    $dashboardRoute = route('login');
                }

                $service->sendToUser(
                    $user->id,
                    'info',
                    'Sistema de Notificações Ativo',
                    'Você receberá notificações importantes sobre atividades do sistema aqui.',
                    $dashboardRoute,
                    ['demo' => true],
                    'Notificacoes',
                    'System',
                    null
                );
                $notificationsCreated++;

                // Notificação de aviso
                $profileRoute = null;
                if ($user->hasRole('admin') && \Illuminate\Support\Facades\Route::has('admin.profile')) {
                    $profileRoute = route('admin.profile');
                } elseif ($user->hasRole('co-admin') && \Illuminate\Support\Facades\Route::has('co-admin.profile')) {
                    $profileRoute = route('co-admin.profile');
                } elseif ($user->hasRole('campo') && \Illuminate\Support\Facades\Route::has('campo.profile.index')) {
                    $profileRoute = route('campo.profile.index');
                } elseif ($user->hasRole('consulta') && \Illuminate\Support\Facades\Route::has('consulta.profile')) {
                    $profileRoute = route('consulta.profile');
                } elseif (\Illuminate\Support\Facades\Route::has('login')) {
                    $profileRoute = route('login');
                }

                $service->sendToUser(
                    $user->id,
                    'warning',
                    'Lembrete: Atualize seu Perfil',
                    'Não se esqueça de manter suas informações de perfil atualizadas.',
                    $profileRoute,
                    ['demo' => true],
                    'Notificacoes',
                    'User',
                    $user->id
                );
                $notificationsCreated++;

                // Notificação de sistema
                $service->sendToUser(
                    $user->id,
                    'system',
                    'Manutenção Programada',
                    'O sistema passará por uma manutenção programada no próximo domingo às 2h da manhã.',
                    null,
                    ['demo' => true, 'maintenance_date' => now()->addDays(3)->format('Y-m-d H:i')],
                    'Notificacoes',
                    'System',
                    null
                );
                $notificationsCreated++;

            } catch (\Exception $e) {
                $this->command->error("Erro ao criar notificações para o usuário {$user->id} ({$user->name}): " . $e->getMessage());
                continue;
            }
        }

        $this->command->info("Notificações de demonstração criadas com sucesso!");
        $this->command->info("Total de usuários processados: {$users->count()}");
        $this->command->info("Total de notificações criadas: {$notificationsCreated}");
    }
}
