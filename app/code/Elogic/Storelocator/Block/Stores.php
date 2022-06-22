<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Block;

use Elogic\Storelocator\Model\StoreListRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class Stores
 * @package Elogic\Storelocator\Block
 */
class Stores extends Template
{
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var StoreListRepository
     */
    private $storelistRepository;

    /**
     * Stores constructor.
     * @param StoreListRepository $storelistRepository
     * @param Template\Context $context
     * @param RequestInterface $request
     * @param array $data
     */
    public function __construct(
        StoreListRepository $storelistRepository,
        Template\Context $context,
        RequestInterface $request,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->storelistRepository = $storelistRepository;
    }

    /**
     * @return \Elogic\Storelocator\Model\StoreList
     */
    public function getStore(): ?object
    {
        $id = $this->request->getParam('store_id');
        return $this->storelistRepository->get($id);
    }


}
