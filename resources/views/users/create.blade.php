@extends('backend.layouts.app');

{{-- {{$roles}} --}}
@section('content')

<div class="col-lg-12 mt-1">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Form</h4>
            <!-- Wrap the input fields and submit button within a <form> element -->
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Name:</label>
                    <input class="form-control" type="text" name="name" id="example-text-input" required>
                </div>
                <div class="form-group">
                    <label for="example-search-input" class="col-form-label">email:</label>
                    <input class="form-control" type="email" name="email" id="example-search-email" required>
                </div>
                <div class="form-group">
                    <label for="title">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">

                        @foreach ($roles as $item)
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $item->id }}">
                            {{ $item->name }}
                        </label>

                        @endforeach

                </div>
                <!-- Add more input fields for other fields -->
                <button type="submit" class="btn btn-primary">Insert Data</button>

            </form>
        </div>
    </div>
</div>

@endSection
