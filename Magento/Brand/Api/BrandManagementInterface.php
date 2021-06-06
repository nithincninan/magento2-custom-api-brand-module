<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Api;

/**
 * Interface BrandManagementInterface
 *
 * Magento\Brand\Api
 */
interface BrandManagementInterface
{
    /**
     * Create brand API
     *
     * @param Data\BrandManagementDataInterface $brandData
     * @return string[]
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function createBrand(Data\BrandManagementDataInterface $brandData): array;

    /**
     * Update brand API
     * If no ids then will trigger Create API
     *
     * @param Data\BrandManagementDataInterface $brandData
     * @return string[]
     */
    public function updateBrand(Data\BrandManagementDataInterface $brandData): array;

    /**
     * Delete brand
     *
     * @param string $code
     * @return string[]
     */
    public function deleteBrand(string $code): array;

    /**
     * Get Brand Details
     *
     * @param string $code
     * @return string[]
     */
    public function getBrand(string $code): array;
}
