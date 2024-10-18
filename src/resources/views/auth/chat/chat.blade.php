@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">履歴</div>

                <div class="card-body">
                    <ul>
                        @foreach($messages as $message)
                            <li>{{ $message->message }} ({{ $message->created_at }})</li>
                        @endforeach
                    </ul>

                    <form action="{{ route('chat.store') }}" method="POST">
                        @csrf
                        <input type="text" name="message" class="form-control" placeholder="Type a message">
                        <button type="submit" class="btn btn-primary mt-2">送信</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
