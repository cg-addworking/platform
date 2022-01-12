<?php

namespace App\Models\Spie\Enterprise;

trait CsvLoaderCasts
{
    protected function string(&$value)
    {
        $value = ($str = trim($value)) ? $str : null;
    }

    protected function date(&$value)
    {
        $value = preg_match('#(\d{2})/(\d{2})/(\d{4})#', $str = trim($value), $matches)
            ? "{$matches[3]}-{$matches[2]}-{$matches[1]}"
            : null;
    }

    protected function boolean(&$value)
    {
        $value = ($str = trim($value)) ? $str == 'O' : null;
    }

    protected function integer(&$value)
    {
        $value = ($str = trim($value)) ? intval($str) : null;
    }

    protected function float(&$value)
    {
        $value = ($str = trim($value)) ? floatval($str) : null;
    }
}
