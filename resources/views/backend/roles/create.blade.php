@extends('backend.layouts.app')

@section('page_title')
    <div class="breadcrumbs-area clearfix">
        <h4 class="page-title pull-left">Roles</h4>
        <ul class="breadcrumbs pull-left">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><span>Roles</span></li>
        </ul>
    </div>
@endsection

@section('content')
<div class="col-lg-12 mt-1">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Form</h4>
            <!-- Wrap the input fields and submit button within a <form> element -->
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Name:</label>
                    <input class="form-control" type="text" name="name" id="example-text-input" required>
                </div>
                <div class="form-group">
                    <label for="example-search-input" class="col-form-label">Title:</label>
                    <input class="form-control" type="text" name="title" id="example-search-input" required>
                </div>
                <div class="form-group">
                    <label for="example-email-input" class="col-form-label">Guard_Name:</label>
                    <input class="form-control" type="text" name="guard_name" id="example-email-input" required>
                </div>
                <div class="form-group text-center">
                    <p><strong>Permissions</strong></p>
                    @foreach ($permission as $item)
                        <div style="margin-bottom: 10px;">
                            <input type="checkbox" value="{{ $item->id }}" id="permission{{ $item->id }}" name="permissions[]">
                            <label for="permission{{ $item->id }}" style="margin:auto;text-align:center;">{{ $item->title }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
