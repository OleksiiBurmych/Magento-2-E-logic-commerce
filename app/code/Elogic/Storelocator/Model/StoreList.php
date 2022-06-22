<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Model;

use Elogic\Storelocator\Api\Data\StoreListInterface;
use Elogic\Storelocator\Api\Data\StoreListInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class StoreList
 * @package Elogic\Storelocator\Model
 */
class StoreList extends \Magento\Framework\Model\AbstractModel implements StoreListInterface
{
    /**
     * @var StoreListInterfaceFactory
     */
    protected $store_listDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'store_list';
    /**
     * @var string
     */
    protected $eventObject = 'store_storelocator_collection';

    /**
     * StoreList constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param StoreListInterfaceFactory $store_listDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\StoreList $resource
     * @param ResourceModel\StoreList\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreListInterfaceFactory $store_listDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Elogic\Storelocator\Model\ResourceModel\StoreList $resource,
        \Elogic\Storelocator\Model\ResourceModel\StoreList\Collection $resourceCollection,
        array $data = []
    ) {
        $this->store_listDataFactory = $store_listDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    //Getters

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->_getData(self::ID);
    }

    /**
     * @return string
     */
    public function getStoreName(): ?string
    {
        return $this->_getData(self::STORE_NAME);
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->_getData(self::DESCRIPTION);
    }

    /**
     * @return string
     */
    public function getImages(): ?string
    {
        return $this->_getData(self::IMAGES);
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->_getData(self::ADDRESS);
    }

    /**
     * @return string
     */
    public function getWorkSchedule(): ?string
    {
        return $this->_getData(self::WORK_SCHEDULE);
    }

    /**
     * @return string
     */
    public function getLongitude(): ?string
    {
        return $this->_getData(self::LONGITUDE);
    }

    /**
     * @return string
     */
    public function getLatitude(): ?string
    {
        return $this->_getData(self::LATITUDE);
    }

    /**
     * @return string
     */
    public function getUrlKey(): ?string
    {
        return $this->_getData(self::URL_KEY);
    }

    //Setters

    /**
     * @param mixed $id
     * @return StoreList
     */
    public function setId($id): StoreList
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @param $storeName
     * @return StoreList
     */
    public function setStoreName($storeName): StoreList
    {
        return $this->setData(self::STORE_NAME, $storeName);
    }

    /**
     * @param $description
     * @return StoreList
     */
    public function setDescription($description): StoreList
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @param $images
     * @return StoreList
     */
    public function setImages($images): StoreList
    {
        return $this->setData(self::IMAGES, $images);
    }

    /**
     * @param $address
     * @return StoreList
     */
    public function setAddress($address): StoreList
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * @param $workSchedule
     * @return StoreList
     */
    public function setWorkSchedule($workSchedule): StoreList
    {
        return $this->setData(self::WORK_SCHEDULE, $workSchedule);
    }

    /**
     * @param $longitude
     * @return StoreList
     */
    public function setLongitude($longitude): StoreList
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * @param $latitude
     * @return StoreList
     */
    public function setLatitude($latitude): StoreList
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * @param $urlKey
     * @return StoreList
     */
    public function setUrlKey($urlKey): StoreList
    {
        return $this->setData(self::URL_KEY, $urlKey);
    }
}
