@extends('layouts.app', ['pageSlug' => 'tstats', 'page' => 'Statistics', 'section' => 'transactions'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Transaction Statistics</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-primary">
                                View Transactions
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>Period</th>
                                <th>Transactions</th>
                                <th>Checkout</th>
                                <th>Received</th>
                                <th>Total balance</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($transactionsperiods as $period => $data)
                                    <tr>
                                        <td>{{ $period }}</td>
                                        <td>{{ $data->count() }}</td>
                                        <td>{{ $data->where('type', 'item_sold')->sum('qty') }}</td>
                                        <td>{{ $data->where('type', 'item_received')->sum('qty') }}</td>
                                        <td>{{ $data->sum('qty') }}</td>
                                        <td></td>
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
            <div class="card card-tasks">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Provider Cost</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <thead>
                                <th>Provider</th>
                                <th>Purchases</th>
                                <th>Number of Product</th>
                                <th>Total money spend</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($providers as $provider)
                                    <?php
                                    $productNum=0;
                                    $cost=0;
                                        foreach($provider->receipts as $receipt)
                                        {
                                            $productNum += $receipt->numberOfProducts();
                                            $cost += $receipt->receiptTotal();
                                        }
                                    ?>
                                    <tr>
                                        <td><a href="{{ route('providers.show', $provider) }}">{{ $provider->name }}</a></td>
                                        <td>{{ $provider->receipts->count() }}</td>
                                        <td>{{ $productNum ?? 0 }}</td>
                                        <td>{{ format_money($cost ?? 0) }}</td>
                                        <td>
                                            <a href="{{ route('providers.show', $provider) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="See Provider">
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

    </div>

    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Checkout Statistics</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">View Checkouts</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Period</th>
                        <th>Sales</th>
                        <th>Qty</th>
                        <th>To Finalize</th>
                    </thead>
                    <tbody>
                        @foreach ($salesperiods as $period => $data)
                            <tr>
                                <td>{{ $period }}</td>
                                <td>{{ $data->count() }}</td>
                                <td>{{ $data->where('finalized_at', '!=', null)->map(function ($sale) {return $sale->products->sum('qty');})->sum() }}</td>
                                <td>{{ $data->where('finalized_at', null)->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
@endsection
