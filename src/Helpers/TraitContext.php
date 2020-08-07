<?php

namespace PrestaShop\Module\Kb_Config\Helpers;

use Product;
use Context;

/**
 *
 */
trait TraitContext
{
    public function getProductData($id_product)
    {
        $id_lang = Context::getContext()->language->id;
        return [
            'product_name' => Product::getProductName($id_product, null, $id_lang)
        ];
    }
}
