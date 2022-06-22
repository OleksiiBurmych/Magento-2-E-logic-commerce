<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Plugin;

use Elogic\Storelocator\Api\Data\StoreListInterface;
use Elogic\Storelocator\Model\StoreListRepository;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;

class UrlRewriteCleaner
{
    /**
     * @var UrlRewriteCollectionFactory
     */
    protected $urlRewriteCollectionFactory;

    /**
     * UrlRewriteCleaner constructor.
     * @param UrlRewriteCollectionFactory $urlRewriteCollectionFactory
     */
    public function __construct(
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory
    ) {
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
    }

    /**
     * @param StoreListRepository $subject
     * @param $result
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterDelete(StoreListRepository $subject, $result, StoreListInterface $storeList): void
    {
        $id = $storeList->getId();
        $collection = $this->urlRewriteCollectionFactory->create()
            ->addFieldToFilter('target_path', "storelist/stores/index/store_id/" . $id . "/");
        $collection->walk('delete');
    }
}
