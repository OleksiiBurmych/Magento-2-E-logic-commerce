<?php
namespace Elogic\Storelocator\Model\ResourceModel;

/**
 * Class StoreList
 * @package Elogic\Storelocator\Model\ResourceModel
 */
class StoreList extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('store_list', 'id');
    }
}
