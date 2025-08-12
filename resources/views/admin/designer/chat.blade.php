    @extends('admin.designer.layouts.master')

@section('content')
<style>
    .chat-container {
        display: flex;
        height: 80vh;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }
    .chat-sidebar {
        width: 300px;
        background: #f8f9fa;
        border-right: 1px solid #ddd;
        padding: 20px;
        overflow-y: auto;
    }
    .chat-users {
        list-style: none;
        padding: 0;
    }
    .chat-users li {
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .chat-users li.active,
    .chat-users li:hover {
        background-color: #dfeeff;
    }
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #eef3f9;
        position: relative;
    }
    .chat-header {
        padding: 15px;
        background: #fff;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }
    .message {
        max-width: 100%;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 20px;
        position: relative;
        word-wrap: break-word;
        font-size: 15px;
           display: flex;
    }
    .message.me {
        background-color: #648ed0;
        color: white;
        display:flex;
        justify-content: flex-end;
        border-bottom-right-radius: 0;
    }
    .message.them {
        background-color: #e2e2e2;
        color: #333;
        display:flex;
        justify-content: flex-start;
        border-bottom-left-radius: 0;
    }
    .chat-input-area {
        padding: 10px;
        background: #fff;
        border-top: 1px solid #ddd;
        display: flex;
        gap: 10px;
    }
    .chat-input-area textarea {
        flex: 1;
        resize: none;
        border-radius: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }
    .chat-input-area button {
        border: none;
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
    }
</style>

<div class="chat-container">
    {{-- Sidebar --}}
    <div class="chat-sidebar">
        <h5>💬 Chats</h5>
        <ul class="chat-users">
            @foreach($users as $user)
                <li class="{{ $activeUser && $activeUser->id === $user->id ? 'active' : '' }}">
<a class="nav-link {{ request()->is('designer/chats') ? 'active' : '' }}" href="{{ route('chats', ['userId' => $user->id ?? '' ]) }}">
                        {{ $user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Chat Window --}}
    <div class="chat-main">
        <div class="chat-header">
            {{ $activeUser->name ?? 'Select a user to start chatting' }} 
        </div>

        <div class="chat-messages" id="chatBox">
           
            @if($messages)
               
                @foreach($messages as $msg)
               
                 {{-- Check if related cart item and product exist before accessing title --}}
            @if(optional($msg->cartItem)->product)
                <div><strong>Product:</strong> {{ $msg->cartItem->product->title }}</div>
            @endif
                    <div class="message {{ $msg->sender_id === auth()->id() ? 'me' : 'them' }}">
                        @if($msg->message)
                        {{ $msg->message }}
                        @endif
                        @if($msg->attachment)
                        <a href="{{ asset('customizations/'.$msg->attachment) }}" target="_blank">📎 Attachment</a>
                        @endif
                        <!--<div><small class="text-muted">{{ $msg->sender->name }} - {{ $msg->sent_at->format('h:i A') }}</small></div>-->
                    </div>
                @endforeach
            @endif
        </div>

        @if($activeUser)
        <form action="{{ route('send.message', $activeUser->id) }}" method="POST" class="chat-input-area" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3 align-items-center">
        <!-- Textarea -->
        <div class="col-md-5">
            <textarea name="message" rows="1" placeholder="Type a message..." required class="form-control"></textarea>
        </div>

        <!-- File Input -->
        <div class="col-md-5">
            <input type="file" name="attachment" class="form-control">
        </div>

        <!-- Send Button -->
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Send</button>
        </div>
    </div>
        </form>
        @endif
    </div>
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
