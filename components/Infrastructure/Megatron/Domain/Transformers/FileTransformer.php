<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Illuminate\Support\Facades\Storage;

class FileTransformer implements TransformerInterface
{
    protected static $image = ''.
        'iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAAhFBMVEX////+/v4'.
        'AAAD9/f38/Pz7+/vd3d329vb4+Pi2trby8vIHBwfBwcHJycng4OCZmZmTk5Pm5u'.
        'a6urrX19eqqqqwsLDY2Njs7OwWFhaKioqkpKRVVVXIyMiVlZV9fX0SEhJpaWl1d'.
        'XU8PDwqKipOTk4fHx8cHBxtbW1bW1syMjJ6enpGRkZ2kkmYAAACxElEQVRIie1V'.
        'a3faMAyV43ewkzjOg5gQoF0La////5tsaLutDts+7Jx92D0nB2J0JV1JFgD/8U+'.
        'D4sOBARCCT3xT8YDgB+Hx22fgbzzyKEgiXemEiPzkBNnJR45UErSR7W673R4Om4'.
        'fJl8BZDMLyBIoZ4Kd9LDbFDZtddc2QZUkUGDLK6Wq/Ka7EBwkSPdFsmCiaq+WNc'.
        'CNtTsDYrTifwFCG2r9l9J7coUol5NkwCqhO1ofd8RS6L09XzsJJ5ORA0ZstiufH'.
        'neUxJkzX7B45uSaRARr67VPrsabYBUZPN1UWQPKsmNTh3VGI2QoZ3bbbpGnbpgj'.
        'Z3BQW/zhVxky1U3FYxDOGOR819p6VefWcQ9vWvXk4bLavNZKOxXMz980Ia1Hi+X'.
        'guzpU39XT5GkrSFh2deagko/nGYJupLU49G7r9EkJfATTK9T6MWEy1UjACy0U3n'.
        'WiXujMOB5tRZyqtKGHZKDROxtCcmg6cbUeQyY3sXawfX5OCYSb0r0AaBxyjgJSc'.
        'Dypel9wVQ0dY/34cKwJuQCUuXclusQTIasE4lC0zTgYtZajEiJNa7s/x2oHM6o/'.
        'dI9p0YVp8Odra+zgpfRcvf77EPF1X35g5GN33+xdvoKSuMahe8RVSTIzX3W4/6O'.
        'n4GmbDR2dqc5WZkw88tdhM0+VyPC3a1ZZ6a2sNlGZX0gd6/XKx3rNB+8pYrecof'.
        'CWtG8betKGWSmjrZ915P5JY4/xausF1QgilrLZztx/HQeAZuxuGgMYVpERt2nry'.
        'XDr7y8wosXa0HU5OqD1RXJlK0rSW73BkMyFC3fI03X4o1erAJCgo9T6EgA3haR+'.
        '4inN6lwKqNxqT0mWsFA5YKe5qIZQNxojKWvF2xBi9HwP3P02Jv1sh4X5WJJaGsP'.
        'WN8oPx9y/5rb1GoZD+Hn6L80GNcu8P4k+I3WB/EuSW4e+o/7v4BpSIInV5l4w2A'.
        'AAAAElFTkSuQmCC';

    public function transform(array $file): array
    {
        return [
            'path' => sprintf('/tmp/%s-yao-ming.png', uniqid()),
            'mime_type' => 'image/png',
            'content' => self::$image,
            'md5' => md5(self::$image),
            'size' => 909,
        ];
    }
}
