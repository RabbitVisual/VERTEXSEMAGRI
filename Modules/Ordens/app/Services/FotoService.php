<?php

namespace Modules\Ordens\App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FotoService
{
    const MAX_FILE_SIZE = 5120; // 5MB em KB
    const ALLOWED_MIMES = ['image/jpeg', 'image/jpg', 'image/png'];
    const MAX_WIDTH = 1920;
    const MAX_HEIGHT = 1920;
    const QUALITY = 85;

    /**
     * Faz upload de múltiplas fotos para uma ordem de serviço
     *
     * @param array $fotos Array de UploadedFile
     * @param int $ordemId ID da ordem de serviço
     * @param string $tipo Tipo: 'antes' ou 'depois'
     * @return array Array com os paths das fotos salvas
     */
    public function uploadFotos(array $fotos, int $ordemId, string $tipo = 'antes'): array
    {
        $paths = [];
        $basePath = "ordens/{$ordemId}/{$tipo}";

        foreach ($fotos as $foto) {
            if (!$foto instanceof UploadedFile) {
                continue;
            }

            // Validar foto
            if (!$this->validarFoto($foto)) {
                continue;
            }

            // Gerar nome único
            $nomeArquivo = $this->gerarNomeUnico($foto);

            // Fazer upload e processar
            $path = $foto->storeAs($basePath, $nomeArquivo, 'public');

            // Redimensionar se necessário
            $this->redimensionarFoto($path);

            $paths[] = $path;
        }

        return $paths;
    }

    /**
     * Valida uma foto antes do upload
     *
     * @param UploadedFile $foto
     * @return bool
     */
    public function validarFoto(UploadedFile $foto): bool
    {
        // Validar tamanho (máximo 5MB)
        if ($foto->getSize() > (self::MAX_FILE_SIZE * 1024)) {
            return false;
        }

        // Validar tipo MIME
        if (!in_array($foto->getMimeType(), self::ALLOWED_MIMES)) {
            return false;
        }

        // Validar extensão
        $extensao = strtolower($foto->getClientOriginalExtension());
        if (!in_array($extensao, ['jpg', 'jpeg', 'png'])) {
            return false;
        }

        return true;
    }

    /**
     * Gera um nome único para o arquivo
     *
     * @param UploadedFile $foto
     * @return string
     */
    private function gerarNomeUnico(UploadedFile $foto): string
    {
        $extensao = strtolower($foto->getClientOriginalExtension());
        $timestamp = now()->format('YmdHis');
        $random = str()->random(8);
        
        return "{$timestamp}_{$random}.{$extensao}";
    }

    /**
     * Redimensiona a foto se exceder os limites
     *
     * @param string $path Caminho do arquivo no storage
     * @return void
     */
    private function redimensionarFoto(string $path): void
    {
        $fullPath = Storage::disk('public')->path($path);

        if (!file_exists($fullPath)) {
            return;
        }

        try {
            // Verificar se a biblioteca Intervention Image está disponível
            if (!class_exists('\Intervention\Image\Facades\Image')) {
                // Se não estiver disponível, usar GD nativo
                $this->redimensionarComGD($fullPath);
                return;
            }

            $image = Image::make($fullPath);
            
            // Redimensionar apenas se exceder os limites
            if ($image->width() > self::MAX_WIDTH || $image->height() > self::MAX_HEIGHT) {
                $image->resize(self::MAX_WIDTH, self::MAX_HEIGHT, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $image->save($fullPath, self::QUALITY);
            }
        } catch (\Exception $e) {
            // Se houver erro, tentar com GD nativo
            $this->redimensionarComGD($fullPath);
        }
    }

    /**
     * Redimensiona usando GD nativo do PHP
     *
     * @param string $fullPath
     * @return void
     */
    private function redimensionarComGD(string $fullPath): void
    {
        $info = getimagesize($fullPath);
        if (!$info) {
            return;
        }

        list($width, $height, $type) = $info;

        // Verificar se precisa redimensionar
        if ($width <= self::MAX_WIDTH && $height <= self::MAX_HEIGHT) {
            return;
        }

        // Calcular novas dimensões mantendo proporção
        $ratio = min(self::MAX_WIDTH / $width, self::MAX_HEIGHT / $height);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        // Carregar imagem original
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($fullPath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($fullPath);
                break;
            default:
                return;
        }

        if (!$source) {
            return;
        }

        // Criar nova imagem redimensionada
        $dest = imagecreatetruecolor($newWidth, $newHeight);

        // Preservar transparência PNG
        if ($type == IMAGETYPE_PNG) {
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
        }

        // Redimensionar
        imagecopyresampled($dest, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Salvar
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($dest, $fullPath, self::QUALITY);
                break;
            case IMAGETYPE_PNG:
                imagepng($dest, $fullPath, 9);
                break;
        }

        imagedestroy($source);
        imagedestroy($dest);
    }

    /**
     * Remove fotos de uma ordem
     *
     * @param array $paths Array de paths das fotos
     * @return void
     */
    public function removerFotos(array $paths): void
    {
        foreach ($paths as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Retorna a URL pública de uma foto
     *
     * @param string $path
     * @return string
     */
    public function getUrlPublica(string $path): string
    {
        // Usar asset() para gerar URLs relativas (funciona com qualquer APP_URL)
        return asset('storage/' . $path);
    }
}

