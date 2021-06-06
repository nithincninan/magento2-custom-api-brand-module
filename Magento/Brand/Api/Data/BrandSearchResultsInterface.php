<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Api\Data;

/**
 * Interface BrandSearchResultsInterface
 *
 * Magento\Brand\Api\Data
 */
interface BrandSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get brand items
     *
     * @return \Magento\Brand\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set brand items
     *
     * @param \Magento\Brand\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
