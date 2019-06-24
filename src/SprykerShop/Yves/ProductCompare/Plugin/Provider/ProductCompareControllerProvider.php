<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ProductCompare\Plugin\Provider\PriceControllerProvider;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

class ProductCompareControllerProvider extends AbstractYvesControllerProvider
{
    public const ROUTE_PRODUCT_COMPARE = 'product-compare/overview';
    public const ROUTE_PRODUCT_COMPARE_ADD_ITEM = 'product-compare/add-item';
    public const ROUTE_PRODUCT_COMPARE_REMOVE_ITEM = 'product-compare/remove-item';
    public const ROUTE_PRODUCT_COMPARE_SORT_ITEMS = 'product-compare/sort-items';
    public const ROUTE_PRODUCT_COMPARE_CLEAR_ITEMS = 'product-compare/clear-items';

    protected const PRODUCT_COMPARE_DEFAULT = 'product-compare';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->addProductCompareRoute()
            ->addProductCompareAddItemRoute()
            ->addProductCompareRemoveItemRoute()
            ->addProductCompareSortItemsRoute()
            ->addProductCompareClearItemsRoute();
    }

    /**
     * @return $this
     */
    protected function addProductCompareRoute()
    {
        $this->createGetController('/{productCompare}', static::ROUTE_PRODUCT_COMPARE, 'ProductCompare', 'ProductCompare', 'index')
            ->assert('productCompare', $this->getProductCompareResourcePath())
            ->value('productCompare', static::PRODUCT_COMPARE_DEFAULT);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addProductCompareAddItemRoute()
    {
        $this->createPostController('/{productCompare}/add-item', static::ROUTE_PRODUCT_COMPARE_ADD_ITEM, 'ProductCompare', 'ProductCompare', 'addItem')
            ->assert('productCompare', $this->getProductCompareResourcePath())
            ->value('productCompare', static::PRODUCT_COMPARE_DEFAULT);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addProductCompareRemoveItemRoute()
    {
        $this->createPostController('/{productCompare}/remove-item', static::ROUTE_PRODUCT_COMPARE_REMOVE_ITEM, 'ProductCompare', 'ProductCompare', 'removeItem')
            ->assert('productCompare', $this->getProductCompareResourcePath())
            ->value('productCompare', static::PRODUCT_COMPARE_DEFAULT);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addProductCompareSortItemsRoute()
    {
        $this->createPostController('/{productCompare}/sort-items', static::ROUTE_PRODUCT_COMPARE_SORT_ITEMS, 'ProductCompare', 'ProductCompare', 'sortItems')
            ->assert('productCompare', $this->getProductCompareResourcePath())
            ->value('productCompare', static::PRODUCT_COMPARE_DEFAULT);

        return $this;
    }

    /**
     * @return $this
     */
    protected function addProductCompareClearItemsRoute()
    {
        $this->createPostController('/{productCompare}/clear-items', static::ROUTE_PRODUCT_COMPARE_CLEAR_ITEMS, 'ProductCompare', 'ProductCompare', 'clearItems')
            ->assert('productCompare', $this->getProductCompareResourcePath())
            ->value('productCompare', static::PRODUCT_COMPARE_DEFAULT);

        return $this;
    }

    /**
     * @return string
     */
    protected function getProductCompareResourcePath(): string
    {
        return $this->getAllowedLocalesPattern() . 'product-compare|product-compare';
    }
}
