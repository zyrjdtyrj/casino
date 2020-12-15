@extends('layouts.app')

@section('title', 'Prizes awaiting processing')

@section('content')
    <div class="jumbotron text-info">
        @if($message)
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        @if($error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endif
        <form method="POST">
            @csrf
            @if($prizes->count())
                <table class="table table-separate">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambler</th>
                        <th>Prize</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @foreach($prizes as $prize)
                        <tr>
                            <td>{{ $prize->id }}#</td>
                            <td>{{ $prize->getGambler()->name }}</td>
                            <td>{{ $prize->getPrizeName() }}</td>
                            <td>
                                @if( $prize->state == 'wait')
                                    <button class="btn btn-default" name="cancel" type="submit" value="{{ $prize->id }}">
                                        Cancel
                                    </button>
                                    <button class="btn btn-warning" name="cancel" type="submit" value="{{ $prize->id }}">
                                        Send
                                    </button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h3 class="text-default">No waited prizes</h3>
            @endif
        </form>

    </div>
@endsection
