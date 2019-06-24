<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Model;

use Generated\Shared\Transfer\ProductViewTransfer;

interface ProductCompareListManagerInterface
{
    /**
     * @param string $concreteSku
     * @param string $localeName
     *
     * @return bool
     */
    public function addToCompareList(string $concreteSku, string $localeName): bool;

    /**
     * @param string $concreteSku
     *
     * @return bool
     */
    public function removeFormCompareList(string $concreteSku): bool;

    /**
     * @param string[] $compareList
     *
     * @return bool
     */
    public function replaceCompareList(array $compareList): bool;

    /**
     * @return bool
     */
    public function clearCompareList(): bool;

    /**
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer[]
     */
    public function getProductsCompareList(string $localeName): array;
}
