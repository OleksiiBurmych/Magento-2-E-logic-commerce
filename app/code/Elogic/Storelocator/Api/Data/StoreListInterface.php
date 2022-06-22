<?php
declare(strict_types=1);

namespace Elogic\Storelocator\Api\Data;

use Elogic\Storelocator\Model\StoreList;

/**
 * Interface StoreListInterface
 * @package Elogic\Storelocator\Api\Data
 */
interface StoreListInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ID = 'id';
    const STORE_NAME = 'store_name';
    const DESCRIPTION = 'description';
    const IMAGES = 'images';
    const ADDRESS = 'address';
    const WORK_SCHEDULE = 'work_schedule';
    const LONGITUDE = 'longitude';
    const LATITUDE = 'latitude';
    const URL_KEY = 'url_key';


    //Getters

    /**
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * @return string
     */
    public function getStoreName(): ?string;

    /**
     * @return string
     */
    public function getDescription(): ?string;

    /**
     * @return string
     */
    public function getImages(): ?string;

    /**
     * @return string
     */
    public function getAddress(): ?string;

    /**
     * @return string
     */
    public function getWorkSchedule(): ?string;

    /**
     * @return string
     */
    public function getLongitude(): ?string;

    /**
     * @return string
     */
    public function getLatitude(): ?string;

    /**
     * @return string
     */
    public function getUrlKey(): ?string;

    //Setters

    /**
     * @param $id
     * @return StoreList
     */
    public function setID($id): StoreList;

    /**
     * @param $storeName
     * @return StoreList
     */
    public function setStoreName($storeName): StoreList;

    /**
     * @param $description
     * @return StoreList
     */
    public function setDescription($description): StoreList;

    /**
     * @param $images
     * @return StoreList
     */
    public function setImages($images): StoreList;

    /**
     * @param $address
     * @return StoreList
     */
    public function setAddress($address): StoreList;

    /**
     * @param $workSchedule
     * @return StoreList
     */
    public function setWorkSchedule($workSchedule): StoreList;

    /**
     * @param $longitude
     * @return StoreList
     */
    public function setLongitude($longitude): StoreList;

    /**
     * @param $latitude
     * @return StoreList
     */
    public function setLatitude($latitude): StoreList;

    /**
     * @param $urlKey
     * @return StoreList
     */
    public function setUrlKey($urlKey): StoreList;
}
