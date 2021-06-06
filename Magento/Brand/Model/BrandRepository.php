<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model;

use Magento\Brand\Api\Data\BrandInterface;
use Magento\Brand\Api\Data\BrandSearchResultsInterface;
use Magento\Brand\Model\BrandFactory;
use Magento\Brand\Model\ResourceModel\Brand as ResourceBrand;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Brand\Api\Data\BrandSearchResultsInterfaceFactory;
use Magento\Brand\Model\ResourceModel\Brand\CollectionFactory as BrandCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class BrandRepository - Repositories are a combination of resource model and collections.
 *
 * Magento\Brand\Model
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BrandRepository implements \Magento\Brand\Api\BrandRepositoryInterface
{
    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @var ResourceBrand
     */
    private $resourceBrand;

    /**
     * @var JoinProcessorInterface
     */
    private $joinProcessor;

    /**
     * @var brandCollectionFactory
     */
    private $brandCollectionFactory;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $extensibleDataObjectConverter;

    /**
     * @var BrandSearchResultsInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * BrandRepository constructor.
     *
     * @param \Magento\Brand\Model\BrandFactory $brandFactory
     * @param ResourceBrand $resourceBrand
     * @param JoinProcessorInterface $joinProcessor
     * @param BrandCollectionFactory $brandCollectionFactory
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param BrandSearchResultsInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param LoggerInterface $logger
     */
    public function __construct(
        BrandFactory $brandFactory,
        ResourceBrand $resourceBrand,
        JoinProcessorInterface $joinProcessor,
        BrandCollectionFactory $brandCollectionFactory,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        BrandSearchResultsInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor,
        LoggerInterface $logger
    ) {
        $this->brandFactory = $brandFactory;
        $this->resourceBrand = $resourceBrand;
        $this->joinProcessor = $joinProcessor;
        $this->brandCollectionFactory = $brandCollectionFactory;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function save(BrandInterface $brand): BrandInterface
    {
        $brandData = $this->extensibleDataObjectConverter->toNestedArray(
            $brand,
            [],
            BrandInterface::class
        );
        $brandModel = $this->brandFactory->create()->setData($brandData);
        try {
            $this->resourceBrand->save($brandModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Brand Index : %1',
                $exception->getMessage()
            ));
        }
        return $brandModel->getDataModel();
    }

    /**
     * @inheritdoc
     */
    public function getById(int $brandId): BrandInterface
    {
        $brand = $this->brandFactory->create();
        $this->resourceBrand->load($brand, $brandId);
        return $brand->getDataModel();
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $brandId): bool
    {
        try {
            $brand = $this->getById($brandId);
            return $this->delete($brand);
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(BrandInterface $brand): bool
    {
        try {
            $brandModel = $this->brandFactory->create();
            $this->resourceBrand->load($brandModel, $brand->getBrandId());
            $this->resourceBrand->delete($brandModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Brand Index option row : %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): BrandSearchResultsInterface
    {
        /** @var \Magento\Brand\Model\ResourceModel\Brand\Collection $collection */
        $collection = $this->brandCollectionFactory->create();
        $this->joinProcessor->process(
            $collection,
            BrandInterface::class
        );
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
