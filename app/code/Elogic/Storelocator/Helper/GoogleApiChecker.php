<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Helper;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class GoogleApiChecker
 * @package Elogic\Storelocator\Helper
 */
class GoogleApiChecker
{
    const GOOGLE_MAPS_HOST = 'https://maps.googleapis.com/maps/api/geocode/';
    const ELOGIC_STORELOCATOR_SETTINGS_GENERAL_API_KEY = "storelocator_settings/general/api_key";


    protected $dataHelper;
    /**
     * @var \Zend_Http_Client
     */
    protected $client;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * AddGeocode constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param \Zend_Http_Client $client
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Zend_Http_Client $client
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->client = $client;
    }

    /**
     * @param string $address
     * @return array
     * @throws CouldNotSaveException
     */
    public function getGoogleApi(string $address): ?array
    {
        try {
            $this->client->setUri(self::GOOGLE_MAPS_HOST . 'json');
            $this->client->setMethod(\Zend_Http_Client::GET);
            $this->client->setParameterGet('address', $address);
            $this->client->setParameterGet('key', $this->getApiKey());
            $response = $this->client->request();
        } catch (\Zend_Http_Client_Exception $e) {
            throw new CouldNotSaveException(__('Request error'));
        }
        if ($response->isSuccessful() && $response->getStatus() == 200) {
            try {
                $response = json_decode($response->getBody())->results[0];
                $location = $response->geometry->location;

                return [
                    'latitude' => $location->lat,
                    'longitude' => $location->lng
                ];
            } catch (\Exception $e) {
                throw new CouldNotSaveException(__('Invalid Address'));
            }
        } else {
            throw new CouldNotSaveException(__('Google Maps API error'));
        }
    }

    /**
     * @return string
     */
    public function getApiKey(): ?string
    {
        return $this->scopeConfig->getValue(self::ELOGIC_STORELOCATOR_SETTINGS_GENERAL_API_KEY);
    }
}
