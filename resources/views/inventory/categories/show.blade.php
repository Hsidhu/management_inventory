@extends('layouts.app', ['page' => 'Category Information', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Category Information</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Category List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>products</th>
                            <th>Stocks</th>
                            <th>Stocks Faulty</th>
                            <th>Average Price</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->products->count() }}</td>
                                <td>{{ $category->products->map(function ($product) {return $product->balance->stock;})->sum() }}</td>
                                <td>{{ $category->products->map(function ($product) {return $product->balance->stock_defective;})->sum() }}</td>
                                <td>${{ round($category->products->map(function ($product) {return $product->received->avg('price');})->sum(), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">products: {{ $products->count() }}</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Defective Stock</th>
                            <th>Average Price</th>
                            <th>Total sales</th>
                            <th>Income Produced</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><a href="{{ route('products.show', $product) }}">{{ $product->id }}</a></td>
                                    <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->stock_defective }}</td>
                                    <td>{{ format_money($product->solds->avg('price')) }}</td>
                                    <td>{{ $product->solds->sum('qty') }}</td>
                                    <td>{{ format_money($product->solds->sum('total_amount')) }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
