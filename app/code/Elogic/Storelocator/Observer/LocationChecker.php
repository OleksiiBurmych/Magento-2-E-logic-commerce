<?php
namespace Elogic\Storelocator\Observer;

use Elogic\Storelocator\Helper\GoogleApiChecker;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class LocationChecker
 * @package Elogic\Storelocator\Observer
 */
class LocationChecker implements ObserverInterface
{
    /**
     * @var GoogleApiChecker
     */
    private $googleApi;
    /**
     * @var ManagerInterface
     */
    private $messageManager;


    /**
     * LocationChecker constructor.
     * @param GoogleApiChecker $googleApi
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        GoogleApiChecker $googleApi,
        ManagerInterface $messageManager
    ) {
        $this->googleApi = $googleApi;
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {

        $store = $observer->getEvent()->getObject();

        if ((doubleval($store->getLatitude()) == 0) || (doubleval($store->getLongitude()) == 0)) {
            $address = $store->getAddress();
            try {
                $googleApi = $this->googleApi->getGoogleApi($address);
                $store->setLongitude($googleApi['longitude'])->setLatitude($googleApi['latitude']);
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addNoticeMessage($exception->getMessage());
            }
        }
    }
}
