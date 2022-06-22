<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Elogic\Storelocator\Api\StoreListRepositoryInterface;
use Elogic\Storelocator\Model\StoreListFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

/**
 * Class Edit
 * @package Elogic\Storelocator\Controller\Adminhtml\StoreList
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var StoreListRepositoryInterface
     */
    private $storelistRepository;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var StoreListFactory
     */
    private $storelistFactory;
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param StoreListRepositoryInterface $storelistRepository
     * @param StoreListFactory $storelistFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        StoreListRepositoryInterface $storelistRepository,
        StoreListFactory $storelistFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->storelistRepository = $storelistRepository;
        $this->storelistFactory = $storelistFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ?object
    {
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            $model = $this->storelistRepository->get($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->storelistFactory->create();
        }

        $this->coreRegistry->register('store_list', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Elogic_Storelocator::elogic_storelocator_store_list')
            ->addBreadcrumb(__('Store Locator'), __('Store Locator'));

        $resultPage->getConfig()->getTitle()->prepend(__('Store'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? "Store ID: ".$model->getId():__('New Store'));
        return $resultPage;
    }
}
