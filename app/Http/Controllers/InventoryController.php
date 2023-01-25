<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\ReceivedProduct;
use App\ProductCategory;

class InventoryController extends Controller
{
    public function stats()
    {
        return view('inventory.stats', [
            'categories' => ProductCategory::all(),
            'products' => Product::all(),
            'avgProductPrice' => $this->getProductAvgPrice(),
            'topProductsbyUsedStock' => $this->topProductsbyUsedStock(),
            'topProductsReceivedbyStock' => $this->topProductsReceivedbyStock()
        ]);
    }

    protected function topProductsbyUsedStock()
    {
        return SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty')
        ->whereHas('sale', function ($query) {
            $query->where('finalized_at', '<>' , NULL);
        })
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')->limit(15)->get();
    }

    protected function topProductsReceivedbyStock()
    {
        return ReceivedProduct::selectRaw('product_id, max(created_at), avg(price) as avg_price, sum(stock) as total_qty')
        ->whereHas('receipt', function ($query) {
            $query->where('finalized_at', '<>' , NULL);
        })
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')->limit(15)->get();
    }

    protected function getProductAvgPrice()
    {
        return ReceivedProduct::selectRaw('product_id, max(created_at), avg(price) as avg_price, sum(stock) as total_qty' )
        ->whereHas('receipt', function ($query) {
            $query->where('finalized_at', '<>' , NULL);
        })
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('product_id')
        ->orderBy('avg_price', 'desc')->limit(15)->get();
    }
}
