<?php

namespace Modules\Pocos\App\Http\Controllers\LiderComunidade;

use App\Http\Controllers\Controller;
use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Services\PixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PixController extends Controller
{
    protected $pixService;

    public function __construct(PixService $pixService)
    {
        $this->pixService = $pixService;
    }

    /**
     * Exibir formulário de cadastro/edição de chave PIX
     */
    public function edit()
    {
        $lider = Auth::user()->liderComunidade;
        
        if (!$lider) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Líder de comunidade não encontrado.');
        }

        return view('pocos::lider-comunidade.pix.edit', compact('lider'));
    }

    /**
     * Atualizar chave PIX do líder
     */
    public function update(Request $request)
    {
        $lider = Auth::user()->liderComunidade;
        
        if (!$lider) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Líder de comunidade não encontrado.');
        }

        $validated = $request->validate([
            'chave_pix' => 'required|string|max:255',
            'tipo_chave_pix' => 'required|in:cpf,cnpj,email,telefone,aleatoria',
        ]);

        // Validar chave PIX
        if (!$this->pixService->validarChavePix($validated['chave_pix'], $validated['tipo_chave_pix'])) {
            return back()->withErrors(['chave_pix' => 'Chave PIX inválida para o tipo selecionado.'])->withInput();
        }

        $lider->update([
            'chave_pix' => $validated['chave_pix'],
            'tipo_chave_pix' => $validated['tipo_chave_pix'],
            'pix_ativo' => true,
        ]);

        return redirect()->route('lider-comunidade.pix.edit')
            ->with('success', 'Chave PIX cadastrada com sucesso!');
    }

    /**
     * Desativar chave PIX
     */
    public function desativar()
    {
        $lider = Auth::user()->liderComunidade;
        
        if (!$lider) {
            return redirect()->route('lider-comunidade.dashboard')
                ->with('error', 'Líder de comunidade não encontrado.');
        }

        $lider->update(['pix_ativo' => false]);

        return redirect()->route('lider-comunidade.pix.edit')
            ->with('success', 'Chave PIX desativada com sucesso!');
    }
}

