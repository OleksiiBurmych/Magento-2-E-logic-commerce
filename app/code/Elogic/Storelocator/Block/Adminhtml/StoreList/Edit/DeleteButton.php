<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Block\Adminhtml\StoreList\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): ?array
    {
        $data = [];
        if ($this->getStoreId()) {
            $data = [
                'label' => __('Delete Store'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this store ?')
                    . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl(): ?string
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getStoreId()]);
    }
}
