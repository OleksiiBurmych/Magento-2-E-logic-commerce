<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Block\Adminhtml\StoreList\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 * @package Elogic\Storelocator\Block\Adminhtml\StoreList\Edit
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): ?array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * @return string
     */
    public function getBackUrl(): ?string
    {
        return $this->getUrl('*/*/');
    }
}
