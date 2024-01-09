@extends('layout.layout')

@section('content')
    <div class="container">
        <form action="/login" method="POST">
          @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection