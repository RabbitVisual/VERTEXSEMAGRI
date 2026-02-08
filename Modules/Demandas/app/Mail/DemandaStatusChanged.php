<?php

namespace Modules\Demandas\App\Mail;

use Modules\Demandas\App\Models\Demanda;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DemandaStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $demanda;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Demanda $demanda, ?string $oldStatus = null)
    {
        $this->demanda = $demanda;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $demanda->status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $statusLabels = [
            'aberta' => 'Aberta',
            'em_andamento' => 'Em Andamento',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
        ];

        $subject = sprintf(
            'Atualização na Demanda %s - Status: %s',
            $this->demanda->codigo ?? 'N/A',
            $statusLabels[$this->newStatus] ?? $this->newStatus
        );

        return $this->subject($subject)
                    ->view('demandas::emails.status-changed')
                    ->with([
                        'demanda' => $this->demanda,
                        'oldStatus' => $this->oldStatus,
                        'newStatus' => $this->newStatus,
                        'statusLabel' => $statusLabels[$this->newStatus] ?? $this->newStatus,
                        'consultaUrl' => route('demandas.public.show', ['codigo' => $this->demanda->codigo]),
                    ]);
    }
}

