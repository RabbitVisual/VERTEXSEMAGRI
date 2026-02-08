<?php

namespace Modules\Demandas\App\Mail;

use Modules\Demandas\App\Models\Demanda;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandaCriada extends Mailable
{
    use Queueable, SerializesModels;

    public $demanda;

    /**
     * Create a new message instance.
     */
    public function __construct(Demanda $demanda)
    {
        $this->demanda = $demanda->load(['localidade', 'pessoa']);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = sprintf(
            'Demanda Registrada - Protocolo: %s | SEMAGRI',
            $this->demanda->codigo ?? 'N/A'
        );

        $consultaUrl = route('demandas.public.show', ['codigo' => $this->demanda->codigo]);

        return $this->subject($subject)
                    ->from(config('mail.from.address', 'contato@semagricm.com'), config('mail.from.name', 'SEMAGRI'))
                    ->replyTo(config('mail.from.address', 'contato@semagricm.com'), config('mail.from.name', 'SEMAGRI'))
                    ->view('demandas::emails.demanda-criada')
                    ->with([
                        'demanda' => $this->demanda,
                        'consultaUrl' => $consultaUrl,
                        'appName' => config('app.name', 'SEMAGRI'),
                    ])
                    ->priority(1); // Alta prioridade
    }
}

