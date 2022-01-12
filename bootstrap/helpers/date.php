<?php

use Carbon\Carbon;

// ----------------------------------------------------------------------------
// Datetime Helpers
// ----------------------------------------------------------------------------

if (! function_exists('carbon')) {
    /**
     * Get a Carbon\Carbon instance
     *
     * @param  string $date
     * @param  string $tz
     * @return Carbon\Carbon
     */
    function carbon($date = null, $tz = 'Europe/Paris')
    {
        if (!$date) {
            return Carbon::now();
        }

        return new Carbon($date, $tz);
    }
}

if (! function_exists('time_elapsed_until_now')) {
    /**
     * return time elapsed until now since date
     *
     * @param  string $date
     * @return string
     */
    function time_elapsed_until_now($date): string
    {
        try {
            $conf = Carbon::getLocale();
            Carbon::setLocale('fr');

            if (is_string($date)) {
                 $diff = date_diff(new DateTime($date), now());
            } else {
                $diff = date_diff($date, now());
            }

            $date = Carbon::now()
                ->addYears(-$diff->y)
                ->addMonth(-$diff->m)
                ->addDays(-$diff->d)
                ->addHours(-$diff->h)
                ->addMinutes(-$diff->i)
                ->addSeconds(-$diff->s)
                ->diffForHumans();
        } catch (Exception $e) {
            //
        } finally {
            Carbon::setLocale($conf);
        }

        return $date;
    }
}

if (! function_exists('month_fr')) {
    /**
     * Do you have tome to bother about locale? Me neither.
     *
     * @param  int    $num
     * @return string
     */
    function month_fr(int $num): string
    {
        static $calendar = [
            'Janvier'   , 'Fevrier' , 'Mars'     , 'Avril'    ,
            'Mai'       , 'Juin'    , 'Juillet'  , 'Aout'     ,
            'Septembre' , 'Octobre' , 'Novembre' , 'Decembre'
        ];

        if (is_string($num)) {
            $num = (int) $num;
        }

        if ($num < 1 || $num > 12) {
            return "";
        }

        return $calendar[$num - 1];
    }
}

if (! function_exists('month_de')) {
    /**
     * Do you have tome to bother about locale? Me neither.
     *
     * @param  int    $num
     * @return string
     */
    function month_de(int $num): string
    {
        static $calendar = [
            'Der Januar'   , 'Der Februar' , 'Der März'     , 'Der April'    ,
            'Der Mai'       , 'Der Juni'    , 'Der Juli'  , 'Der August'     ,
            'Der September' , 'Der Oktober' , 'Der November' , 'Der Dezember'
        ];

        if (is_string($num)) {
            $num = (int) $num;
        }

        if ($num < 1 || $num > 12) {
            return "";
        }

        return $calendar[$num - 1];
    }
}

if (! function_exists('month_boundaries')) {
    /**
     * Get the boundaries (first & last day) for given month (MM/YYYY)
     *
     * @param  string $month
     * @return array
     */
    function month_boundaries($month)
    {
        $date = Carbon::createFromFormat('m/Y', $month);
        return [$date->startOfMonth(), $date->endOfMonth()];
    }
}

if (! function_exists('is_date_fr')) {
    /**
     * Tells whenever the given date is French format (d/m/Y).
     *
     * @param  string  $date
     * @return boolean
     */
    function is_date_fr($date): bool
    {
        return preg_match('~\d{1,2}/\d{1,2}/\d{2,4}~', $date);
    }
}

if (! function_exists('date_fr_to_iso')) {
    /**
     * Converts french dates (dd/mm/YYYY) to iso (YYYY-mm-dd)
     *
     * @param  string $date
     * @return string
     */
    function date_fr_to_iso($date): string
    {
        if ($date instanceof DateTime) {
            return $date->format("Y-m-d");
        }

        if (!preg_match('~(\d{2})/(\d{2})/(\d{4})~', $date, $matches)) {
            return "";
        }

        return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
    }
}

if (! function_exists('date_iso_to_date_fr')) {
    /**
     * convert datetime in date fr
     *
     * @param  string $date
     * @return string
     */
    function date_iso_to_date_fr($date)
    {
        $date = new DateTime($date);
        return $date->format('d/m/Y');
    }
}
