<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Block;

use Elogic\Storelocator\Model\ResourceModel\StoreList\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class StorelistBlock
 * @package Elogic\Storelocator\Block
 */
class StorelistBlock extends Template
{
    const PAGER = [10 => 10];

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * StorelistBlock constructor.
     * @param CollectionFactory $collectionFactory
     * @param Template\Context $context
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Template\Context $context,
        UrlInterface $urlBuilder,
        RequestInterface $request,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
    }

    /**
     * @return $this|StorelistBlock
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout(): ?object
    {
        parent::_prepareLayout();

        if ($this->getStores()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'pager'
            )->setAvailableLimit(self::PAGER)->setShowPerPage(true)->setCollection(
                $this->getStores()
            );
            $this->setChild('pager', $pager);
            $this->getStores()->load();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml(): ?string
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @return \Elogic\Storelocator\Model\ResourceModel\StoreList\Collection
     */
    public function getStores(): ?object
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $collection = $this->collectionFactory->create();

        $request = $this->request->getParam('store_name');
        if (!empty($request)) {
            $collection->addFieldToFilter('store_name', ['like' => '%' . $request . '%']);
        }

        $collection->setOrder('id', 'ASC');
        $collection->setPageSize(10);
        $collection->setCurPage($page);
        return $collection;
    }

    /**
     * @return string
     */
    public function getStoreUrl($url_key): ?string
    {
        return $this->urlBuilder->getUrl("stores/" . $url_key);
    }
}
