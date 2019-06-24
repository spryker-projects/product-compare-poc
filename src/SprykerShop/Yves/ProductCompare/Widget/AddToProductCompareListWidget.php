<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Widget;

use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\ProductCompare\ProductCompareFactory getFactory()
 */
class AddToProductCompareListWidget extends AbstractWidget
{
    /**
     * @param string $sku
     *
     * @return void
     */
    public function __construct(string $sku)
    {
        $this->addParameter('sku', $sku);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return substr(strrchr(static::class, '\\'), 1);
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@ProductCompare/widget/product-compare/product-compare-add.twig';
    }
}
