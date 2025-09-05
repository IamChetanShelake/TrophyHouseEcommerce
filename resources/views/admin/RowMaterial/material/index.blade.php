@extends('admin.layouts.masterlayout')
@section('content')
    <style>
        thead th {
            padding: 0 20px;
        }

        tbody td {
            background-color: #fff !important;
        }

        .btn-primary {
            background-color: #FFE235;
            border: none;
            color: #000;
        }

        .btn-primary:hover {
            background-color: #f5f5f5;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-link {
            color: #000;
            border: none;
            margin: 0 5px;
            padding: 8px 16px;
            font-size: 16px;
        }

        .pagination .page-item.active .page-link {
            background-color: #FFE235;
            color: #000;
        }

        .pagination .page-link:hover {
            background-color: #f5f5f5;
        }

        .app-wrapper {
            background: #FFFFF4;
        }

        @media (max-width: 768px) {
            .custom-margin {
                margin-left: 10px !important;
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <x-session-message />
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-lg-11 col-sm-10">
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Materials</p>
                    </div>
                    <div class="col-lg-1 col-sm-2">
                        <a href="{{ route('admin.material.create') }}" class="btn btn-danger" style="font-size: 18px;">
                            Add New
                        </a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-2">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Unit</th>
                                                <th>Stock In</th>
                                                <th>Stock Out</th>
                                                <th>Current Stock</th>
                                                <th>Reorder Level</th>
                                                {{--  <th>Description</th>  --}}
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($materials as $material)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $material->name }}</td>
                                                    <td>{{ $material->category->name ?? 'N/A' }}</td>
                                                    <td>{{ $material->unit }}</td>
                                                    {{--  <td>{{ $material->stock_in }}</td>
                                            <td>{{ $material->stock_out }}</td>
                                            <td>{{ $material->current_stock }}</td>
                                            <td>{{ $material->reorder_level }}</td>  --}}
                                                    <td>{{ intval($material->stock_in) }} &nbsp; <a
                                                            href="{{ route('admin.purchase.create') }}" class="btn  btn-sm"
                                                            style="background-color: green; color:#fff;">
                                                            <b> +</b>
                                                        </a></td>
                                                    <td>{{ intval($material->stock_out) }}&nbsp;
                                                        <a href="" class="btn btn-danger btn-sm">
                                                            <b> -</b>
                                                        </a>
                                                    </td>
                                                    <td>{{ intval($material->current_stock) }}</td>
                                                    <td>{{ intval($material->reorder_level) }}</td>

                                                    {{--  <td>{{ $material->desc ?? 'N/A' }}</td>  --}}
                                                    <td style="text-align: center;">

                                                        <a href="{{ route('admin.purchase.index') }}"
                                                            class="btn btn-primary btn-sm"
                                                            style="background-color: green; color:#fff;">
                                                            Purchase List
                                                        </a>
                                                        <a href="" class="btn btn-danger btn-sm">
                                                            Usage List
                                                        </a>

                                                        <a href="{{ route('admin.material.edit', $material->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.material.destroy', $material->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this material?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination Links -->
                        <div class="pagination">
                            {{ $materials->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
