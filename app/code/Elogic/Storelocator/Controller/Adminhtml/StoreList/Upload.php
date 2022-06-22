<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Controller\Adminhtml\StoreList;

use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Upload
 * @package Elogic\Storelocator\Controller\Adminhtml\StoreList
 */
class Upload extends \Magento\Backend\App\Action
{
    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ?object
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('images');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
