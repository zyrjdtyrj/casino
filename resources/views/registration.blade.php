@extends('layout')

@section('title', 'Registration')

@section('body')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @enderror

    <form method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Login</label>
            <input id='name' value="{{ old('name') }}" name="name" type="text" class="form-control"  placeholder="Login name">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Password</label>
            <input id='password' value="{{ old('password') }}" name="password" type="password" class="form-control"  placeholder="Password">
        </div>
        <div class="mb-3">
            <input name="submit" type="submit" class="btn btn-warning" value="Registration">
        </div>
    </form>
@endsection
