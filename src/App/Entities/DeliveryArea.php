<?php
/**
 * Description of DeliveryArea.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dotsplatform\Zoning\Entities;

class DeliveryArea extends Entity
{
    protected array $points;

    public function getPoints(): array
    {
        return $this->points;
    }

    public function getLatLonPoints(): array
    {
        return array_map(fn (array $point) => ['lat' => $point[0], 'lon' => $point[1]], $this->getPoints());
    }
}
