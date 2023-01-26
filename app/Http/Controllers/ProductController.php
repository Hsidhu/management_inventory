<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\ProductBalance;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(25);

        return view('inventory.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('inventory.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest  $request
     * @param  App\Product  $model
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Product $model)
    {

        if($request->hasFile('image_file'))
        {
            $fileNameToStore = $this->uploadImage($request);
            $request->request->add(['image' => $fileNameToStore]);
        }
        if($request->hasFile('document_file'))
        {
            $fileNameToStore = $this->uploadDocument($request);
            $request->request->add(['document' => $fileNameToStore]);
        }

        $product_id = $model->create($request->all())->id;

        ProductBalance::create([
            'product_id' => $product_id
        ]);

        return redirect()
            ->route('products.index')
            ->withStatus('Product successfully registered.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $solds = $product->solds()->latest()->limit(25)->get();

        $productReceived = $product->received()->latest()->limit(25)->get();

        return view('inventory.products.show', compact('product', 'solds', 'productReceived'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return redirect()
            ->route('products.index')
            ->withStatus('Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->withStatus('Product removed successfully.');
    }

    protected function uploadImage($request)
    {
        // Get filename with the extension
        $filenameWithExt = $request->file('image_file')->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('image_file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        
        $path = $request->file('image_file')->storeAs('public/products/images', $fileNameToStore);

        return "products/images/".$fileNameToStore;
    }

    protected function uploadDocument($request)
    {
        // Get filename with the extension
        $filenameWithExt = $request->file('document_file')->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('document_file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        
        $path = $request->file('document_file')->storeAs('public/products/documents', $fileNameToStore);
        
        return "products/documents/".$fileNameToStore;
    }
}
