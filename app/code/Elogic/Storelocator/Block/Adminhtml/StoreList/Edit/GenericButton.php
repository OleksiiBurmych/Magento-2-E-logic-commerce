<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Block\Adminhtml\StoreList\Edit;

use Elogic\Storelocator\Api\StoreListRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 * @package Elogic\Storelocator\Block\Adminhtml\StoreList\Edit
 */

abstract class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var StoreListRepositoryInterface
     */
    protected $storelistRepository;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param StoreListRepositoryInterface $storelistRepository
     */
    public function __construct(
        Context $context,
        StoreListRepositoryInterface $storelistRepository
    ) {
        $this->context = $context;
        $this->storelistRepository = $storelistRepository;
    }


    /**
     * @return string|null
     */
    public function getStoreId(): ?string
    {
        if ($this->context->getRequest()->getParam('id')) {
            try {
                return $this->storelistRepository->get(
                    $this->context->getRequest()->getParam('id')
                )->getId();
            } catch (NoSuchEntityException $e) {
            }
        }

        return null;
    }


    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = []): ?string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
