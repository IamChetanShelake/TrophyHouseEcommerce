{{-- resources/views/admin/designer/requests.blade.php --}}
@extends('admin.designer.layouts.master')

@section('content')
<h3 class="mb-4">All Customization Requests</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Content</th>
            <th>User</th>
            <th>Status</th>
            <th>Action</th>
            <th>Transfer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $req)
            <tr>
                <td>{{ $req->id }}</td>
                <td>{{ $req->cartItem->product->title }}</td> 
                <td>{{ $req->description }}</td>
                <td>{{ $req->user->name ?? 'Unknown' }}</td>
                <td>{{ ucfirst($req->status) }}</td>
                <td>
    @if ($req->status == 'pending')
        <div style="display: flex; gap: 5px;">
           

            <form method="POST" action="{{ route('accept', $req->id) }}" style="display: inline;">
                @csrf
                <button class="btn btn-success btn-sm" style="white-space: nowrap;">Accept</button>
            </form>

            <form method="POST" action="{{ route('reject', $req->id) }}" style="display: inline;">
                @csrf
                <button class="btn btn-danger btn-sm" style="white-space: nowrap;">Reject</button>
            </form>
        </div>
    @elseif ($req->status == 'accepted' && $req->designer_id == Auth::id())
        <a href="{{ route('workspace', $req->id) }}" class="btn btn-primary btn-sm">Go to Workspace</a>
    @else
        <span class="text-muted">{{ $req->status }}</span>
    @endif
</td>
 @if ($req->status == 'accepted')
<td>
     <form action="{{ route('customization.transfer', $req->id) }}" method="POST">
    @csrf
    <select name="new_designer_id" required>
        @foreach($otherDesigners as $designer)
            <option value="{{ $designer->id }}">{{ $designer->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-sm btn-warning">Transfer</button>
</form>
</td>
@else
<td>
    
</td>
@endif

                <!--<td>-->
                <!--    @if ($req->status == 'pending' )-->
                <!--        {{-- <form method="POST" action="{{ route(name: 'accept', $req->id) }}" class="d-inline">@csrf --}}-->
                <!--            <form method="POST" action="{{ route('accept', $req->id) }}">-->
                <!--                    @csrf-->
                <!--            <button class="btn btn-success btn-sm">Accept</button>-->
                <!--        </form>-->
                <!--        {{-- <form method="POST" action="{{ route('reject', $req->id) }}" class="d-inline">@csrf --}}-->
                <!--            <form method="POST" action="{{ route('reject', $req->id) }}">-->
                <!--                        @csrf-->
                <!--            <button class="btn btn-danger btn-sm">Reject</button>-->
                <!--        </form>-->
                <!--    @elseif ($req->status == 'accepted' && $req->designer_id == Auth::id())-->
                <!--        <a href="{{ route('workspace', $req->id) }}" class="btn btn-primary btn-sm">Go to Workspace</a>-->
                <!--    @else-->
                <!--        <span class="text-muted">{{$req->status}}</span>-->
                <!--    @endif-->
                <!--</td>-->
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
