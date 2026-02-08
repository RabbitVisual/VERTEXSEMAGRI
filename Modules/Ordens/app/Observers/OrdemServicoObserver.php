<?php

namespace Modules\Ordens\App\Observers;

use Modules\Ordens\App\Models\OrdemServico;
use Modules\Ordens\App\Mail\OrdemServicoAtribuida;
use Modules\Notificacoes\App\Services\NotificacaoService;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrdemServicoObserver
{
    protected $notificacaoService;

    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    /**
     * Handle the OrdemServico "created" event.
     */
    public function created(OrdemServico $ordemServico): void
    {
        // Notificar equipe se ordem foi atribuída a uma equipe
        if ($ordemServico->equipe_id) {
            $equipe = $ordemServico->equipe;
            if ($equipe) {
                // Notificar líder da equipe se houver
                if ($equipe->lider_id) {
                    $lider = User::find($equipe->lider_id);
                    if ($lider) {
                        $this->notificacaoService->sendFromModule(
                            'Equipes',
                            'alert',
                            'Nova Ordem de Serviço para sua Equipe',
                            "Uma nova ordem de serviço #{$ordemServico->numero} foi atribuída à sua equipe '{$equipe->nome}'.",
                            $lider,
                            route('campo.ordens.show', $ordemServico->id),
                            [
                                'ordem_id' => $ordemServico->id,
                                'numero' => $ordemServico->numero,
                                'equipe_id' => $equipe->id,
                                'equipe_nome' => $equipe->nome,
                                'prioridade' => $ordemServico->prioridade,
                            ],
                            OrdemServico::class,
                            $ordemServico->id
                        );
                    }
                }

                // Notificar todos os funcionários da equipe que têm usuário no sistema
                foreach ($equipe->funcionarios as $funcionario) {
                    if ($funcionario->email) {
                        $user = User::where('email', $funcionario->email)->first();
                        if ($user && (!$equipe->lider_id || $user->id !== $equipe->lider_id)) {
                            $this->notificacaoService->sendFromModule(
                                'Equipes',
                                'info',
                                'Nova Ordem de Serviço para sua Equipe',
                                "Uma nova ordem de serviço #{$ordemServico->numero} foi atribuída à sua equipe '{$equipe->nome}'.",
                                $user,
                                route('campo.ordens.show', $ordemServico->id),
                                [
                                    'ordem_id' => $ordemServico->id,
                                    'numero' => $ordemServico->numero,
                                    'equipe_id' => $equipe->id,
                                    'equipe_nome' => $equipe->nome,
                                ],
                                OrdemServico::class,
                                $ordemServico->id
                            );
                        }
                    }
                }
            }
        }

        // Notificar funcionário se ordem foi atribuída
        if ($ordemServico->funcionario_id) {
            $funcionario = $ordemServico->funcionario;
            if ($funcionario && $funcionario->email) {
                $user = User::where('email', $funcionario->email)->first();
                if ($user) {
                    // Notificação no sistema
                    $this->notificacaoService->sendFromModule(
                        'Ordens',
                        'alert',
                        'Nova Ordem de Serviço Atribuída',
                        "Uma nova ordem de serviço #{$ordemServico->numero} foi atribuída a você.",
                        $user,
                        route('campo.ordens.show', $ordemServico->id),
                        [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'prioridade' => $ordemServico->prioridade,
                        ],
                        OrdemServico::class,
                        $ordemServico->id
                    );

                    // Enviar email
                    try {
                        Mail::to($funcionario->email)
                            ->send(new OrdemServicoAtribuida($ordemServico, $funcionario));
                        Log::info('Email de ordem de serviço enviado para funcionário', [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'email' => $funcionario->email,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Erro ao enviar email de ordem de serviço para funcionário', [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'email' => $funcionario->email,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }
        }

        // Notificar usuário atribuído se houver
        if ($ordemServico->user_id_atribuido) {
            $user = User::find($ordemServico->user_id_atribuido);
            if ($user && $user->email) {
                // Notificação no sistema
                $this->notificacaoService->sendFromModule(
                    'Ordens',
                    'alert',
                    'Nova Ordem de Serviço Atribuída',
                    "Uma nova ordem de serviço #{$ordemServico->numero} foi atribuída a você.",
                    $user,
                    route('campo.ordens.show', $ordemServico->id),
                    [
                        'ordem_id' => $ordemServico->id,
                        'numero' => $ordemServico->numero,
                        'prioridade' => $ordemServico->prioridade,
                    ],
                    OrdemServico::class,
                    $ordemServico->id
                );

                // Enviar email
                try {
                    Mail::to($user->email)
                        ->send(new OrdemServicoAtribuida($ordemServico));
                    Log::info('Email de ordem de serviço enviado para usuário', [
                        'ordem_id' => $ordemServico->id,
                        'numero' => $ordemServico->numero,
                        'email' => $user->email,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erro ao enviar email de ordem de serviço para usuário', [
                        'ordem_id' => $ordemServico->id,
                        'numero' => $ordemServico->numero,
                        'email' => $user->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    /**
     * Handle the OrdemServico "updated" event.
     */
    public function updated(OrdemServico $ordemServico): void
    {
        // Verificar se equipe foi atribuída ou alterada
        if ($ordemServico->wasChanged('equipe_id') && $ordemServico->equipe_id) {
            $equipe = $ordemServico->equipe;
            if ($equipe) {
                // Notificar líder da equipe se houver
                if ($equipe->lider_id) {
                    $lider = User::find($equipe->lider_id);
                    if ($lider) {
                        $this->notificacaoService->sendFromModule(
                            'Equipes',
                            'alert',
                            'Equipe Atribuída a Ordem de Serviço',
                            "Sua equipe '{$equipe->nome}' foi atribuída à ordem de serviço #{$ordemServico->numero}.",
                            $lider,
                            route('campo.ordens.show', $ordemServico->id),
                            [
                                'ordem_id' => $ordemServico->id,
                                'numero' => $ordemServico->numero,
                                'equipe_id' => $equipe->id,
                                'equipe_nome' => $equipe->nome,
                                'prioridade' => $ordemServico->prioridade,
                            ],
                            OrdemServico::class,
                            $ordemServico->id
                        );
                    }
                }

                // Notificar todos os funcionários da equipe que têm usuário no sistema
                foreach ($equipe->funcionarios as $funcionario) {
                    if ($funcionario->email) {
                        $user = User::where('email', $funcionario->email)->first();
                        if ($user && (!$equipe->lider_id || $user->id !== $equipe->lider_id)) {
                            $this->notificacaoService->sendFromModule(
                                'Equipes',
                                'info',
                                'Ordem de Serviço para sua Equipe',
                                "Uma ordem de serviço #{$ordemServico->numero} foi atribuída à sua equipe '{$equipe->nome}'.",
                                $user,
                                route('campo.ordens.show', $ordemServico->id),
                                [
                                    'ordem_id' => $ordemServico->id,
                                    'numero' => $ordemServico->numero,
                                    'equipe_id' => $equipe->id,
                                    'equipe_nome' => $equipe->nome,
                                ],
                                OrdemServico::class,
                                $ordemServico->id
                            );
                        }
                    }
                }
            }
        }

        // Verificar se foi atribuída a um funcionário
        if ($ordemServico->wasChanged('funcionario_id') && $ordemServico->funcionario_id) {
            $funcionario = $ordemServico->funcionario;
            if ($funcionario && $funcionario->email) {
                $user = User::where('email', $funcionario->email)->first();
                if ($user) {
                    // Notificação no sistema
                    $this->notificacaoService->sendFromModule(
                        'Ordens',
                        'alert',
                        'Ordem de Serviço Atribuída',
                        "A ordem de serviço #{$ordemServico->numero} foi atribuída a você.",
                        $user,
                        route('campo.ordens.show', $ordemServico->id),
                        [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'prioridade' => $ordemServico->prioridade,
                        ],
                        OrdemServico::class,
                        $ordemServico->id
                    );

                    // Enviar email
                    try {
                        Mail::to($funcionario->email)
                            ->send(new OrdemServicoAtribuida($ordemServico, $funcionario));
                        Log::info('Email de ordem de serviço enviado para funcionário (atualização)', [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'email' => $funcionario->email,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Erro ao enviar email de ordem de serviço para funcionário (atualização)', [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'email' => $funcionario->email,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }
        }

        // Verificar se foi atribuída a um usuário
        if ($ordemServico->wasChanged('user_id_atribuido') && $ordemServico->user_id_atribuido) {
            $user = User::find($ordemServico->user_id_atribuido);
            if ($user && $user->email) {
                // Notificação no sistema
                $this->notificacaoService->sendFromModule(
                    'Ordens',
                    'alert',
                    'Ordem de Serviço Atribuída',
                    "A ordem de serviço #{$ordemServico->numero} foi atribuída a você.",
                    $user,
                    route('campo.ordens.show', $ordemServico->id),
                    [
                        'ordem_id' => $ordemServico->id,
                        'numero' => $ordemServico->numero,
                        'prioridade' => $ordemServico->prioridade,
                    ],
                    OrdemServico::class,
                    $ordemServico->id
                );

                // Enviar email
                try {
                    Mail::to($user->email)
                        ->send(new OrdemServicoAtribuida($ordemServico));
                    Log::info('Email de ordem de serviço enviado para usuário (atualização)', [
                        'ordem_id' => $ordemServico->id,
                        'numero' => $ordemServico->numero,
                        'email' => $user->email,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erro ao enviar email de ordem de serviço para usuário (atualização)', [
                        'ordem_id' => $ordemServico->id,
                        'numero' => $ordemServico->numero,
                        'email' => $user->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        // Notificar supervisor quando ordem é concluída
        if ($ordemServico->wasChanged('status') && $ordemServico->status === 'concluida') {
            // Notificar o usuário que abriu a ordem (geralmente supervisor/admin)
            if ($ordemServico->user_id_abertura) {
                $supervisor = User::find($ordemServico->user_id_abertura);
                if ($supervisor) {
                    $executor = $ordemServico->usuarioExecucao ? $ordemServico->usuarioExecucao->name : 'Funcionário';

                    $this->notificacaoService->sendFromModule(
                        'Ordens',
                        'success',
                        'Ordem de Serviço Concluída',
                        "A ordem de serviço #{$ordemServico->numero} foi concluída por {$executor}.",
                        $supervisor,
                        route('ordens.show', $ordemServico->id),
                        [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'executor' => $executor,
                        ],
                        OrdemServico::class,
                        $ordemServico->id
                    );
                }
            }

            // Notificar líder da equipe se houver
            if ($ordemServico->equipe_id && $ordemServico->equipe && $ordemServico->equipe->lider_id) {
                $lider = User::find($ordemServico->equipe->lider_id);
                if ($lider && $lider->id !== $ordemServico->user_id_abertura) {
                    $executor = $ordemServico->usuarioExecucao ? $ordemServico->usuarioExecucao->name : 'Funcionário';

                    $this->notificacaoService->sendFromModule(
                        'Ordens',
                        'success',
                        'Ordem de Serviço Concluída',
                        "A ordem de serviço #{$ordemServico->numero} da sua equipe foi concluída por {$executor}.",
                        $lider,
                        route('ordens.show', $ordemServico->id),
                        [
                            'ordem_id' => $ordemServico->id,
                            'numero' => $ordemServico->numero,
                            'executor' => $executor,
                        ],
                        OrdemServico::class,
                        $ordemServico->id
                    );
                }
            }
        }
    }
}

