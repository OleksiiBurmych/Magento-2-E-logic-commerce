<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Elogic\Storelocator\Controller\Adminhtml\StoreList
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute(): ?object
    {

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Cms::config_storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__("StoreList"));
        return $resultPage;
    }
}
