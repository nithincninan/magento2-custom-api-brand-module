<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model;

use Magento\Brand\Api\Data\BrandInterface;
use Magento\Brand\Api\Data\BrandInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class Brand - Represents the row of data from database
 *
 * Magento\Brand\Model
 */
class Brand extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var BrandInterfaceFactory
     */
    private BrandInterfaceFactory $brandDataFactory;

    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepository;

    /**
     * Brand constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param BrandInterfaceFactory $brandDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\Brand $resource
     * @param ResourceModel\Brand\Collection $resourceCollection
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BrandRepository $brandRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Brand\Api\Data\BrandInterfaceFactory $brandDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Brand\Model\ResourceModel\Brand $resource,
        \Magento\Brand\Model\ResourceModel\Brand\Collection $resourceCollection,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BrandRepository $brandRepository,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->brandDataFactory = $brandDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Retrieve Brand Model
     *
     * @return BrandInterface
     */
    public function getDataModel(): BrandInterface
    {
        $brandData = $this->getData();
        $brandDataObject = $this->brandDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $brandDataObject,
            $brandData,
            BrandInterface::class
        );
        return $brandDataObject;
    }

    /**
     * Get brand details by code
     *
     * @param string $code
     * @return string[]
     */
    public function getBrandDetails(string $code): array
    {
        $brandDetails = [];
        $this->searchCriteriaBuilder
            ->addFilter(BrandInterface::CODE, $code)
            ->setPageSize(1);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $items = $this->brandRepository->getList($searchCriteria)->getItems();
        foreach ($items as $item) {
            $brandDetails = $item->getData();
        }
        return $brandDetails;
    }
}
