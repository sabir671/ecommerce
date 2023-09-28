@extends('backend.layouts.app');

@section('content')
    <form method="POST" action="{{ route('roles.store') }}">
    @csrf

   <input type="text" name="name" placeholder="enter Your name" Class=''><br/>
    <input type="text" name="title" placeholder="enter your title"><br/>
    <input type="text" name="guard_name" placeholder="enter your guard_name"><br/>
    <!-- Add more input fields for other fields -->
    <button type="submit" class="btn btn-primary">Insert Data</button>
    </form>
@endSection
