<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Api;

use Magento\Brand\Api\Data\BrandInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Brand\Api\Data\BrandSearchResultsInterface;

/**
 * Interface BrandRepositoryInterface
 *
 * Magento\Brand\Api
 */
interface BrandRepositoryInterface
{
    /**
     * Save Brand Object
     *
     * @param BrandInterface $brand
     * @return \Magento\Brand\Api\Data\BrandInterface
     */
    public function save(\Magento\Brand\Api\Data\BrandInterface $brand): BrandInterface;

    /**
     * Get brand object by id
     *
     * @param int $brandId
     * @return \Magento\Brand\Api\Data\BrandInterface
     */
    public function getById(int $brandId): BrandInterface;

    /**
     * Delete object
     *
     * @param BrandInterface $brand
     * @return bool
     */
    public function delete(BrandInterface $brand): bool;

    /**
     * Delete brand object by id
     *
     * @param int $brandId
     * @return bool
     */
    public function deleteById(int $brandId): bool;

    /**
     * Get a list of brand Object
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Brand\Api\Data\BrandSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): BrandSearchResultsInterface;
}
