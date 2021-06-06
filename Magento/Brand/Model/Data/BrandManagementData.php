<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model\Data;

use Magento\Framework\Api\AbstractSimpleObject;
use Magento\Brand\Api\Data\BrandManagementDataInterface;

/**
 * Class BrandManagementData
 *
 * Magento\Brand\Model\Data
 */
class BrandManagementData extends AbstractSimpleObject implements BrandManagementDataInterface
{
    /**
     * @inheritdoc
     */
    public function getItems(): array
    {
        return $this->_get(\Magento\Brand\Api\Data\BrandManagementDataInterface::ITEMS);
    }

    /**
     * @inheritdoc
     */
    public function setItems(array $items): BrandManagementDataInterface
    {
        return $this->setData(\Magento\Brand\Api\Data\BrandManagementDataInterface::ITEMS, $items);
    }
}
