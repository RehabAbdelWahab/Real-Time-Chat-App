@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1>Messages</h1>
            <h3>Online Users</h3>
            <ul id="online-users">
            </ul>
        </div>
        <div class="col-md-8">
            <h3>Chat</h3>
            <div id="chat">
                    @foreach($messages as $message) 
                    <p>{{ $message->body}}</p>
                    @endforeach
            </div>
        
            <form>
                <input type="text" name="" id="chat-text" data-url="{{ route('messages.store') }}">
                <button>Send</button>
            </form>
        </div>
    </div>
</div>
@endsection