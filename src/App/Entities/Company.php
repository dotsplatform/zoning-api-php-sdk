<?php
/**
 * Description of StoreCompanyDTO.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dotsplatform\Zoning\Entities;

class Company extends Entity
{
    protected string $accountId;
    protected string $cityId;
    protected string $id;
    protected string $name;
    protected int $priority = 0;
    protected DeliveryArea $deliveryArea;
    protected Location $location;

    public static function fromArray(array $data): static
    {
        $data['deliveryArea'] =   DeliveryArea::fromArray($data['deliveryArea']);
        $data['location'] = Location::fromArray($data['location']);
        return parent::fromArray($data);
    }

    public function getId(): string
    {
        return $this->id;
    }
}
