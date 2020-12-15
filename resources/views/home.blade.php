@extends('layouts.app')

@section('title', 'Welcome!')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        @if( $users )
                            <h4>Use any login for <a href="{{ route('login') }}">authorization</a>. Password: password</h4>
                            <ul>
                                @foreach($users as $user)
                                    <li>{{ $user->email }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <b>You can <a href="{{ route('register') }}">registration new user</a></b>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
