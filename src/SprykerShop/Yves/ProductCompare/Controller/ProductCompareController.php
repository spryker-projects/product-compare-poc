<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\ProductCompare\Plugin\Provider\ProductCompareControllerProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\ProductCompare\ProductCompareFactory getFactory()
 */
class ProductCompareController extends AbstractController
{
    protected const RESPONSE_PRODUCTS_KEY = 'products';
    protected const RESPONSE_ATTRIBUTES_KEY = 'attributes';

    /**
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(): View
    {
        return $this->view(
            $this->executeIndexAction(),
            [],
            '@ProductCompare/views/product-compare/product-compare.twig'
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addItemAction(Request $request): RedirectResponse
    {
        $this->executeAddItemAction($request);

        return $this->redirectResponseInternal(ProductCompareControllerProvider::ROUTE_PRODUCT_COMPARE);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeItemAction(Request $request): RedirectResponse
    {
        $this->executeRemoveItemAction($request);

        return $this->redirectResponseInternal(ProductCompareControllerProvider::ROUTE_PRODUCT_COMPARE);

    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sortItemsAction(Request $request): RedirectResponse
    {
        $this->executeSortItemsAction($request);

        return $this->redirectResponseInternal(ProductCompareControllerProvider::ROUTE_PRODUCT_COMPARE);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function clearItemsAction(Request $request): RedirectResponse
    {
        $this->executeClearItemsAction();

        return $this->redirectResponseInternal(ProductCompareControllerProvider::ROUTE_PRODUCT_COMPARE);
    }

    /**
     * @return array
     */
    protected function executeIndexAction(): array
    {
        $products = $this->getFactory()
            ->createProductCompareListManager()
            ->getProductsCompareList($this->getLocale());

        return [
            static::RESPONSE_PRODUCTS_KEY => $products,
            static::RESPONSE_ATTRIBUTES_KEY => $this->collectAttributes($products),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer[] $productViewTransfers
     *
     * @return array
     */
    protected function collectAttributes(array $productViewTransfers): array
    {
        $attributes = [];
        foreach ($productViewTransfers as $productViewTransfer) {
            $attributes = array_merge($attributes, array_keys($productViewTransfer->getAttributes()));
        }

        return array_unique($attributes);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function executeAddItemAction(Request $request): void
    {
        $concreteSku = $this->getSkuFromQurery($request);

        if ($this->getFactory()->createProductCompareListManager()->addToCompareList($concreteSku, $this->getLocale())) {
            $this->addSuccessMessage('page.product-compare-added-to-list');

            return;
        }

        $this->addErrorMessage('page.product-compare-not-added-to-list');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function executeRemoveItemAction(Request $request): void
    {
        $concreteSku = $this->getSkuFromQurery($request);

        if ($this->getFactory()->createProductCompareListManager()->removeFormCompareList($concreteSku)) {
            $this->addSuccessMessage('page.product-compare-removed-from-list');

            return;
        }

        $this->addErrorMessage('page.product-compare-not-removed-from-list');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function executeSortItemsAction(Request $request): void
    {
        $concreteSkus = $request->request->get('skus');

        $this->getFactory()
            ->createProductCompareListManager()
            ->replaceCompareList($concreteSkus);
    }

    /**
     * @return void
     */
    protected function executeClearItemsAction(): void
    {
        if ($this->getFactory()->createProductCompareListManager()->clearCompareList()) {
            $this->addSuccessMessage('page.product-compare-cleared-list');

            return;
        }

        $this->addErrorMessage('page.product-compare-list-not-cleared');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string
     */
    protected function getSkuFromQurery(Request $request): string
    {
        return $request->request->get('sku');
    }
}
