<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Api;

use Elogic\Storelocator\Model\StoreList;

/**
 * Interface StoreListRepositoryInterface
 * @package Elogic\Storelocator\Api
 */
interface StoreListRepositoryInterface
{

    /**
     * @param Data\StoreListInterface $storeList
     * @return Data\StoreListInterface
     */
    public function save(
        Data\StoreListInterface $storeList
    ): ?Data\StoreListInterface;

    /**
     * @param $storeListId
     * @return StoreList
     */
    public function get($storeListId): StoreList;

    /**
     * @param $urlKey
     * @return StoreList
     */
    public function getByUrlKey($urlKey): StoreList;

    /**
     * @param Data\StoreListInterface $storeList
     * @return bool
     */
    public function delete(
        Data\StoreListInterface $storeList
    ): ?bool;

    /**
     * @param $storeListId
     * @return bool
     */
    public function deleteById($storeListId): ?bool;
}
