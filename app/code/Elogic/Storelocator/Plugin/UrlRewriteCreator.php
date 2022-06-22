<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Plugin;

use Elogic\Storelocator\Api\Data\StoreListInterface;
use Elogic\Storelocator\Model\StoreListRepository;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;
use Magento\Store\Model\ResourceModel\Store\Collection as StoreCollection;

class UrlRewriteCreator
{
    /**
     * @var UrlRewriteFactory
     */
    protected $_urlRewriteFactory;
    /**
     * @var UrlRewriteCollectionFactory
     */
    protected $urlRewriteCollectionFactory;

    protected $storeCollection;
    /**
     * UrlRewriteCreator constructor.
     * @param UrlRewriteFactory $_urlRewriteFactory
     * @param UrlRewriteCollectionFactory $urlRewriteCollectionFactory
     */
    public function __construct(
        StoreCollection $storeCollection,
        UrlRewriteFactory $_urlRewriteFactory,
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory
    ) {
        $this->storeColecttion = $storeCollection;
        $this->_urlRewriteFactory = $_urlRewriteFactory;
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
    }

    /**
     * @param \Elogic\Storelocator\Model\StoreListRepository $subject
     * @param $result
     * @param StoreListInterface $storeList
     */
    public function afterSave(StoreListRepository $subject, $result, StoreListInterface $storeList): void
    {

        $url_key = $storeList->getUrlKey();
        $id = $storeList->getId();
        $RewriteUrl = $this->urlRewriteCollectionFactory->create()
            ->addFieldToFilter('target_path', "storelist/stores/index/store_id/" . $id . "/");
        $stores = $this->storeColecttion->load();

        if (!$RewriteUrl->count()) {
            foreach ($stores as $store) {
                $urlRewriteModel = $this->_urlRewriteFactory->create();
                $urlRewriteModel->setStoreId($store->getStoreId());
                $urlRewriteModel->setIsSystem(0);
                $urlRewriteModel->setIdPath(rand(1, 100000));
                $urlRewriteModel->setTargetPath("storelist/stores/index/store_id/" . $id . "/");
                $urlRewriteModel->setRequestPath("stores/" . $url_key . "/");
                $urlRewriteModel->save();
            }
        } else {
            foreach ($RewriteUrl as $item) {
                $item->setRequestPath("stores/" . $url_key . "/");
                $item->save();
            }
        }
    }
}
