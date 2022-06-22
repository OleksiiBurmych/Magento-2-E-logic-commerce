<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Model;

use Elogic\Storelocator\Api\Data;
use Elogic\Storelocator\Api\Data\StoreListInterfaceFactory;
use Elogic\Storelocator\Api\StoreListRepositoryInterface;
use Elogic\Storelocator\Model\ResourceModel\StoreList as ResourceStoreList;
use Elogic\Storelocator\Model\ResourceModel\StoreList\CollectionFactory as StoreListCollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Elogic\Storelocator\Api\Data\StoreListInterface;

/**
 * Class StoreListRepository
 * @package Elogic\Storelocator\Model
 */
class StoreListRepository implements StoreListRepositoryInterface
{
    /**
     * @var ResourceStoreList
     */
    protected $resource;

    /**
     * @var StoreListFactory
     */
    protected $storeListFactory;

    /**
     * @var StoreListCollectionFactory
     */
    protected $storeListCollectionFactory;

    /**
     * @var StoreListInterfaceFactory
     */
    protected $dataStoreListFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;




    /**
     * StoreListRepository constructor.
     * @param ResourceStoreList $resource
     * @param StoreListFactory $storeListFactory
     * @param StoreListInterfaceFactory $dataStoreListFactory
     * @param StoreListCollectionFactory $storeListCollectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceStoreList $resource,
        StoreListFactory $storeListFactory,
        StoreListInterfaceFactory $dataStoreListFactory,
        StoreListCollectionFactory $storeListCollectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->storeListFactory = $storeListFactory;
        $this->storeListCollectionFactory = $storeListCollectionFactory;
        $this->dataStoreListFactory = $dataStoreListFactory;
        $this->storeManager = $storeManager;
    }


    /**
     * @param StoreListInterface $storeList
     * @return StoreListInterface
     * @throws CouldNotSaveException
     */
    public function save(
        StoreListInterface $storeList
    ): ?StoreListInterface
    {
        try {
            $this->resource->save($storeList);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $storeList;
    }

    /**
     * @param $storeListId
     * @return StoreList
     * @throws NoSuchEntityException
     */
    public function get(
        $storeListId
    ): StoreList
    {
        $storeList = $this->storeListFactory->create();
        $this->resource->load($storeList, $storeListId);
        if (!$storeList->getId()) {
            throw new NoSuchEntityException(__('The store with the "%1" ID doesn\'t exist.', $storeListId));
        }

        return $storeList;
    }

    /**
     * @param $urlKey
     * @return StoreList
     */
    public function getByUrlKey(
        $urlKey
    ): StoreList
    {
        $storelist = $this->storeListFactory->create();
        $this->resource->load($storelist, $urlKey, Data\StoreListInterface::URL_KEY);
        return $storelist;
    }


    /**
     * @param Data\StoreListInterface $storeList
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(
        Data\StoreListInterface $storeList
    ): ?bool
    {
        try {
            $this->resource->delete($storeList);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param $storeListId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(
        $storeListId
    ): ?bool
    {
        return $this->delete($this->get($storeListId));
    }
}
