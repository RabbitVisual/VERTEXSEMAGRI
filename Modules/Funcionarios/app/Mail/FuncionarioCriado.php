<?php

namespace Modules\Funcionarios\App\Mail;

use Modules\Funcionarios\App\Models\Funcionario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FuncionarioCriado extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $funcionario;
    public $senhaTemporaria;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Funcionario $funcionario, ?string $senhaTemporaria = null)
    {
        $this->funcionario = $funcionario;
        $this->senhaTemporaria = $senhaTemporaria;
        $this->loginUrl = route('login');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = sprintf(
            'Conta Criada - %s | SEMAGRI',
            $this->funcionario->nome ?? 'Funcionário'
        );

        return $this->subject($subject)
                    ->view('funcionarios::emails.funcionario-criado')
                    ->with([
                        'funcionario' => $this->funcionario,
                        'senhaTemporaria' => $this->senhaTemporaria,
                        'loginUrl' => $this->loginUrl,
                        'appName' => config('app.name', 'SEMAGRI'),
                    ]);
    }
}

