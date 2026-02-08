<?php

namespace Modules\Demandas\App\Observers;

use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Mail\DemandaStatusChanged;
use Modules\Demandas\App\Mail\DemandaCriada;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DemandaObserver
{
    /**
     * Handle the Demanda "created" event.
     */
    public function created(Demanda $demanda): void
    {
        // Enviar email de confirmação de criação se há email cadastrado
        // Isso garante que o email seja enviado mesmo se a demanda for criada via outros métodos
        if ($demanda->solicitante_email && $demanda->codigo) {
            try {
                // Carregar relacionamentos necessários
                if (!$demanda->relationLoaded('localidade')) {
                    $demanda->load('localidade');
                }
                if (!$demanda->relationLoaded('pessoa')) {
                    $demanda->load('pessoa');
                }

                // Validar email antes de enviar
                if (!filter_var($demanda->solicitante_email, FILTER_VALIDATE_EMAIL)) {
                    Log::warning('Email inválido para demanda', [
                        'demanda_id' => $demanda->id,
                        'codigo' => $demanda->codigo,
                        'email' => $demanda->solicitante_email,
                    ]);
                    return;
                }

                // Enviar email de forma síncrona (não usar fila)
                Mail::to($demanda->solicitante_email)
                    ->send(new DemandaCriada($demanda));

                Log::info('Email de confirmação de demanda enviado com sucesso via Observer', [
                    'demanda_id' => $demanda->id,
                    'codigo' => $demanda->codigo,
                    'email' => $demanda->solicitante_email,
                    'timestamp' => now()->toDateTimeString(),
                ]);
            } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface | \Swift_TransportException $e) {
                // Erro de transporte (SMTP, conexão, etc)
                Log::error('Erro de transporte ao enviar email de confirmação de demanda', [
                    'demanda_id' => $demanda->id,
                    'codigo' => $demanda->codigo,
                    'email' => $demanda->solicitante_email,
                    'error' => $e->getMessage(),
                    'error_code' => method_exists($e, 'getCode') ? $e->getCode() : 0,
                ]);
            } catch (\Exception $e) {
                // Outros erros
                Log::error('Erro ao enviar email de confirmação de demanda via Observer', [
                    'demanda_id' => $demanda->id,
                    'codigo' => $demanda->codigo,
                    'email' => $demanda->solicitante_email,
                    'error' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        } else {
            if (!$demanda->solicitante_email) {
                Log::warning('Demanda criada sem email do solicitante', [
                    'demanda_id' => $demanda->id,
                    'codigo' => $demanda->codigo,
                    'solicitante' => $demanda->solicitante_nome,
                ]);
            }
            if (!$demanda->codigo) {
                Log::warning('Demanda criada sem código', [
                    'demanda_id' => $demanda->id,
                    'solicitante' => $demanda->solicitante_nome,
                ]);
            }
        }
    }

    /**
     * Handle the Demanda "updated" event.
     */
    public function updated(Demanda $demanda): void
    {
        // Verificar se o status mudou
        if ($demanda->wasChanged('status') && $demanda->solicitante_email) {
            $oldStatus = $demanda->getOriginal('status');

            try {
                Mail::to($demanda->solicitante_email)
                    ->send(new DemandaStatusChanged($demanda, $oldStatus));
            } catch (\Exception $e) {
                Log::error('Erro ao enviar email de notificação de demanda: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Demanda "deleted" event.
     */
    public function deleted(Demanda $demanda): void
    {
        //
    }

    /**
     * Handle the Demanda "restored" event.
     */
    public function restored(Demanda $demanda): void
    {
        //
    }

    /**
     * Handle the Demanda "force deleted" event.
     */
    public function forceDeleted(Demanda $demanda): void
    {
        //
    }
}

