<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Elogic\Storelocator\Api\StoreListRepositoryInterface;
use Elogic\Storelocator\Model\StoreListFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Elogic\Storelocator\Model\ImageUploader;

/**
 * Class Save
 * @package Elogic\Storelocator\Controller\Adminhtml\StoreList
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * @var StoreListFactory
     */
    private $storeListFactory;

    /**
     * @var StoreListRepositoryInterface
     */
    private $storeListRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param StoreListFactory $storeListFactory
     * @param StoreListRepositoryInterface $storeListRepository
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        StoreListFactory $storeListFactory,
        StoreListRepositoryInterface $storeListRepository,
        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->storeListFactory = $storeListFactory;
        $this->imageUploader = $imageUploader;
        $this->storeListRepository = $storeListRepository;
        parent::__construct($context);
    }


    /**
     * @return Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): object
    {

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $model = $this->storeListFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->storeListRepository->get($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            try {
                $data = $this->_filterFoodData($data);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $this->storeListRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the store.'));
                $this->dataPersistor->clear('store_list');
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the store.'));
            }

            $this->dataPersistor->set('store_list', $data);

            $model->setData($data);
            try {
                $this->storeListRepository->save($model);
            } catch (CouldNotSaveException $exception) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }


            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param array $rawData
     * @return array
     */
    public function _filterFoodData(array $rawData): array
    {
        $data = $rawData;

        $images_str = '';
        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $image) {
                if (isset($image['name'])) {
                    $images_str = $images_str . $image['name'] . ';';
                }
                if (isset($image['images'])) {
                    $images_str = $images_str . $image['images'] . ";";
                }
            }
        }
        if (!empty($images_str)) {
            $images_str = mb_substr($images_str, 0, -1);
            $data['images'] = $images_str;
        } else {
            $data['images'] = null;
        }
        return $data;
    }
}
