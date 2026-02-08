<?php

namespace Modules\Demandas\App\Services;

use Modules\Demandas\App\Models\Demanda;

class QrCodeService
{
    /**
     * Gera a URL pública para consulta da demanda
     */
    public static function getConsultaUrl(Demanda $demanda): string
    {
        return route('demandas.public.show', ['codigo' => $demanda->codigo]);
    }

    /**
     * Gera os dados para o QR Code (URL completa)
     */
    public static function getQrCodeData(Demanda $demanda): string
    {
        return self::getConsultaUrl($demanda);
    }
}

