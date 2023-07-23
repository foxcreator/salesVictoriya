<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RetailPriceGreaterThanPurchasePrice implements Rule
{
    private $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function passes($attribute, $value)
    {
        $purchasePrice = request()->input('purchase_price.' . $this->productId);
        return $value > $purchasePrice;
    }

    public function message()
    {
        return 'Цена продажи не может быть меньше цены покупки.';
    }
}
