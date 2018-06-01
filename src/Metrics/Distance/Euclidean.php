<?php

namespace Rubix\Engine\Metrics\Distance;

class Euclidean implements Distance
{
    /**
     * Compute the distance between two coordinate vectors.
     *
     * @param  array  $a
     * @param  array  $b
     * @return float
     */
    public function compute(array $a, array $b) : float
    {
        $distance = 0.0;

        foreach ($a as $index => $coordinate) {
            $distance += ($coordinate - $b[$index]) ** 2;
        }

        return sqrt($distance);
    }
}