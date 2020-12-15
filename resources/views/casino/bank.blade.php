@extends('layouts.app')

@section('title', 'Casino bank')

@section('content')
    <div class="jumbotron text-info ">
        <h2>Money bank: {{ $moneyBank }}$</h2>
        <hr/>
        @if(count($gifts))
            <h2>Gifts available:</h2>
            <table class="table table-separated">
                @foreach($gifts as $gift)
                    <tr>

                        <td class="col-sm-9">{{ $gift->name }}</td>
                        <th class="col-sm-3">{{ $gift->amount }}</th>
                    </tr>
                @endforeach
            </table>
        @else
            <h2>No gifts</h2>
        @endif
    </div>
@endsection
