<?php

namespace App\Services;

class Functions
{
    public static function removeAccents(string $text): string
    {
        $search = ['á', 'é', 'í', 'ó', 'ö', 'ő', 'ú', 'ü', 'ű', 'Á', 'É', 'Í', 'Ó', 'Ö', 'Ő', 'Ú', 'Ü', 'Ű'];
        $replace = ['a', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U'];

        return str_replace($search, $replace, $text);
    }

    public static function removeSpecialChars($string) {
        // Remove all special characters except spaces
        $string = preg_replace('/[^a-zA-Z0-9áéíóöőúüűÁÉÍÓÖŐÚÜŰ\s]/', '', $string);
        return preg_replace('/\s+/', ' ', $string);
    }
}

