<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Client;
use Illuminate\Support\Facades\Log;

class DocumentExtractor
{
    protected const CONFIDENCE_THRESHOLD = -1.0;

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $response
     * @return array
     */
    public function extract($response): array
    {
        try {
            $values = $this->getValues($response->body->document->inference->prediction);
            Log::debug(get_called_class() . ' pulled following data from Mindee : ' . json_encode($values));

            return $values;
        } catch (\Exception $e) {
            Log::error($e);
            Log::info('Document Extractor error : ' . $e->getMessage());
            return [];
        }
    }

    private function getValues($data)
    {
        $values = [];
        foreach ($data as $field_name => $data_prediction) {
            try {
                if (self::CONFIDENCE_THRESHOLD < $data_prediction->confidence) {
                    $values[$field_name] = $this->getValue($data_prediction);
                }
            } catch (\Exception $e) {
                $values[$field_name] = null;
                Log::error("DataExtractor Failed: (error message: {$e->getMessage()}");
            }
        }
        return $values;
    }

    /**
     * @param $data_prediction
     * @return mixed|string|null
     */
    private function getValue($data_prediction)
    {
        $value = null;

        if (property_exists($data_prediction, 'values')) {
            $prediction_values = $data_prediction->values;
            if (count($prediction_values) === 1) {
                $value = $data_prediction->values[0]->content;
            } elseif (count($prediction_values) > 1) {
                $value = '';
                foreach ($data_prediction->values as $prediction_value) {
                    $value .= $prediction_value->content.' ';
                }
            }
        } elseif (property_exists($data_prediction, 'value')
            && property_exists($data_prediction, 'confidence')
            && self::CONFIDENCE_THRESHOLD < $data_prediction->confidence) {
            return $data_prediction->value;
        }

        return $value;
    }
}
