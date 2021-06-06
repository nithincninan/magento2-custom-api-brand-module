<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Api\Data;

/**
 * Interface BrandManagementDataInterface
 *
 * Magento\Brand\Api\Data
 */
interface BrandManagementDataInterface
{
    /**
     * Constant for BrandManagementDataInterface
     */
    public const ITEMS = 'items';

    /**
     * Get Brands list
     *
     * @return \Magento\Brand\Api\Data\BrandInterface[]|null
     */
    public function getItems(): array;

    /**
     * @param \Magento\Brand\Api\Data\BrandInterface[] $items
     * @return \Magento\Brand\Api\Data\BrandManagementDataInterface
     */
    public function setItems(array $items): BrandManagementDataInterface;
}
