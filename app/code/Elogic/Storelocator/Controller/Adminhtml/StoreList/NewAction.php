<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

/**
 * Class NewAction
 * @package Elogic\Storelocator\Controller\Adminhtml\StoreList
 */
class NewAction extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * NewAction constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ?object
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
