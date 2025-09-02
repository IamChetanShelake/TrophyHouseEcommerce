@extends('admin.designer.layouts.master')
<style>
    .approvaldone {
        background-color: #d5ffdf;
        color: #009823;
        padding: 7px;
        border-radius: 35px;
        width: 85%;
        display: flex;
    }

    .approvalfail {
        background-color: #fdc6cb;
        color: #ff0018;
        padding: 7px;
        border-radius: 35px;
        width: 85%;
        display: flex;
    }
</style>
@section('content')
    <a href="{{ route('requests') }}" class="btn btn-dark mb-3" style="display:inline-block; width:20%; ">
        ← Back to Requests</a>
    <h3 class="mb-4">Workspace for Order - {{ $orderId }}</h3>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Content</th>
                <th>Action</th>
                <th>CDR File</th>
                <th>Chats</th>
                <th>Approval Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $req)
                <tr>
                    <td>{{ $req->paymentItem?->product?->title ?? 'N/A' }}</td>
                    <td>{{ $req->paymentItem?->quantity ?? 0 }}</td>
                    <td>{{ $req->description ?? 'N/A' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#workspaceModal{{ $req->id }}">
                            Open Workspace
                        </button>
                    </td>
                    <td>
                        @if ($req->cdr_file)
                            <a href="{{ asset('cdr_files/' . $req->cdr_file) }}" target="_blank"
                                class="btn btn-secondary btn-sm">View CDR</a>
                        @else
                            No CDR file
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('chats', $req->id) }}" class="btn btn-success btn-sm mt-1 text-black"
                            style="background-color:#00ff65">
                            <i class="fas fa-comments"></i> Go To Chat
                        </a>
                    </td>
                    <td>
                        @if ($req->messages->where('is_approved', 1)->count() > 0)
                            <span class=" approvaldone ">Approved</span>
                        @else
                            <span class=" approvalfail">Not Approved</span>
                        @endif
                    </td>

                </tr>

                {{-- Modal for individual product workspace --}}
                <div class="modal fade" id="workspaceModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Workspace for - {{ $req->paymentItem?->product?->title ?? 'N/A' }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                {{-- <p><strong>User:</strong> {{ $req->user?->name ?? 'N/A' }}</p> --}}
                                <p><strong>Content:</strong> {{ $req->description ?? 'N/A' }}</p>
                                @if ($req->images->isNotEmpty())
                                    @foreach ($req->images as $img)
                                        <p><strong>Content Image:</strong></p>
                                        <img src="{{ asset('customization_images/' . $img->image) }}"
                                            style="max-width: 150px; margin-bottom: 10px;">
                                    @endforeach
                                @endif
                                @if ($req->messages->isNotEmpty())
                                    <div style="max-height:300px; overflow-y:auto;" class="mb-2 border p-2">
                                        @foreach ($req->messages as $msg)
                                            <div><strong>{{ $msg->sender?->name ?? 'Unknown' }}:</strong>
                                                {{ $msg->message }}</div>
                                            @if ($msg->attachment)
                                                <a href="{{ asset('customizations/' . $msg->attachment) }}"
                                                    target="_blank">📎
                                                    Attachment</a>
                                            @endif
                                            <small
                                                class="text-muted d-block mb-1">{{ $msg->created_at->format('d M Y, h:i A') }}</small>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No messages yet.</p>
                                @endif

                                {{-- Chat form --}}
                                <form action="{{ route('send.message', $req->user?->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="customization_request_id" value="{{ $req->id }}">
                                    <textarea name="message" class="form-control mb-2" placeholder="Type your message..."></textarea>
                                    <input type="file" name="attachment" class="form-control mb-2">
                                    <button class="btn btn-primary btn-sm">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal --}}
            @endforeach
        </tbody>
    </table>
@endsection
