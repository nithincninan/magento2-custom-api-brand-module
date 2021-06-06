<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model\ResourceModel\Brand;

/**
 * Class Collection
 *
 * Magento\Brand\Model\ResourceModel\Brand
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Set resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Magento\Brand\Model\Brand::class,
            \Magento\Brand\Model\ResourceModel\Brand::class
        );
    }
}
