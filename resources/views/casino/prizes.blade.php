@extends('layouts.app')

@section('title', 'My prizes')

@section('content')
    <div class="jumbotron text-info">
        @if($message)
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        @if($error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endif
            <h2>Bonus balance: {{ $bonusBalance }}</h2>
            <hr/>
        <form method="POST">
            @csrf
            @if($prizes->count())
                @foreach($prizes as $prize)
                    <div class="row">
                        <h3 class="col-sm-6 col-sx-12">{{ $prize->getPrizeName() }}</h3>
                        <h3 class="col-sm-3 col-sx-12 text-right">{{ $prize->state }}</h3>
                        <div class="col-sm-3 col-sx-12 text-right">
                            @if( $prize->state == 'wait')
                                <button class="btn btn-info" name="cancel" type="submit" value="{{ $prize->id }}">
                                    Cancel
                                </button>
                                @if( $prize->type == 'Money')
                                    <button class="btn btn-warning" name="convert" type="submit" value="{{ $prize->id }}">
                                        Convert to bonus
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                    <hr/>
                @endforeach
            @else
                <h3 class="text-default">No prizes</h3>
            @endif
        </form>

    </div>
@endsection
