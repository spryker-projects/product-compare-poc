<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToProductStorageClientInterface;
use SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToSessionClientInterface;
use SprykerShop\Yves\ProductCompare\Model\ProductCompareListManager;
use SprykerShop\Yves\ProductCompare\Model\ProductCompareListManagerInterface;

/**
 * @method \SprykerShop\Yves\ProductCompare\ProductCompareConfig getConfig()
 */
class ProductCompareFactory extends AbstractFactory
{
    /**
     * @return \SprykerShop\Yves\ProductCompare\Session\ProductCompareListManagerInterface
     */
    public function createProductCompareListManager(): ProductCompareListManagerInterface
    {
        return new ProductCompareListManager(
            $this->getSessionClient(),
            $this->getProductStorageClient(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToProductStorageClientInterface
     */
    public function getProductStorageClient(): ProductCompareToProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductCompareDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }

    /**
     * @return \SprykerShop\Yves\ProductCompare\Dependency\Client\ProductCompareToSessionClientInterface
     */
    protected function getSessionClient(): ProductCompareToSessionClientInterface
    {
        return $this->getProvidedDependency(ProductCompareDependencyProvider::CLIENT_SESSION);
    }
}
