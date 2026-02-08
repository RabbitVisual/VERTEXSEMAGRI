<?php

namespace Modules\Materiais\App\Mail;

use Modules\Materiais\App\Models\Material;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MaterialEstoqueBaixo extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $material;
    public $admin;

    /**
     * Create a new message instance.
     */
    public function __construct(Material $material, User $admin)
    {
        $this->material = $material->load([]);
        $this->admin = $admin;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = sprintf(
            '⚠️ Alerta: Estoque Baixo - %s | SEMAGRI',
            $this->material->nome ?? 'Material'
        );

        $detalhesUrl = route('materiais.show', $this->material->id);

        return $this->subject($subject)
                    ->view('materiais::emails.estoque-baixo')
                    ->with([
                        'material' => $this->material,
                        'admin' => $this->admin,
                        'detalhesUrl' => $detalhesUrl,
                        'appName' => config('app.name', 'SEMAGRI'),
                    ]);
    }
}

