<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Stores;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Elogic\Storelocator\Controller\Stores
 */
class Index extends Action implements HttpGetActionInterface, HttpPostActionInterface
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;


    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
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
    public function execute(): object
    {
        return $this->resultPageFactory->create();
    }
}
