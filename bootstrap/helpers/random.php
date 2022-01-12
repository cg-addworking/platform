<?php

// ----------------------------------------------------------------------------
// Random Helpers
// ----------------------------------------------------------------------------

if (! function_exists('random_float')) {
    /**
     * Get a random float number between $min and $max
     *
     * @param  integer $min
     * @param  integer  $max
     * @return float
     */
    function random_float($min = 0, $max = PHP_INT_MAX): float
    {
        return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
    }
}

if (! function_exists('random_numeric_string')) {
    /**
     * Get a random string of $digits numbers
     *
     * @param  integer $digits
     * @return string
     */
    function random_numeric_string($digits = 10): string
    {
        for ($i = 0, $str = ""; $i < $digits; $i++, $str .= mt_rand(0, 9)) {
            // PSR-2
        }

        return $str;
    }
}

if (! function_exists('random_french_phone_number')) {
    /**
     * Get a random valid french phone number
     *
     * @param  boolean $mobile
     * @param  boolean $e164number
     * @return string
     */
    function random_french_phone_number($mobile = false, $e164number = false): string
    {
        $cc = $e164number ? '+33' : '0';
        $nc = mt_rand(1, 5);
        $sn = random_numeric_string(8);

        return "{$cc}{$nc}{$sn}";
    }
}
