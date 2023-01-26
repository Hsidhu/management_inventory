@extends('layouts.app', ['page' => 'Edit Product', 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit Product</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('products.update', $product) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">Product Information</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $product->name) }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>

                                <div class="form-group{{ $errors->has('product_category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Category</label>
                                    <select name="product_category_id" id="input-category" class="form-select form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" required>
                                        @foreach ($categories as $category)
                                            @if($category['id'] == old('document') or $category['id'] == $product->product_category_id)
                                                <option value="{{$category['id']}}" selected>{{$category['name']}}</option>
                                            @else
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_category_id'])
                                </div>


                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">Description</label>
                                    <input type="text" name="description" id="input-description" class="form-control form-control-alternative" placeholder="Description" value="{{ old('description', $product->description) }}" required>
                                    @include('alerts.feedback', ['field' => 'description'])

                                </div>
                                <div class="row">
                                    <div class="col-4">                                    
                                        <div class="form-group{{ $errors->has('alert_level') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-alert_level">alert_level</label>
                                            <input type="number" name="alert_level" id="input-alert_level" class="form-control form-control-alternative" placeholder="alert_level" value="{{ old('alert_level', $product->alert_level) }}" required>
                                            @include('alerts.feedback', ['field' => 'alert_level'])
                                        </div>
                                    </div>                            
                                    <div class="col-4">                                    
                                        <div class="form-group{{ $errors->has('barcode') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-barcode">barcode</label>
                                            <input type="number" name="barcode" id="input-barcode" class="form-control form-control-alternative" placeholder="barcode" value="{{ old('barcode', $product->barcode) }}" >
                                            @include('alerts.feedback', ['field' => 'barcode'])
                                        </div>
                                    </div>
                                    <div class="col-4">                                 
                                        <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-reference">Reference/SKU#</label>
                                            <input type="text" step=".01" name="reference" id="input-reference" class="form-control form-control-alternative" placeholder="reference" value="{{ old('reference', $product->reference) }}">
                                            @include('alerts.feedback', ['field' => 'reference'])
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="{{ $errors->has('image_file') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-price">Image</label>
                                            <input type="file" step=".01" name="image_file" id="input-image" class="form-control form-control-alternative" placeholder="image_file" value="{{ old('image_file', $product->image_file) }}">
                                            @include('alerts.feedback', ['field' => 'image_file'])
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="{{ $errors->has('document_file') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-document_file">Document</label>
                                            <input type="file" step=".01" name="document_file" id="input-document_file" class="form-control form-control-alternative" placeholder="document_file" value="{{ old('document_file', $product->document_file) }}">
                                            @include('alerts.feedback', ['field' => 'document_file'])
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        new SlimSelect({
            select: '.form-select'
        })
    </script>
@endpush