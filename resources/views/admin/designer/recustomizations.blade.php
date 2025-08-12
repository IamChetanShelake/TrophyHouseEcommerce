{{-- resources/views/admin/designer/recustomizations.blade.php --}}
@extends('admin.designer.layouts.master')

@section('content')
<h3 class="mb-4">Re-Customization Requests</h3>
<table class="table table-striped">
    <thead>
        <tr><th>ID</th><th>Description</th><th>Feedback</th><th>Action</th></tr>
    </thead>
    <tbody>
        @foreach ($recustoms as $req)
            <tr>
                <td>{{ $req->id }}</td>
                <td>{{ $req->description }}</td>
                <td>{{ $req->user_feedback }}</td>
                <td>
                    <a href="{{ route('designer.workspace', $req->id) }}" class="btn btn-warning btn-sm">Edit Work</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
