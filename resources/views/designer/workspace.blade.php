{{-- resources/views/admin/designer/workspace.blade.php --}}
@extends('admin.designer.layouts.master')

@section('content')

<h3 class="mb-4">Workspace for Customization Request - {{ $customization->cartItem->product->title }}</h3>
<p><strong>User:</strong> {{ $customization->user->name }}</p>
<p><strong>Content:</strong> {{ $customization->description }}</p>

@if($custImg->isNotEmpty())
    @foreach($custImg as $img)
    <p><strong>Content Image:</strong></p>
    <img src="{{ asset('customization_images/' . $img->image) }}" style="max-width: 300px;">
    @endforeach
@endif

<!--<hr>-->
<!--<h4>Submit Design</h4>-->

<!--    <form method="POST" action="{{ route('submit', $customization->id) }}" enctype="multipart/form-data">-->
<!--    @csrf-->
<!--    <input type="file" name="final_image" required class="form-control mb-2">-->
<!--    <button type="submit" class="btn btn-success">Submit</button>-->
<!--</form>-->
<hr>
<h4>Send Work</h4>
<!--<div class="border p-3 mb-3" style="max-height: 300px; overflow-y: auto;">-->
<!--    @forelse ($customization->messages as $msg)-->
<!--        <div><strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}</div>-->
<!--        @if ($msg->attachment)-->
<!--            <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank">📎 Attachment</a>-->
<!--        @endif-->
<!--        <small class="text-muted d-block">{{ $msg->sent_at->format('d M Y, h:i A') }}</small>-->
<!--        <hr>-->
<!--    @empty-->
<!--        <p class="text-muted">No messages yet.</p>-->
<!--    @endforelse-->
<!--</div>-->

{{-- <form method="POST" action="{{ route('customization.sendMessage', $customization->id) }}" enctype="multipart/form-data"> --}}
    {{-- <form method="POST" action="{{ route('designer.sendMessage', $customization->id) }}"> --}}
 <form action="{{ route('send.message', $customization->user->id) }}" method="POST" class="chat-input-area" enctype="multipart/form-data">
    @csrf
    <textarea name="message" class="form-control mb-2" placeholder="Type your message..."></textarea>
    <input type="file" name="attachment" class="form-control mb-2">
    <button class="btn btn-primary btn-sm">Send</button>
</form>
@endsection
{{--  --}}