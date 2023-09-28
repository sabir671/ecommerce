@extends('backend.layouts.app')

@section('page_title')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Roles</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{ route('products.index') }}">Products</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="col-lg-12 mt-1">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Form</h4>
            <!-- Wrap the input fields and submit button within a <form> element -->
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Name:</label>
                    <input class="form-control" type="text" name="name" id="example-text-input" required>
                </div>
                <div class="form-group">
                    <label for="example-search-input" class="col-form-label">Product price:</label>
                    <input class="form-control" type="number" name="price" id="example-search-input" required>
                </div>
                <div class="form-group">
                    <label for="example-email-input" class="col-form-label">Discount:</label>
                    <input class="form-control" type="number" name="discount" id="example-email-input" required>
                </div>
                <div class="form-group">
                    <label for="example-email-input" class="col-form-label">Catagory ID:</label>
                </div>
                <div class="dropdown">
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a Product</option> <!-- Default empty option -->
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
