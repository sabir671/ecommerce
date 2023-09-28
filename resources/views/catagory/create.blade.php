@extends('backend.layouts.app')

@section('page_title')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Roles</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{ route('catagories.index') }}">catagories</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="col-lg-12 mt-1">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Form</h4>
            <!-- Wrap the input fields and submit button within a <form> element -->
            <form method="POST" action="{{ route('catagories.store') }}">
                @csrf
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Name:</label>
                    <input class="form-control" type="text" name="name" id="example-text-input" required>
                </div>
                <div class="form-group">
                    <label for="example-search-input" class="col-form-label">status:</label>
                    <input class="form-control" type="text" name="status" id="example-search-input" required>
                </div>
                <div class="form-group">
                    <label for="example-email-input" class="col-form-label">parent_id:</label>
                    <input class="form-control" type="number" name="parent_id" id="example-email-input" required>
                </div>

                {{-- Add your permissions-related code here if needed --}}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

