<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Model\StoreList;

use Elogic\Storelocator\Model\ResourceModel\StoreList\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 * @package Elogic\Storelocator\Model\StoreList
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \Elogic\Storelocator\Model\ResourceModel\StoreList\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;


    protected $loadedData;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;


    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $storelistCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $storelistCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this-> storeManager = $storeManager;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
            if ($model->getImages()) {
                $m['images'][0]['name'] = $model->getImages();
                $m['images'][0]['url'] = $this->getMediaUrl() . $model->getImages();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }
        }
        $data = $this->dataPersistor->get('store_list');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('store_list');
        }

        return $this->loadedData;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl(): ?string
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . "";
        return $mediaUrl;
    }
}
