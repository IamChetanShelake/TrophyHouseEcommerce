<div class="modal-body">
    <div id="chatMessages">
        @foreach ($messages as $msg)
            @php
                $isUser = $msg->sender_id == $msg->customizationRequest->user_id;
                $isDesigner = $msg->sender_id == $msg->customizationRequest->designer_id;
            @endphp

            <div class="chat-message {{ $isUser ? 'user' : ($isDesigner ? 'designer' : '') }}">
                <strong>
                    @if ($isUser)
                        User
                    @elseif($isDesigner)
                        Designer
                    @else
                        Unknown
                    @endif
                </strong>

                {{ $msg->message }}

                {{-- If there's an attachment --}}
                @if ($msg->attachment)
                    <br>
                    <a href="{{ asset('customizations/' . $msg->attachment) }}" target="_blank">
                        <img src="{{ asset('customizations/' . $msg->attachment) }}" alt="Attachment" width="120">
                    </a>
                @endif
                <div class="m-1">
                    @if ($msg->is_approved == 1)
                        <span class="badge bg-success">Approved</span>
                    @endif
                </div>

                {{-- <div class="text-muted small">
                    {{ \Carbon\Carbon::parse($msg->sent_at)->format('d M Y H:i') }}
                </div> --}}
            </div>
        @endforeach
    </div>
</div>

<style>
    #chatMessages {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        background: #f0f0f0;
    }

    .chat-message {
        max-width: 70%;
        margin-bottom: 12px;
        padding: 10px 14px;
        border-radius: 18px;
        position: relative;
        font-size: 14px;
        line-height: 1.4;
        display: inline-block;
        clear: both;
    }

    /* User messages (left side, green like WhatsApp) */
    .chat-message.user {
        background: #dcf8c6;
        float: left;
        border-bottom-left-radius: 0;
    }

    /* Designer messages (right side, blue like WhatsApp) */
    .chat-message.designer {
        background: #ffffff;
        float: right;
        border-bottom-right-radius: 0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
    }

    /* Sender label */
    .chat-message strong {
        display: block;
        font-size: 12px;
        color: #555;
        margin-bottom: 2px;
    }

    /* Timestamp */
    .chat-message .text-muted {
        font-size: 11px;
        margin-top: 4px;
        text-align: right;
        color: #888;
    }

    /* For attachments */
    .chat-message img {
        margin-top: 6px;
        border-radius: 8px;
    }
</style>
