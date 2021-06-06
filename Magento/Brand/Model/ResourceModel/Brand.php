<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model\ResourceModel;

/**
 * Class Brand
 *
 * Magento\Brand\Model\ResourceModel
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Brand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize main table and table id field
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mdc_band', 'brand_id');
    }

    /**
     * Get connection
     *
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     * @codeCoverageIgnore
     */
    public function getConnection()
    {
        return $this->_resources->getConnection();
    }
}
