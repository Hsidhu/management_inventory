<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionType;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::latest()->paginate(25);

        return view('sales.index', compact('sales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $model)
    {
        
        $sale = $model->create($request->all());
        
        return redirect()
            ->route('sales.show', ['sale' => $sale->id])
            ->withStatus('Sale registered successfully, you can start registering products and transactions.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withStatus('The sale record has been successfully deleted.');
    }

    public function finalize(Sale $sale)
    {

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->balance->stock;
            if($sold_product->qty > $product_stock) 
                return back()->withError("The product '$product_name' does not have enough stock. Only has $product_stock units.");
        }

        foreach ($sale->products as $sold_product) {
            $sold_product->product->balance->stock -= $sold_product->qty;
            $sold_product->product->balance->save();

            // add products to transection
            Transaction::create([
                'type' => TransactionType::ITEM_CHECKEDOUT,
                'sold_product_id' => $sold_product->id,
                'user_id' => \Auth::id(),
                'qty' => $sold_product->qty
            ]);
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->save();

        return back()->withStatus('The sale has been successfully completed.');
    }

    public function addproduct(Sale $sale)
    {
        $products = Product::all();

        return view('sales.addproduct', compact('sale', 'products'));
    }

    public function storeproduct(Request $request, Sale $sale, SoldProduct $soldProduct)
    {
        $product = Product::where('id', $request->get('product_id'))->first();

        if($request->get('qty') > $product->balance->stock) 
                return back()->withError("The product '$product->name' does not have enough stock. Only has ".$product->balance->stock." units.");
        return;

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->balance->stock;
            }


        $soldProduct->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus('Product successfully registered.');
    }

    public function editproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request, Sale $sale, SoldProduct $soldproduct)
    {
        $soldproduct->update($request->all());

        return redirect()->route('sales.show', $sale)->withStatus('Product successfully modified.');
    }

    public function destroyproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $soldproduct->delete();

        return back()->withStatus('The product has been disposed of successfully.');
    }

}
