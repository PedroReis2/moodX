<?php

namespace App\Services;

use ColorThief\ColorThief;
use ColorThief\ImageRegion;
use Illuminate\Support\Facades\Storage;

class ColorPaletteService
{
    public function extractFromPublicPath(string $path, int $limit = 6): array
    {
        // Aqui busquei o caminho real da imagem que foi guardada no disco public.
        $fullPath = Storage::disk('public')->path($path);

        // Usar uma qualidade equilibrada para ser rápido, mas ainda apanhar bem as cores principais.
        $thief = new ColorThief(
            quality: 20,
            whiteThreshold: 250,
            alphaThreshold: 125,
            minSaturation: 0.03,
        );
        [$width, $height] = getimagesize($fullPath);

        // Definiu-se que só queremos analisar o centro da imagem.
        // Isto ajuda a ignorar fundos, margens e zonas menos importantes da imagem, para dar mais peso às cores do centro.
        $centerRatio = 0.60;

        $regionWidth = (int) round($width * $centerRatio);
        $regionHeight = (int) round($height * $centerRatio);

        $x = (int) round(($width - $regionWidth) / 2);
        $y = (int) round(($height - $regionHeight) / 2);

        $region = new ImageRegion($x, $y, $regionWidth, $regionHeight);

        // Extrair as cores dominantes do centro da imagem.
        $palette = $thief->getPalette($fullPath, $limit, $region);

        $colors = [];

        foreach ($palette as $position => $color) {
            // Guardar a cor em HEX, RGB e percentagem para depois conseguir montar a paleta final.
            $colors[] = [
                'hex' => strtoupper($color->toHex('#')),
                'rgb' => $color->toArray(),
                'percentage' => round($color->proportion() * 100, 2),
                'position' => $position,
            ];
        }

        return $colors;
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
        $score = ($color['percentage'] ?? 0) * $weight;

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

    private function bucketKey(array $rgb): string
    {
        // Aproximar cores parecidas para que tons quase iguais contem como a mesma cor.
        return implode('-', array_map(
            fn($value) => (string) (round($value / 24) * 24),
            $rgb
        ));
    }
}
