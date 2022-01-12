<?php

namespace Components\Infrastructure\Translation\Application\Commands\Traits;

trait SerializeTrait
{
    protected static function serialize(array $messages, int $depth = 0): string
    {
        $str = "";
        $tab = str_repeat("    ", $depth + 1);

        foreach ($messages as $key => $value) {
            if (is_scalar($value)) {
                $str .= sprintf('%s"%s" => "%s",'  . PHP_EOL, $tab, $key, self::quote($value));
                continue;
            }

            if (is_array($value)) {
                $str .= sprintf('%s"%s" => [' . PHP_EOL, $tab, $key);
                $str .= self::serialize($value, $depth + 1);
                $str .= sprintf('%s],' . PHP_EOL, $tab);
                continue;
            }

            throw new \UnexpectedValueException("illegal value for key '{$key}'");
        }

        if ($depth == 0) {
            $str = "<?php\n\nreturn [\n$str];\n";
        }

        return $str;
    }

    protected static function quote(string $message): string
    {
        $message = str_replace("\"", '\"', $message);
        $message = preg_replace("/\s+/", " ", $message);

        return $message;
    }
}
