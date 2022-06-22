<?php
declare(strict_types=1);
namespace Elogic\Storelocator\Console;

use Elogic\Storelocator\Model\StoreListFactory;
use Elogic\Storelocator\Model\StoreListRepository;
use Magento\Framework\File\Csv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Elogic\Storelocator\Model\ResourceModel\StoreList\CollectionFactory;

/**
 * Class ImportCSV
 * @package Elogic\Storelocator\Console
 */
class ImportCSV extends Command
{
    /**
     * @var Csv
     */
    protected $csv;

    /**
     * @var StoreListFactory
     */
    protected $storeListFactory;
    /**
     * @var StoreListRepository
     */
    protected $storeListRepository;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;



    /**
     * ImportCSV constructor.
     * @param Csv $csv
     * @param CollectionFactory $collectionFactory
     * @param StoreListFactory $storeListFactory
     * @param StoreListRepository $storeListRepository
     */
    public function __construct(
        Csv $csv,
        CollectionFactory $collectionFactory,
        StoreListFactory $storeListFactory,
        StoreListRepository $storeListRepository
    ) {
        $this->collectionFactory= $collectionFactory;
        $this->csv = $csv;
        $this->storeListFactory = $storeListFactory;
        $this->storeListRepository = $storeListRepository;

        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('custom:import:csv');
        $this->setDescription('Import CSV file');
        $this->addOption('path', "p", InputOption::VALUE_OPTIONAL, "Path for csv file");
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $path = $input->getOption('path');

        if (empty($path)) {
            throw  new \Exception("Invalid argument");
        }

        try {
            $csvData = $this->csv->getData($path);
            $keys = array_shift($csvData);
            $keys = array_flip($keys);


            foreach ($csvData as $value) {
                $symbols = array("&", "?", "!", "#", "@", "%", " ");
                $prefix  = mb_strtolower(str_replace($symbols, "_", $value[$keys['name']]) . "_");
                $url_key = uniqid("$prefix");
                $store = $this->storeListFactory->create()
                    ->setStoreName($value[$keys['name']])
                    ->setAddress($value[$keys['address']])
                    ->setDescription($value[$keys['description']])
                    ->setImages($value[$keys['store_img']])
                    ->setWorkSchedule($value[$keys['schedule']])
                    ->setUrlKey($url_key);
                $this->storeListRepository->save($store);
            }

            $output->writeln('Import Done!');
        } catch (\Exception $e) {
            $output->writeln('Invalid CSV');
            $output->writeln($e->getMessage());
        }
    }
}
