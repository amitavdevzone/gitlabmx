<?php

namespace App\Services;

class UtilService
{
    /**
     * This is something I generated from GTP.
     */
    public static function isTextDark(string $bgColor): bool
    {
        // Remove leading # symbol if present
        $bgColor = ltrim($bgColor, '#');

        // Validate hex code format (6 characters)
        if (! preg_match('/^[0-9a-f]{6}$/i', $bgColor)) {
            throw new InvalidArgumentException('Invalid hex code format.');
        }

        // Convert hex to RGB values
        [$r, $g, $b] = sscanf($bgColor, '%2x%2x%2x');

        // Calculate luma for background and white text
        $bgLuma = 0.2126 * pow($r / 255, 2.2) + 0.7152 * pow($g / 255, 2.2) + 0.0722 * pow($b / 255, 2.2);
        $whiteLuma = 1.0;

        // Calculate contrast ratio
        $contrastRatio = ($whiteLuma + 0.05) / ($bgLuma + 0.05);

        // Choose text color based on contrast ratio threshold (4.5 for normal text)
        return $contrastRatio >= 2;
    }

    public static function timeInHours(int $mins): float
    {
        $hours = $mins / 60;

        return round($hours, 2);
    }
}
