<?php

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

include_once __DIR__ . '/helpers/array.php';
include_once __DIR__ . '/helpers/date.php';
include_once __DIR__ . '/helpers/html.php';
include_once __DIR__ . '/helpers/models.php';
include_once __DIR__ . '/helpers/random.php';
include_once __DIR__ . '/helpers/string.php';

// ----------------------------------------------------------------------------
// MISCELANEOUS
// ----------------------------------------------------------------------------

if (! function_exists('collection_sum')) {
    /**
     * Get the sum of a collection's property
     *
     * @param  iterable $collection
     * @param  mixed    $offset
     * @return float
     */
    function collection_sum(iterable $collection, $offset)
    {
        $sum = 0;

        foreach ($collection as $item) {
            $sum += (float) data_get($item, $offset);
        }

        return $sum;
    }
}

if (! function_exists('is_uuid')) {
    /**
     * Checks whenever a string is a valid UUID
     *
     * @param  string  $str
     * @return boolean
     */
    function is_uuid($str): bool
    {
        return is_string($str) && Ramsey\Uuid\Uuid::isValid($str);
    }
}

if (! function_exists('is_htmlable')) {
    /**
     * Checks whenever a given object can be rendered as HTML
     *
     * @param  mixed  $object
     * @return boolean
     */
    function is_htmlable($object): bool
    {
        return $object instanceof Illuminate\Contracts\Support\Htmlable;
    }
}

if (! function_exists('float_to_money')) {
    /**
     * Convert number to money format
     *
     * @param  float $number
     * @return string
     */
    function float_to_money(float $number): string
    {
        return number_format($number, 2, '.', ' ') . ' €';
    }
}

if (! function_exists('money_to_float')) {
    /**
     * Convert money to number format
     *
     * @param  string $string
     * @return float
     */
    function money_to_float(string $string): float
    {
        return floatval(str_replace(" €", "", $string));
    }
}

if (! function_exists('format_siret')) {
    /**
     * Formats SIRET string
     *
     * @param  string $str
     * @return string
     */
    function format_siret($str): string
    {
        $str   = str_pad(preg_replace('/\s+/', '', $str), 14, '-');
        $siren = chunk_split(substr($str, 0, 9), 3, ' ');
        $nic   = substr($str, -5);

        return "{$siren} {$nic}";
    }
}

if (! function_exists('success_status')) {
    /**
     * Gets a success status for session flashing
     *
     * @param  string $message
     * @return array
     */
    function success_status(string $message = null): array
    {
        return (new Controller)->successStatus($message);
    }
}

if (! function_exists('info_status')) {
    /**
     * Gets a success status for session flashing
     *
     * @param  string $message
     * @return array
     */
    function info_status(string $message): array
    {
        return (new Controller)->infoStatus($message);
    }
}

if (! function_exists('warning_status')) {
    /**
     * Gets a success status for session flashing
     *
     * @param  string $message
     * @return array
     */
    function warning_status(string $message): array
    {
        return (new Controller)->warningStatus($message);
    }
}

if (! function_exists('error_status')) {
    /**
     * Gets a error status for session flashing
     *
     * @param  string $message
     * @return array
     */
    function error_status(string $message = null): array
    {
        return (new Controller)->errorStatus($message);
    }
}

if (! function_exists('redirect_when')) {
    /**
     * Rediects when $condition is true to $to, or back() otherwise.
     *
     * @param  bool        $condition
     * @param  string      $to
     * @param  string|null $success
     * @param  string|null $error
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect_when(bool $condition, string $to, string $success = null, string $error = null)
    {
        return (new Controller)->redirectWhen($condition, $to, $success, $error);
    }
}

if (! function_exists('transaction')) {
    /**
     * Alternative to DB::transaction helper that let you return 'false' to
     * rollback the transaction
     *
     * @param  callable $fn
     * @return mixed
     */
    function transaction(callable $fn)
    {
        try {
            DB::beginTransaction();
            $result = $fn();
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);

            // rethrow transaction exceptions so that Laravel can hande it
            if ($e instanceof Illuminate\Validation\ValidationException) {
                throw $e;
            }

            $result = false;
        }

        $result === false ? DB::rollback() : DB::commit();

        return $result;
    }
}

