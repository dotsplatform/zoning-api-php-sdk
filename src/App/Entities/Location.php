<?php
/**
 * Description of Point.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dotsplatform\Zoning\Entities;

class Location extends Entity
{
    protected ?float $latitude = null;
    protected ?float $longitude = null;

    public static function fromLonLat(?float $longitude, ?float $latitude): static
    {
        return static::fromArray([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
}
