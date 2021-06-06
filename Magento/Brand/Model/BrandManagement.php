<?php
/**
 * Copyright © 2021 MDC_NCN, LLC. All rights reserved.
 */
declare(strict_types=1);

namespace Magento\Brand\Model;

use Magento\Brand\Api\BrandManagementInterface;
use Magento\Brand\Api\Data\BrandInterfaceFactory;
use Magento\Brand\Api\Data\BrandManagementDataInterface;
use Magento\Brand\Api\Data\BrandManagementDataInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class BrandManagement - To Create/Update/Delete brands
 *
 * Magento\Brand\Model
 */
class BrandManagement implements BrandManagementInterface
{
    /**
     * Constant COUNT_START
     */
    private const COUNT_START = 0;

    /**
     * @var BrandManagementDataInterfaceFactory
     */
    private $brandManagementData;

    /**
     * @var BrandInterfaceFactory
     */
    private $brandData;

    /**
     * @var Brand
     */
    private $brandModel;

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * BrandManagement constructor.
     *
     * @param BrandManagementDataInterfaceFactory $brandManagementData
     * @param BrandInterfaceFactory $brandData
     * @param Brand $brandModel
     * @param BrandRepository $brandRepository
     */
    public function __construct(
        BrandManagementDataInterfaceFactory $brandManagementData,
        BrandInterfaceFactory $brandData,
        Brand $brandModel,
        BrandRepository $brandRepository
    ) {
        $this->brandManagementData = $brandManagementData;
        $this->brandData = $brandData;
        $this->brandModel = $brandModel;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function createBrand(BrandManagementDataInterface $brandData): array
    {
        $response = [];
        $items = $brandData->getItems();
        $successCount = self::COUNT_START;
        $errorCount = self::COUNT_START;
        foreach ($items as $item) {
            try {
                $output = ['Brand' => $item->getName()];
                $brandDetails = $this->brandModel->getBrandDetails($item->getCode());
                if (empty($brandDetails['brand_id'])) {
                    $brandDataModel = $this->brandData->create();
                    $brandDataModel->setBrandId(null);
                    $brandDataModel->setName($item->getName());
                    $brandDataModel->setCode($item->getCode());
                    $this->brandRepository->save($brandDataModel);
                    $successCount++;
                    $output['success'] = true;
                    $output['message'] = __('Brand - %1 created', $item->getName());
                    $response[0]['create'][] = $output;
                    continue;
                } else {
                    throw new LocalizedException(__('Brand with %1 already exists', $item->getName()));
                }
            } catch (\Exception $exception) {
                $errorCount++;
                $output['success'] = false;
                $output['message'] = [
                    'msg' => 'Error in creating brand data. ' . $exception->getMessage(),
                    'data' => ['Brand Name' => $item->getName()]
                ];
                $response[0]['create'][] = $output;
                continue;
            }
        }
        $response[0]['brand_items'] = [
            'total' => count($items),
            'created' => $successCount,
            'errors' => $errorCount
        ];
        return $response;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function updateBrand(BrandManagementDataInterface $brandData): array
    {
        $response = [];
        $createBrands = [];
        $items = $brandData->getItems();
        $successCount = self::COUNT_START;
        $errorCount = self::COUNT_START;
        foreach ($items as $item) {
            try {
                $output = ['Brand' => $item->getName()];
                $brandDetails = $this->brandModel->getBrandDetails($item->getCode());
                if (isset($brandDetails['brand_id'])) {
                    $brandDataModel = $this->brandData->create();
                    $brandDataModel->setBrandId((int)$brandDetails['brand_id']);
                    $brandDataModel->setName($item->getName());
                    $brandDataModel->setCode($item->getCode());
                    $this->brandRepository->save($brandDataModel);
                    $successCount++;
                    $output['success'] = true;
                    $output['message'] = __('Brand - %1 updated', $item->getName());
                    $response[0]['create'][] = $output;
                    continue;
                } else {
                    $createBrands[] = $item;
                }
            } catch (\Exception $exception) {
                $errorCount++;
                $output['success'] = false;
                $output['message'] = [
                    'msg' => 'Error in updating brand data. ' . $exception->getMessage(),
                    'data' => ['Brand Name' => $item->getName()]
                ];
                $response[0]['update_brand'][] = $output;
                continue;
            }
        }

        $response[0]['brand_items'] = [
            'updated' => $successCount,
            'total' => count($items),
            'errors' => $errorCount
        ];

        if (isset($createBrands) && !empty($createBrands)) {
            $brandItems = $this->brandManagementData->create()->setItems($createBrands);
            $response[0]['create_brand'] = $this->createBrand($brandItems);
        }
        return $response;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function deleteBrand(string $code): array
    {
        $output = [];
        try {
            $brandDetails = $this->brandModel->getBrandDetails($code);
            if (isset($brandDetails['brand_id'])) {
                $this->brandRepository->deleteById((int)$brandDetails['brand_id']);
                $output['success'] = true;
                $output['message'] = __('Brand - %1 deleted', $brandDetails['name']);
            } else {
                throw new LocalizedException(__('Brand %1 does not exists', $code));
            }
        } catch (\Exception $exception) {
            $output['success'] = false;
            $output['message'] = [
                'msg' => 'Error:' . $exception->getMessage(),
                'data' => ['Brand' => $code]
            ];
        }
        return $output;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function getBrand(string $code): array
    {
        $output = [];
        try {
            $brandDetails = $this->brandModel->getBrandDetails($code);
            if (isset($brandDetails['brand_id'])) {
                $entity = $this->brandRepository->getById((int)$brandDetails['brand_id']);
                $output[] = $entity->getData();
            } else {
                throw new LocalizedException(__('Brand %1 does not exists', $code));
            }
        } catch (\Exception $exception) {
            $output['success'] = false;
            $output['message'] = [
                'msg' => 'Error: ' . $exception->getMessage(),
                'data' => ['Brand' => $code]
            ];
        }
        return $output;
    }
}
