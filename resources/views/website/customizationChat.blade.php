@extends('website.layout.master')

@section('content')
    <style>
        /* Container for the chat page */
        .chat-container {
            max-width: 800px;
            margin: 50px auto;
            background: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 60vh;
            overflow: hidden;
        }

        /* Chat header */
        .chat-header {
            background: #667eea;
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Chat messages panel */
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #e5ddd5;
        }

        .message {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            /* max-width: 70%; */
        }

        .message.user {
            align-self: flex-end;
            text-align: right;
        }

        .message.designer {
            align-self: flex-start;
        }

        .message-content {
            padding: 10px 15px;
            border-radius: 20px;
            position: relative;
            word-wrap: break-word;
        }

        .message.user .message-content {
            background: #dcf8c6;
            border-bottom-right-radius: 0;
        }

        .message.designer .message-content {
            background: #fff;
            border: 1px solid #ddd;
            border-bottom-left-radius: 0;
        }

        .message-info {
            font-size: 12px;
            color: #555;
            margin-top: 3px;
        }

        /* Chat input panel */
        .chat-input {
            display: flex;
            padding: 10px 15px;
            background: #f9f9f9;
            border-top: 1px solid #ccc;
        }

        .chat-input textarea {
            flex: 1;
            resize: none;
            border-radius: 25px;
            padding: 10px 15px;
            border: 1px solid #ccc;
            margin-right: 10px;
            font-size: 14px;
        }

        .chat-input input[type="file"] {
            display: none;
        }

        .attach-label {
            background: #eee;
            padding: 8px 12px;
            border-radius: 50%;
            cursor: pointer;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-input button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .chat-input button:hover {
            background: #556cd6;
        }

        .zoom-image:hover {
            transform: scale(2.5);
            /* zoom level */
            z-index: 999;
            position: absolute;
            top: -50px;
            /* adjust so zoom doesn't push layout */
            left: 70px;
            /* adjust position to show enlarged image */
            border: 2px solid #333;
            background: #fff;
        }
    </style>

    <div class="chat-container">
        <div class="chat-header">

            <a href="{{ route('my.orders') }}" style="color:white; text-decoration:none; font-size:14px;"> <- Back to My
                    Orders</a>
                    Chatting with - {{ $customization->designer->name ?? 'Designer' }}
                    <small>
                        Product:
                        {{ $customization->cartItem?->product->title ?? ($customization->paymentItem?->product->title ?? 'Unknown Product') }}
                        @php
                            $product = $customization->cartItem?->product ?? $customization->paymentItem?->product;
                        @endphp

                        @if ($product && $product->image)
                            <img src="{{ asset('product_images/' . $product->image) }}" alt="Product Image" calss="zoom-image"
                                style="width:60px; height:60px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                        @endif
                    </small>
        </div>

        <div class="chat-messages" id="chatBox">
            @forelse($customization->messages as $msg)
                <div class="message {{ $msg->sender_id === auth()->id() ? 'user' : 'designer' }}">
                    <div class="message-content">
                        {{ $msg->message }}
                        @if ($msg->attachment)
                            <br><a href="{{ asset('customizations/' . $msg->attachment) }}" target="_blank">
                                <img src="{{ asset('customizations/' . $msg->attachment) }}" alt="Attachment"
                                    width="120">
                            </a>
                            <div class="mt-1">
                                @if ($msg->is_approved == 1)
                                    <span class="badge bg-success">Approved</span>
                                    <button class="btn btn-sm btn-outline-danger cancel-approve-btn"
                                        data-id="{{ $msg->id }}">Cancel</button>
                                @elseif($msg->is_approved == 0)
                                    <button class="btn btn-sm btn-outline-success approve-btn"
                                        data-id="{{ $msg->id }}">Approve</button>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="message-info">
                        {{ $msg->sender->name ?? 'Designer' }}
                        {{-- {{ $msg->sent_at->format('d M, h:i A') }} --}}
                        @if ($msg->cartItem && $msg->cartItem->product)
                            <br><strong>Product:</strong> {{ $msg->cartItem->product->title }}
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted text-center mt-3">No messages yet. Start the conversation!</p>
            @endforelse
        </div>

        <form action="{{ route('customization.sendMessage', $customization->id) }}" method="POST"
            enctype="multipart/form-data" class="chat-input">
            @csrf
            <label for="attachment" class="attach-label" title="Attach File">📎</label>
            <input type="file" name="attachment" id="attachment">
            <textarea name="message" placeholder="Type a message..." rows="1"></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        // Scroll to bottom
        var chatBox = document.getElementById("chatBox");
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let messageId = this.dataset.id;
                if (!confirm('Are you sure you want to approve this image?')) return;

                fetch(`/customization/approve-image/${messageId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Replace button with approved badge + cancel button
                            this.outerHTML =
                                `<span class="badge bg-success">Approved</span>
                                  <button class="btn btn-sm btn-outline-danger cancel-approve-btn" data-id="${messageId}">Cancel</button>`;
                            attachCancelListener(); // reattach cancel listener
                        }
                    });
            });
        });

        // Attach cancel button listener
        function attachCancelListener() {
            document.querySelectorAll('.cancel-approve-btn').forEach(btn => {
                btn.removeEventListener('click', cancelHandler); // avoid duplicates
                btn.addEventListener('click', cancelHandler);
            });
        }

        function cancelHandler() {
            let messageId = this.dataset.id;
            if (!confirm('Are you sure you want to cancel approval?')) return;

            fetch(`/customization/cancel-approval/${messageId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Replace the whole parent container (badge + cancel button)
                        let parent = this.parentElement;
                        parent.innerHTML =
                            `<button class="btn btn-sm btn-outline-success approve-btn" data-id="${messageId}">Approve</button>`;

                        // reattach approve listener
                        parent.querySelector('.approve-btn').addEventListener('click', function() {
                            let messageId = this.dataset.id;
                            if (!confirm('Are you sure you want to approve this?')) return;

                            fetch(`/customization/approve-image/${messageId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        parent.innerHTML =
                                            `<span class="badge bg-success">Approved</span>
                                     <button class="btn btn-sm btn-outline-danger cancel-approve-btn" data-id="${messageId}">Cancel</button>`;
                                        attachCancelListener();
                                    }
                                });
                        });
                    }
                });
        }


        // Initial attach
        attachCancelListener();
    </script>
@endsection
