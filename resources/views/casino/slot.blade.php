@extends('layouts.app')

@section('title', 'Game slot')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body text-center">

                        @if($message)
                            <h2>You won! <span class="text-info">{{ $message }}</span></h2>
                            <h3><a class='btn btn-warning' href="{{ route('casino') }}">Play again</a></h3>
                            <b><a href="{{ route('casino.prizes') }}">Show my prizes</a></b>
                        @else
                        <form method="POST" >
                            @csrf
                            <button type="submit" class="btn btn-success btn-big ">
                                <h1>PLAY</h1>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
