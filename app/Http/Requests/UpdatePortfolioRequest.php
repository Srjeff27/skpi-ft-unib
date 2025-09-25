<?php

namespace App\Http\Requests;

class UpdatePortfolioRequest extends StorePortfolioRequest
{
    public function authorize(): bool
    {
        $portfolio = $this->route('portfolio');
        return $portfolio && $this->user()->can('update', $portfolio);
    }
}