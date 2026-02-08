<?php

namespace Modules\Ordens\App\Mail;

use Modules\Ordens\App\Models\OrdemServico;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdemServicoAtribuida extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ordemServico;
    public $funcionario;

    /**
     * Create a new message instance.
     */
    public function __construct(OrdemServico $ordemServico, $funcionario = null)
    {
        $this->ordemServico = $ordemServico->load(['demanda.localidade', 'equipe']);
        $this->funcionario = $funcionario;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = sprintf(
            'Nova Ordem de Serviço Atribuída - %s | SEMAGRI',
            $this->ordemServico->numero ?? 'N/A'
        );

        $detalhesUrl = route('campo.ordens.show', $this->ordemServico->id);

        return $this->subject($subject)
                    ->view('ordens::emails.ordem-atribuida')
                    ->with([
                        'ordemServico' => $this->ordemServico,
                        'funcionario' => $this->funcionario,
                        'detalhesUrl' => $detalhesUrl,
                        'appName' => config('app.name', 'SEMAGRI'),
                    ]);
    }
}

