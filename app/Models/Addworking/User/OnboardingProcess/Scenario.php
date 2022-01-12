<?php

namespace App\Models\Addworking\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess;
use Illuminate\Support\Collection;

abstract class Scenario extends Collection
{
    /**
     * Constructor
     *
     * @param array $items
     */
    public function __construct(OnboardingProcess $process)
    {
        parent::__construct([]);

        foreach ($this->getSteps() as $class) {
            $this[] = new $class($process);
        }
    }

    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $keys  = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);

        return new Collection(array_combine($keys, $items));
    }

    /**
     * Return scenario steps.
     *
     * @return array
     */
    protected function getSteps(): array
    {
        return $this->steps ?? [];
    }
}
