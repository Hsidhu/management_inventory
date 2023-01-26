@extends('layouts.app', ['page' => 'Product Information', 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Product Information</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">Product List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Defective Stock</th>
                            <th>Average Price</th>
                            <th>Total Checkout</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->balance->stock }}</td>
                                <td>{{ $product->balance->stock_defective }}</td>
                                <td>{{ format_money($product->received->avg('price')) }}</td>
                                <td>{{ $product->solds->sum('qty') }}</td>
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
                <div class="card-body">
                    <h4 class="card-title">Latest Checkout</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Sale ID</th>
                            <th>Quantity</th>
                            <th>User</th>
                            <th>Date</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($solds as $sold)
                                <tr>
                                    <td><a href="{{ route('sales.show', $sold->sale_id) }}">{{ $sold->sale_id }}</a></td>
                                    <td>{{ $sold->qty }}</td>
                                    <td>{{ $sold->sale->user->name }}</td>
                                    <td>{{ date('d-m-y', strtotime($sold->created_at)) }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('sales.show', $sold->sale_id) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="View Sale">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Latest Received</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Receipt ID</th>
                            <th>Title</th>
                            <th>Stock</th>
                            <th>Defective Stock</th>
                            <th>Date</th>
                            <th>Total Stock</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($productReceived as $received)
                                <tr>
                                    <td><a href="{{ route('receipts.show', $received->receipt) }}">{{ $received->receipt_id }}</a></td>
                                    <td style="max-width:150px;">{{ $received->receipt->title }}</td>
                                    <td>{{ $received->stock }}</td>
                                    <td>{{ $received->stock_defective }}</td>
                                    <td>{{ date('d-m-y', strtotime($received->created_at)) }}</td>
                                    <td>{{ $received->stock + $received->stock_defective }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('receipts.show', $received->receipt) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver Receipt">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
