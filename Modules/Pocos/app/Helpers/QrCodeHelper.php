<?php

namespace Modules\Pocos\App\Helpers;

use Illuminate\Support\Facades\Log;

class QrCodeHelper
{
    /**
     * Gera QR Code como Data URL (base64) usando API pública
     * @param string $text Texto para codificar
     * @param int $size Tamanho da imagem (padrão: 200)
     * @return string Data URL da imagem do QR Code
     */
    public static function generateDataUrl(string $text, int $size = 200): string
    {
        if (empty($text)) {
            Log::warning('QR Code: texto vazio');
            return self::getEmptyImage();
        }
        
        $encodedText = urlencode($text);
        
        // Tentar múltiplas APIs para garantir que funcione
        $apis = [
            "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encodedText}&format=png&ecc=M",
            "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl={$encodedText}",
        ];
        
        foreach ($apis as $url) {
            $imageData = self::fetchImage($url);
            
            if ($imageData && strlen($imageData) > 100) {
                // Verificar se é uma imagem PNG válida (começa com PNG signature)
                if (substr($imageData, 0, 8) === "\x89PNG\r\n\x1a\n" || strpos($imageData, 'PNG') !== false) {
                    $base64 = base64_encode($imageData);
                    return 'data:image/png;base64,' . $base64;
                }
            }
        }
        
        Log::warning('QR Code não pôde ser gerado após tentar todas as APIs', [
            'text_length' => strlen($text),
            'text_preview' => substr($text, 0, 20)
        ]);
        
        return self::getEmptyImage();
    }
    
    /**
     * Busca imagem de uma URL
     */
    private static function fetchImage(string $url): ?string
    {
        if (!function_exists('curl_init')) {
            // Fallback para file_get_contents se cURL não estiver disponível
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'follow_location' => true,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            return @file_get_contents($url, false, $context) ?: null;
        }
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: image/png,image/*;q=0.8,*/*;q=0.5',
            ],
        ]);
        
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($imageData === false || $httpCode !== 200 || empty($imageData)) {
            return null;
        }
        
        return $imageData;
    }
    
    /**
     * Retorna uma imagem vazia 1x1px em base64
     */
    private static function getEmptyImage(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
    }
    
    /**
     * Gera URL da imagem do QR Code
     * @param string $text Texto para codificar
     * @param int $size Tamanho da imagem (padrão: 200)
     * @return string URL da imagem do QR Code
     */
    public static function generateUrl(string $text, int $size = 200): string
    {
        $encodedText = urlencode($text);
        return "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl={$encodedText}";
    }
}

