<?php

namespace Modules\Avisos\App\Services;

use Modules\Avisos\App\Models\Aviso;
use Illuminate\Support\Collection;

class AvisoService
{
    /**
     * Obter avisos ativos por posição
     */
    public function obterAvisosPorPosicao(string $posicao, int $limit = null): Collection
    {
        $query = Aviso::ativos()
            ->porPosicao($posicao)
            ->orderBy('ordem', 'asc')
            ->orderBy('destacar', 'desc')
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Obter avisos ativos por tipo
     */
    public function obterAvisosPorTipo(string $tipo, int $limit = null): Collection
    {
        $query = Aviso::ativos()
            ->porTipo($tipo)
            ->orderBy('ordem', 'asc')
            ->orderBy('destacar', 'desc')
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Obter todos os avisos ativos
     */
    public function obterTodosAvisosAtivos(): Collection
    {
        return Aviso::ativos()
            ->orderBy('ordem', 'asc')
            ->orderBy('destacar', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obter avisos agrupados por posição
     */
    public function obterAvisosAgrupadosPorPosicao(): array
    {
        $avisos = $this->obterTodosAvisosAtivos();

        return [
            'topo' => $avisos->where('posicao', 'topo')->values(),
            'meio' => $avisos->where('posicao', 'meio')->values(),
            'rodape' => $avisos->where('posicao', 'rodape')->values(),
            'flutuante' => $avisos->where('posicao', 'flutuante')->values(),
        ];
    }

    /**
     * Registrar visualização de aviso
     */
    public function registrarVisualizacao(int $avisoId): void
    {
        $aviso = Aviso::find($avisoId);
        if ($aviso) {
            $aviso->incrementarVisualizacao();
        }
    }

    /**
     * Registrar clique em aviso
     */
    public function registrarClique(int $avisoId): void
    {
        $aviso = Aviso::find($avisoId);
        if ($aviso) {
            $aviso->incrementarClique();
        }
    }
}

