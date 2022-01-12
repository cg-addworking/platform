<?php

namespace Components\Connector\Mindee\Application\Data;

use Carbon\Carbon;

class DocumentData
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    protected function getData($data_name)
    {
        if (array_key_exists($data_name, $this->data)) {
            return $this->data[$data_name];
        }
        return null;
    }

    protected function getDate($data_name): ?Carbon
    {
        $date = $this->getData($data_name);
        if (!is_null($date) && $date !== "") {
            return Carbon::createFromFormat(
                'Y-m-d',
                $date
            );
        }
        return null;
    }
}