if (! function_exists('sensitive_data')) {
    /**
     * Replaces the string by **** if the current user is not an administrator
     *
     * @param  string $str
     * @return string
     */
    function sensitive_data($str): string
    {
        if (auth()->user()->isSupport()) {
            return $str;
        }

        return str_repeat('*', strlen($str));
    }
}

if (! function_exists('getUnreadMessagesCount')) {
    /**
     * Get a number of unread messages
     *
     * @param  App\Models\Addworking\User\User $user
     * @return integer $numberUnreadMessages
     */
    function getUnreadMessagesCount(App\Models\Addworking\User\User $user)
    {
        $chatRoomsId = null;
        $numberUnreadMessages = 0;

        foreach ($user->chatRooms as $chatRoomUser) {
            $chatRoomsId[] = $chatRoomUser->id;
        }

        if (!$chatRoomsId) {
            return $numberUnreadMessages;
        }

        $messages = App\Models\Addworking\User\ChatMessage::whereIn('chat_room_id', $chatRoomsId)
            ->where('user_id', '!=', $user->id)
            ->get();

        foreach ($messages as $message) {
            if (!$message->hasBeenReadBy($user)) {
                $numberUnreadMessages++;
            }
        }

        return $numberUnreadMessages;
    }
}

if (! function_exists('fake_auth')) {
    /**
     * Fakes authentication using new random user with the given roles
     *
     * @param string|object $user
     * @return void
     */
    function fake_auth($user = null)
    {
        auth()->setUser($user = user($user) ?: factory(user())->create());

        return $user;
    }
}

if (! function_exists('subdomain')) {
    /**
     * Return true if the current subdomain matches $domain. Or the current
     * subdomain if $domain is null.
     *
     * @param  string|array $domain
     * @return string|bool
     */
    function subdomain($domain = null)
    {
        if (is_null($domain)) {
            return config('app.subdomain');
        }

        return is_array($domain)
            ? in_array(subdomain(), $domain)
            : $domain == subdomain();
    }
}

if (! function_exists('find_closest')) {


    function find_closest($array, $search)
    {
        $search_ngram = ngram(strtolower($search));

        foreach ($array as $display_name => $localisation_ngram) {
            $search_ngram_localisations[$display_name] = count(array_intersect($search_ngram, $localisation_ngram));
        }

        asort($search_ngram_localisations);
        $search_ngram_localisations = array_flip($search_ngram_localisations);
        return end($search_ngram_localisations);
    }
}

if (! function_exists('explode_trim')) {
    /**
     * Split a string by string, and trim each element after applying $callback on it
     */
    function explode_trim(string $delimiter, string $haystack, callable $callback): array
    {
        $toLower = function ($item) use ($callback) {
            return $callback(trim($item));
        };

        return array_unique(array_map($toLower, explode($delimiter, $haystack)));
    }
}

if (! function_exists('domain_route')) {
    /**
     * Returns the right route for the enterprise domain
     *
     * @param  string $route
     * @param  Enterprise $enterprise
     * @return string
     */
    function domain_route(string $route, Enterprise $enterprise)
    {
        if (! App::environment('production')) {
            return $route;
        }
        
        switch (true) {
            case $enterprise->isPartofSogetrelDomain():
                return str_replace('app', 'sogetrel', $route);
            case $enterprise->isPartofEverialDomain():
                return str_replace('app', 'everial', $route);
            case $enterprise->isPartofEdenredDomain():
                return str_replace('app', 'edenred', $route);
            default:
                return $route;
        }
    }
}

//$model_finder = new \Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder(new Filesystem(), new Cache());