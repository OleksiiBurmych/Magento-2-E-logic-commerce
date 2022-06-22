<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Magento\Framework\Exception\CouldNotDeleteException;
use Elogic\Storelocator\Api\StoreListRepositoryInterface;
use Magento\Backend\App\Action;

class Delete extends Action
{
    const ADMIN_RESOURCE = "Elogic_Storelocator::all";
    /**
     * @var StoreListRepositoryInterface
     */
    protected $storelistRepositoryInterface;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param StoreListRepositoryInterface $storeListRepository
     */
    public function __construct(
        Action\Context $context,
        StoreListRepositoryInterface $storeListRepository
    ) {
        $this->storelistRepositoryInterface = $storeListRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ?object
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->storelistRepositoryInterface->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the store.'));
                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotDeleteException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->messageManager->addErrorMessage(__('Nothing to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
