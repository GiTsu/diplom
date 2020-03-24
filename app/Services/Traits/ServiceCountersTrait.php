<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.03.19
 * Time: 12:20
 */

namespace App\Services\Traits;

// TODO: перенести в папку ../Traits
trait ServiceCountersTrait
{
    private $serviceCounters = [];


    public function getServiceCounters()
    {

        $currentCounters = $this->serviceCounters;
        $this->serviceCounters = [];
        return $currentCounters;
    }

    public function increaseCounter($metricTitle, $amount = 1)
    {
        if (isset($this->serviceCounters[$metricTitle])) {
            $this->serviceCounters[$metricTitle] += $amount;
        } else {
            $this->serviceCounters[$metricTitle] = $amount;
        }
    }

    public function decreaseCounter($metricTitle, $amount = 1)
    {
        if (isset($this->serviceCounters[$metricTitle])) {
            $this->serviceCounters[$metricTitle] -= $amount;
        } else {
            $this->serviceCounters[$metricTitle] = -1 * $amount;
        }
    }


}
