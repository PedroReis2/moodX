<?php

namespace App\Services;

use ColorThief\ColorThief;
use Illuminate\Support\Facades\Storage;

class ColorPaletteService
{
    public function extractFromPublicPath(string $path, int $limit = 6, float $cropPercent = 0.6): array
    {
        $fullPath = Storage::disk('public')->path($path);

        // Corta uma região central da imagem antes de analisar as cores,
        // para reduzir o peso do fundo neutro em fotos de moda centradas.
        $croppedPath = $this->createCenterCrop($fullPath, $cropPercent);

        $thief = new ColorThief(
            quality: 10,
            whiteThreshold: 240,
            alphaThreshold: 125,
            minSaturation: 0.03,
        );

        $palette = $thief->getPalette($croppedPath, $limit);

        // Apaga o ficheiro temporário do crop, já não é preciso.
        if ($croppedPath !== $fullPath) {
            @unlink($croppedPath);
        }

        $colors = [];

        foreach ($palette as $position => $color) {
            $colors[] = [
                'hex' => strtoupper($color->toHex('#')),
                'rgb' => $color->toArray(),
                'percentage' => round($color->proportion() * 100, 2),
                'position' => $position,
            ];
        }

        return $colors;
    }

    /**
     * Cria uma cópia temporária da imagem, cortada para a região central
     * (ex: 60% da largura e altura), para excluir o fundo das bordas
     * antes da extração de cor. Devolve o path original se o crop falhar.
     */
    private function createCenterCrop(string $fullPath, float $cropPercent): string
    {
        $info = @getimagesize($fullPath);
        if (!$info) {
            return $fullPath;
        }

        [$width, $height, $type] = $info;

        $source = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($fullPath),
            IMAGETYPE_PNG => @imagecreatefrompng($fullPath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($fullPath),
            default => null,
        };

        if (!$source) {
            return $fullPath;
        }

        $cropWidth = (int) round($width * $cropPercent);
        $cropHeight = (int) round($height * $cropPercent);
        $srcX = (int) round(($width - $cropWidth) / 2);
        $srcY = (int) round(($height - $cropHeight) / 2);

        $cropped = imagecreatetruecolor($cropWidth, $cropHeight);
        imagecopy($cropped, $source, 0, 0, $srcX, $srcY, $cropWidth, $cropHeight);

        $tmpPath = tempnam(sys_get_temp_dir(), 'crop_') . '.jpg';
        imagejpeg($cropped, $tmpPath, 90);

        imagedestroy($source);
        imagedestroy($cropped);

        return $tmpPath;
    }

    public function buildFinalPalette(array $dnaColors, array $projectColors, int $limit = 8): array
    {
        $weighted = [];

        // O Creative DNA influencia 30% da paleta final.
        foreach ($dnaColors as $color) {
            $this->addWeightedColor($weighted, $color, 0.30, 'dna');
        }

        // As imagens de cada projeto influenciam 70%, afinal o projeto deve ter mais peso.
        foreach ($projectColors as $color) {
            $this->addWeightedColor($weighted, $color, 0.70, 'project');
        }

        usort($weighted, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_slice(array_values($weighted), 0, $limit);
    }

    private function addWeightedColor(array &$weighted, array $color, float $weight, string $source): void
    {
        $rgb = $color['rgb'];
        $key = $this->bucketKey($rgb);

        // Dá mais peso a cores vivas/saturadas e penaliza fortemente
        // sombras muito escuras ou tons muito neutros, para a paleta final
        // refletir melhor a identidade visual e não só a área ocupada na foto.
        $vividness = $this->vividnessWeight($rgb);
        $score = ($color['percentage'] ?? 0) * $weight * $vividness;

        if (!isset($weighted[$key])) {
            $weighted[$key] = [
                'hex' => $color['hex'],
                'rgb' => $rgb,
                'score' => 0,
                'sources' => [],
            ];
        }

        // Somar cores parecidas no mesmo grupo para evitar paletas repetidas.
        $weighted[$key]['score'] = round($weighted[$key]['score'] + $score, 2);
        $weighted[$key]['sources'][] = $source;
        $weighted[$key]['sources'] = array_values(array_unique($weighted[$key]['sources']));
    }

    /**
     * Calcula um multiplicador consoante a saturação e luminosidade da cor
     * (em HSL). Cores vivas e de luminosidade média pesam muito mais;
     * pretos, brancos e cinzentos muito escuros/claros ou neutros pesam
     * bastante menos, para a paleta final não ser dominada por sombras
     * e refletir uma identidade de moda mais vibrante.
     */
    private function vividnessWeight(array $rgb): float
    {
        [$h, $s, $l] = $this->rgbToHsl($rgb[0], $rgb[1], $rgb[2]);

        // Penaliza fortemente luminosidade muito baixa (quase preto)
        // ou muito alta (quase branco).
        $lightnessFactor = 1 - abs($l - 0.5) * 1.8; // pico em l=0.5, cai depressa nas extremidades
        $lightnessFactor = max(0.15, min(1.3, $lightnessFactor));

        // Saturação baixa (cinzentos neutros) pesa bastante menos;
        // saturação alta (cores vivas) pesa bastante mais.
        $saturationFactor = 0.3 + ($s * 1.3); // varia entre 0.3 e 1.6

        return $lightnessFactor * $saturationFactor;
    }

    private function rgbToHsl(int $r, int $g, int $b): array
    {
        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $l = ($max + $min) / 2;

        if ($max === $min) {
            return [0.0, 0.0, $l]; // acromático (cinzento)
        }

        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

        $h = match ($max) {
            $r => fmod(($g - $b) / $d + ($g < $b ? 6 : 0), 6),
            $g => ($b - $r) / $d + 2,
            default => ($r - $g) / $d + 4,
        };
        $h /= 6;

        return [$h, $s, $l];
    }

    private function bucketKey(array $rgb): string
    {
        // Aproximar cores parecidas para que tons quase iguais contem como a mesma cor.
        return implode('-', array_map(
            fn($value) => (string) (round($value / 24) * 24),
            $rgb
        ));
    }
}
