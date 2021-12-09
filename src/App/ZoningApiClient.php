<?php
/**
 * Description of ZoningApiClient.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Liuba Kalyta <kalyta@dotsplatform.com>
 */

namespace Dotsplatform\Zoning;

use Dotsplatform\Zoning\Http\HttpClient;
use Dotsplatform\Zoning\Entities\Company;
use Dotsplatform\Zoning\Entities\Location;
use Dotsplatform\Zoning\Entities\NearestCompanies;
use Throwable;

class ZoningApiClient extends HttpClient
{
    private const STORE_COMPANY_URL_TEMPLATE = '/api/companies/%s';
    private const DELETE_COMPANY_URL_TEMPLATE = '/api/companies/%s';
    private const SEARCH_NEAREST_URL = '/api/companies/nearest';

    public function storeCompany(Company $company): void
    {
        try {
            $this->put(sprintf(
                self::STORE_COMPANY_URL_TEMPLATE,
                $company->getId(),
            ), $company->toArray(), [
                'json' => true,
            ]);
        } catch (Throwable $e) {

        }
    }

    public function deleteCompany(string $id): void
    {
        $this->delete(sprintf(
            self::DELETE_COMPANY_URL_TEMPLATE,
            $id,
        ));
    }

    public function getNearestCompaniesIdsBySortedByDistance(string $accountId, Location $location): NearestCompanies
    {
        $data = $this->get(self::SEARCH_NEAREST_URL, [
            'query' => [
                'accountId' => $accountId,
                'lat' => $location->getLatitude(),
                'lon' => $location->getLongitude(),
            ]
        ]);
        if (empty($data)) {
            return new NearestCompanies;
        }
        return new NearestCompanies;
    }

}