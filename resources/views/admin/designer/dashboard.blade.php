{{-- resources/views/admin/designer/dashboard.blade.php --}}
@extends('admin.designer.layouts.master')

@section('content')
    <h3 class="mb-4">Customization Requests</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->description }}</td>
                    <td>{{ $req->status }}</td>
                    <td>
                        @if ($req->status === 'pending' && $req->designer_id === null)
                            <form method="POST" action="{{ route('accept', $req->id) }}">
                                @csrf
                                <button class="btn btn-success btn-sm">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('reject', $req->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @elseif ($req->status === 'accepted' && $req->designer_id === Auth::id())
                            <a href="{{ route('designer.workspace', $req->id) }}" class="btn btn-primary btn-sm">Go to
                                Workspace</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
