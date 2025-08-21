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
            justify-content: flex-end;
            border-bottom-right-radius: 0;
        }

        .message.them {
            background-color: #e2e2e2;
            color: #333;
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

        /* Chat input panel */
        .chat-input {
            display: flex;
            /* horizontal alignment */
            padding: 10px 15px;
            /* spacing */
            background: #f9f9f9;
            /* light background */
            border-top: 1px solid #ccc;
            /* separation line */
        }

        /* Textarea (message box) */
        .chat-input textarea {
            flex: 1;
            /* take full remaining width */
            resize: none;
            /* disable resize */
            border-radius: 25px;
            /* pill-shaped */
            padding: 10px 15px;
            /* inside spacing */
            border: 1px solid #ccc;
            margin-right: 10px;
            font-size: 14px;
        }

        /* Hide actual file input */
        .chat-input input[type="file"] {
            display: none;
        }

        /* Attachment icon */
        .attach-label {
            background: #eee;
            /* grey circle */
            padding: 8px 12px;
            border-radius: 50%;
            /* round button */
            cursor: pointer;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Send button */
        .chat-input button {
            background: #667eea;
            /* purple gradient */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            /* pill shape */
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        /* Hover effect */
        .chat-input button:hover {
            background: #556cd6;
        }
    </style>

    <a href="{{ url()->previous() }}" class="btn btn-dark mb-3" style="display:inline-block; width:20%; ">
        ← Back</a>
    <div class="chat-container">
        {{-- Sidebar --}}
        <div class="chat-sidebar">
            <h5>💬 Product Chats</h5>
            <ul class="chat-users">
                @foreach ($customizations as $cust)
                    <li
                        class="{{ $activeCustomization && $activeCustomization->id === $cust->id ? 'active text-black' : '' }}">
                        <a href="{{ route('chats', ['customizationRequestId' => $cust->id]) }}"
                            style="    text-decoration: none;">
                            {{ $cust->cartItem?->product->title ?? ($cust->paymentItem?->product->title ?? 'Unknown Product') }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Chat Window --}}
        <div class="chat-main">
            <div class="chat-header">
                {{ $activeCustomization->cartItem?->product->title ?? ($activeCustomization->paymentItem?->product->title ?? 'Select a product') }}
                - {{ $orderId }}
            </div>

            <div class="chat-messages" id="chatBox">
                @foreach ($messages as $msg)
                    <div class="message {{ $msg->sender_id === auth()->id() ? 'me' : 'them' }}">
                        @if ($msg->message)
                            {{ $msg->message }}
                        @endif
                        @if ($msg->attachment)
                            <a href="{{ asset('customizations/' . $msg->attachment) }}" target="_blank">
                                <img src="{{ asset('customizations/' . $msg->attachment) }}" alt="Attachment"
                                    width="120">
                            </a>
                        @endif
                        <div class="m-1">
                            @if ($msg->is_approved == 1)
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- @if ($activeCustomization)
                <form action="{{ route('send.message', $activeCustomization->id) }}" method="POST"
                    enctype="multipart/form-data" class="chat-input-area">
                    @csrf
                    <textarea name="message" placeholder="Type a message..." required></textarea>
                    <input type="file" name="attachment">
                    <button type="submit">Send</button>
                </form>
            @endif --}}
            @if ($activeCustomization)
                <form action="{{ route('send.message', $activeCustomization->id) }}" method="POST"
                    enctype="multipart/form-data" class="chat-input">
                    @csrf

                    <!-- Attachment button -->
                    <label for="attachment" class="attach-label" title="Attach File">📎</label>
                    <input type="file" name="attachment" id="attachment">

                    <!-- Message box -->
                    <textarea name="message" placeholder="Type a message..." rows="1"></textarea>

                    <!-- Send button -->
                    <button type="submit">Send</button>
                </form>
            @endif
        </div>

        <script>
            window.onload = function() {
                var chatBox = document.getElementById("chatBox");
                if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
            };
        </script>
    @endsection
