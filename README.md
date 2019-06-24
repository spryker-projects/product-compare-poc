# ProductCompare Module

Provides Yves widgets for adding products to a compare list and a page to display the comparison of the product attributes.


## Installation

```
composer config repositories.product-compare git git@github.com:spryker-projects/product-compare-poc.git
composer require spryker-shop/product-compare
```

## Integration

###### Register the following widgets in `getGlobalWidgets`
`Pyz/Yves/ShopApplication/ShopApplicationDependencyProvider::getGlobalWidgets`

```
return [
    ...
    AddToProductCompareListWidget::class,
    RemoveProductFromCompareListWidget::class
    ClearProductCompareListWidget::class,
];
```

###### Add to the controller stack `getControllerProviderStack`
`Pyz/Yves/ShopApplication/YvesBootstrap::getControllerProviderStack`
```
return [
    ...
    new ProductCompareControllerProvider($isSsl),
];
```

###### Add the widget to your project product detail page
`Pyz/Yves/ProductDetailPage/Theme/default/views/pdp/pdp.twig`

```
{% widget 'AddToProductCompareListWidget' args [data.product.sku] only %}{% endwidget %}
```

###### Add the following keys with the proper translation to the project glossary

```
compare.page.title,Artikelvergleich,de_DE
compare.page.title,Compare products,en_US
compare.clear-compare-list,Artikelvergleich leeren,de_DE
compare.clear-compare-list,Clear the list,en_US
compare.add-to-compare-list,Vergleichen,de_DE
compare.add-to-compare-list,Compare,en_US
```

## Copyright

Copyright (c) Spryker Systems GmbH. See LICENSE for details.

This application is released for preview purposes only. It's not meant to be used as a starting point for any project.
