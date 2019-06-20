<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare;

use Spryker\Yves\Kernel\AbstractBundleConfig;

class ProductCompareConfig extends AbstractBundleConfig
{
    /**
     * @return int
     */
    public function getMaxItemsInCompareList(): int
    {
        return 3;
    }
}
