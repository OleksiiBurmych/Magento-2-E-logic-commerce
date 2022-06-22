<?php
declare(strict_types=1);
namespace  Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Elogic\Storelocator\Model\ResourceModel\StoreList\CollectionFactory;
use Elogic\Storelocator\Api\StoreListRepositoryInterface;
use Magento\Backend\App\Action;

/**
 * Class MassDelete
 * @package Elogic\Storelocator\Controller\Adminhtml\StoreList
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Elogic_Storelocator::all';

    /**
     * @var StoreListRepositoryInterface
     */
    protected $storelistRepositoryInterface;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param StoreListRepositoryInterface $storelistRepositoryInterface
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        StoreListRepositoryInterface $storelistRepositoryInterface
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->storelistRepositoryInterface = $storelistRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): ?object
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $store) {
            $this->storelistRepositoryInterface->deleteById($store->getId());
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
