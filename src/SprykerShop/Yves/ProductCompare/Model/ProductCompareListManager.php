<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Model;

use SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToProductStorageClientInterface;
use SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToSessionClientInterface;
use SprykerShop\Yves\ProductCompare\ProductCompareConfig;

class ProductCompareListManager implements ProductCompareListManagerInterface
{
    protected const SESSION_KEY = 'COMPARE_LIST';
    protected const COMPARE_LIST_DELIMITER = ',';
    protected const MAPPING_TYPE_SKU = 'sku';

    /**
     * @var \SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToSessionClientInterface
     */
    protected $sessionClient;

    /**
     * @var \SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToProductStorageClientInterface
     */
    protected $productStorageClient;

    /**
     * @var \SprykerShop\Yves\ProductCompare\ProductCompareConfig
     */
    protected $productCompareConfig;

    /**
     * @param \SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToSessionClientInterface $sessionClient
     * @param \SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToProductStorageClientInterface $productStorageClient
     * @param \SprykerShop\Yves\ProductCompare\ProductCompareConfig $productCompareConfig
     *
     * @return void
     */
    public function __construct(
        ProductCompareToSessionClientInterface $sessionClient,
        ProductCompareToProductStorageClientInterface $productStorageClient,
        ProductCompareConfig $productCompareConfig
    ) {
        $this->sessionClient = $sessionClient;
        $this->productStorageClient = $productStorageClient;
        $this->productCompareConfig = $productCompareConfig;
    }

    /**
     * @param string $concreteSku
     * @param string $localeName
     *
     * @return bool
     */
    public function addToCompareList(string $concreteSku, string $localeName): bool
    {
        if ($concreteSku === '') {
            return false;
        }

        if (!$this->isValidSku($concreteSku, $localeName)) {
            return false;
        }

        $compareList = $this->getCompareListSkus();
        $compareList[] = $concreteSku;

        return $this->replaceCompareList($compareList);
    }

    /**
     * @param string $concreteSku
     *
     * @return bool
     */
    public function removeFormCompareList(string $concreteSku): bool
    {
        $compareList = $this->getCompareListSkus();
        $compareList = array_diff($compareList, [$concreteSku]);

        return $this->replaceCompareList($compareList);
    }

    /**
     * @param string[] $compareList
     *
     * @return bool
     */
    public function replaceCompareList(array $compareList): bool
    {
        $compareList = array_unique(array_filter($compareList));
        if (count($compareList) > $this->productCompareConfig->getMaxItemsInCompareList()) {
            return false;
        }

        $this->sessionClient->set(static::SESSION_KEY, implode(static::COMPARE_LIST_DELIMITER, $compareList));

        return true;
    }

    /**
     * @return bool
     */
    public function clearCompareList(): bool
    {
        $this->sessionClient->remove(static::SESSION_KEY);

        return true;
    }

    /**
     * @param string $localeName
     *
     * @return Generated\Shared\Transfer\ProductViewTransfer[]
     */
    public function getProductsCompareList(string $localeName): array
    {
        $compareList = $this->getCompareListSkus();

        $productViewTransfers = [];
        foreach ($compareList as $concreteSku) {
            $productConcreteData = $this->productStorageClient->findProductConcreteStorageDataByMapping(static::MAPPING_TYPE_SKU, $concreteSku, $localeName);
            if ($productConcreteData === null) {
                continue;
            }

            $productConcreteData['attributeMap'] = [];
            $productViewTransfers[] = $this->productStorageClient->mapProductStorageData($productConcreteData, $localeName);
        }

        return $productViewTransfers;
    }

    /**
     * @param string $concreteSku
     * @param string $localeName
     *
     * @return bool
     */
    protected function isValidSku(string $concreteSku, string $localeName): bool
    {
        return $this->productStorageClient->findProductConcreteStorageDataByMapping(static::MAPPING_TYPE_SKU, $concreteSku, $localeName) !== null;
    }

    /**
     * @return string[]
     */
    protected function getCompareListSkus(): array
    {
        $compareList = $this->sessionClient->get(static::SESSION_KEY);

        if ($compareList === null) {
            return [];
        }

        $compareList = explode(static::COMPARE_LIST_DELIMITER, $compareList);

        return $compareList;
    }
}
