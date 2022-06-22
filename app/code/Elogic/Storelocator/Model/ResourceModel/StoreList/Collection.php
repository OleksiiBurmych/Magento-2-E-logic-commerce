<?php
namespace Elogic\Storelocator\Model\ResourceModel\StoreList;

/**
 * Class Collection
 * @package Elogic\Storelocator\Model\ResourceModel\StoreList
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init(
            \Elogic\Storelocator\Model\StoreList::class,
            \Elogic\Storelocator\Model\ResourceModel\StoreList::class
        );
    }
}
