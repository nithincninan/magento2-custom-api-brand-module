<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model\Data;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Brand\Api\Data\BrandExtensionInterface;

/**
 * Class Brand
 *
 * Magento\Brand\Model\Data
 */
class Brand extends AbstractExtensibleModel implements \Magento\Brand\Api\Data\BrandInterface
{
    /**
     * @inheritdoc
     */
    public function getBrandId(): ?int
    {
        return $this->getData(self::BRAND_ID);
    }

    /**
     * @inheritdoc
     */
    public function setBrandId(?int $brandId): void
    {
        $this->setData(self::BRAND_ID, $brandId);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return (string) $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function getCode(): string
    {
        return (string) $this->getData(self::CODE);
    }

    /**
     * @inheritdoc
     */
    public function setCode(string $code): void
    {
        $this->setData(self::CODE, $code);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes(): ?BrandExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(BrandExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
