@extends('layouts.app', ['page' => 'Income', 'pageSlug' => 'incomes', 'section' => 'transactions'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Checkout</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn btn-sm btn-primary">Register Income</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">Date</th>
                                <th scope="col">Product name</th>
                                <th scope="col">Qty</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td> {{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                                        <td> {{ $transaction->soldProduct->product->name }}</td>
                                        <td>{{ $transaction->qty }}</td>
                                        <td class="td-actions text-right">
                                            @if ($transaction->sale_id)
                                                <a href="{{ route('sales.show', $transaction->sale_id) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                                    <i class="tim-icons icon-zoom-split"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Income">
                                                    <i class="tim-icons icon-pencil"></i>
                                                </a>
                                                <form action="{{ route('transactions.destroy', $transaction) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Income" onclick="confirm('Are you sure you want to delete this entry? There will be no record left.') ? this.parentElement.submit() : ''">
                                                        <i class="tim-icons icon-simple-remove"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $transactions->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
