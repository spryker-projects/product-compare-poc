<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductCompare\Dependency\Client;

interface ProductCompareToSessionClientInterface
{
    /**
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function set($name, $value);

    /**
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function remove($name);
}
