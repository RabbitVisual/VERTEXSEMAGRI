<?php

namespace Modules\Avisos\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Avisos\App\Services\AvisoService;
use Modules\Avisos\App\Models\Aviso;

class AvisosPublicController extends Controller
{
    protected AvisoService $avisoService;

    public function __construct(AvisoService $avisoService)
    {
        $this->avisoService = $avisoService;
    }

    /**
     * Obter avisos por posição (API)
     */
    public function obterPorPosicao(string $posicao)
    {
        $avisos = $this->avisoService->obterAvisosPorPosicao($posicao);

        return response()->json([
            'success' => true,
            'data' => $avisos->map(function ($aviso) {
                return [
                    'id' => $aviso->id,
                    'titulo' => $aviso->titulo,
                    'descricao' => $aviso->descricao,
                    'conteudo' => $aviso->conteudo,
                    'tipo' => $aviso->tipo,
                    'posicao' => $aviso->posicao,
                    'estilo' => $aviso->estilo,
                    'cor_primaria' => $aviso->cor_primaria_padrao,
                    'cor_secundaria' => $aviso->cor_secundaria_padrao,
                    'imagem' => $aviso->imagem ? asset('storage/' . $aviso->imagem) : null,
                    'url_acao' => $aviso->url_acao,
                    'texto_botao' => $aviso->texto_botao,
                    'botao_exibir' => $aviso->botao_exibir,
                    'dismissivel' => $aviso->dismissivel,
                    'destacar' => $aviso->destacar,
                ];
            }),
        ]);
    }

    /**
     * Registrar visualização
     */
    public function registrarVisualizacao(Request $request, int $id)
    {
        $this->avisoService->registrarVisualizacao($id);

        return response()->json([
            'success' => true,
            'message' => 'Visualização registrada',
        ]);
    }

    /**
     * Registrar clique
     */
    public function registrarClique(Request $request, int $id)
    {
        $this->avisoService->registrarClique($id);

        return response()->json([
            'success' => true,
            'message' => 'Clique registrado',
        ]);
    }
}

