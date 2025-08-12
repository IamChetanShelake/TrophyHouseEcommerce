@extends('website.layout.master ')

@section(section: 'content')
<style>
    .chat-box {
        height: 500px;
        overflow-y: auto;
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }
    .message {
        margin-bottom: 15px;
    }
    .message.user {
        text-align: right;
    }
    .message-content {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 15px;
        max-width: 70%;
    }
    .message.user .message-content {
        background-color: #dcf8c6;
    }
    .message.designer .message-content {
        background-color: #fff;
        border: 1px solid #ddd;
    }
</style>

<div class="container my-5">
    <h4 class="mb-4">Chat with {{ $customization->designer->name ?? 'Designer' }}</h4>
    
    <div class="chat-box mb-3" id="chatBox">
        @forelse($customization->messages as $msg)
            <div class="message {{ $msg->sender_id === auth()->id() ? 'user' : 'designer' }}">
                <div class="message-content">
                    {{ $msg->message }}
                    @if($msg->attachment)
                        <br><a href="{{ asset('customizations/' . $msg->attachment) }}" target="_blank">📎 Attachment</a>
                    @endif
                </div>
                <div><small class="text-muted">{{ $msg->sender->name }}  @if($msg->cartItem && $msg->cartItem->product)
    <div class="mb-1">
        <strong>Product:</strong> {{ $msg->cartItem->product->title }}
    </div>
@endif
 </small></div>
            </div>
        @empty
            <p class="text-muted">No messages yet.</p>
        @endforelse
    </div>

    <form action="{{ route('customization.sendMessage', $customization->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <textarea name="message" class="form-control" placeholder="Type a message..." rows="2"></textarea>
        </div>
        <div class="mb-3">
            <input type="file" name="attachment" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
        <a href="{{ route('cartPage') }}" class="btn btn-secondary">Back to Cart</a>
    </form>
</div>

<script>
    window.onload = function () {
        var chatBox = document.getElementById("chatBox");
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    };
</script>
@endsection
