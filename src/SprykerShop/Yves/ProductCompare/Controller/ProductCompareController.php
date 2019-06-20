<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\ProductCompare\ProductCompareFactory getFactory()
 */
class ProductCompareController extends AbstractController
{
    protected const RESPONSE_SUCCESS_KEY = 'success';
    protected const RESPONSE_PRODUCTS_KEY = 'products';

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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addItemAction(Request $request): JsonResponse
    {
        return $this->jsonResponse(
            $this->executeAddItemAction()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeItemAction(Request $request): JsonResponse
    {
        return $this->jsonResponse(
            $this->executeRemoveItemAction()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sortItemsAction(Request $request): JsonResponse
    {
        return $this->jsonResponse(
            $this->executeSortItemsAction()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function clearItemsAction(Request $request): JsonResponse
    {
        return $this->jsonResponse(
            $this->executeClearItemsAction()
        );
    }

    /**
     * @return array
     */
    protected function executeIndexAction(): array
    {
        return [
            static::RESPONSE_PRODUCTS_KEY => $this->getFactory()
                ->createProductCompareListManager()
                ->getProductsToCompare($this->getLocale())
        ];
    }

    /**
     * @return array
     */
    protected function executeAddItemAction(): array
    {
        $concreteSku = $request->query->get('sku');

        return [
            static::RESPONSE_SUCCESS_KEY => $this->getFactory()
                ->createProductCompareListManager()
                ->addToCompareList($concreteSku)
        ];
    }

    /**
     * @return array
     */
    protected function executeRemoveItemAction(): array
    {
        $concreteSku = $request->query->get('sku');

        return [
            static::RESPONSE_SUCCESS_KEY => $this->getFactory()
                ->createProductCompareListManager()
                ->removeFormCompareList($concreteSku)
        ];
    }

    /**
     * @return array
     */
    protected function executeSortItemsAction(): array
    {
        $concreteSkus = $request->query->get('skus');

        return [
            static::RESPONSE_SUCCESS_KEY => $this->getFactory()
                ->createProductCompareListManager()
                ->replaceCompareList($concreteSkus)
        ];
    }

    /**
     * @return array
     */
    protected function executeClearItemsAction(): array
    {
        return [
            static::RESPONSE_SUCCESS_KEY => $this->getFactory()
                ->createProductCompareListManager()
                ->clearCompareList()
        ];
    }
}
