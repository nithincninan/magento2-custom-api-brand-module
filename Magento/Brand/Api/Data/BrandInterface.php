<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Api\Data;

use Magento\Brand\Api\Data\BrandExtensionInterface;
use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface BrandInterface
 *
 * Magento\Brand\Api\Data
 */
interface BrandInterface extends ExtensibleDataInterface
{
    /**
     * Constants for Brands
     */
    public const BRAND_ID = 'brand_id';
    public const NAME = 'name';
    public const CODE = 'code';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Get Brand ID
     *
     * @return int|null
     */
    public function getBrandId(): ?int;

    /**
     * Set Brand ID
     *
     * @param int|null $brandId
     * @return void
     */
    public function setBrandId(?int $brandId): void;

    /**
     * Get Brand Name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set Brand Name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * Get Brand Code
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Set Brand Code
     *
     * @param string $code
     * @return void
     */
    public function setCode(string $code): void;

    /**
     * Get created-at timestamp for brand.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set created-at timestamp for brand.
     *
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;

    /**
     * Get updated-at timestamp for brand.
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Sets the updated-at timestamp for the vendor.
     *
     * @param string $updatedAt
     * @return void
     */
    public function setUpdatedAt(string $updatedAt): void;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\Brand\Api\Data\BrandExtensionInterface|null
     */
    public function getExtensionAttributes(): ?BrandExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Magento\Brand\Api\Data\BrandExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(BrandExtensionInterface $extensionAttributes): void;
}
