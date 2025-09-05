@extends('admin.layouts.masterlayout')
@section('content')
    <style>
        thead th {
            background-color: #FFE235 !important;
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
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;"> <a href="{{route('admin.material.index')}}"><i class='fa fa-arrow-circle-left' style='font-size:36px;color:green;'></i></a> Purchases({{ $material->name }})</p>
                    </div>
                    <div class="col-lg-1 col-sm-2">
                        <a href="{{ route('admin.purchase.create',$material->id) }}" class="btn btn-primary" style="font-size: 18px;">
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
                                                <th>Material</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Cost</th>
                                                <th>Supplier Name</th>
                                                <th>Supplier Contact</th>
                                                <th>Purchase Date</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $purchase->material->name ?? 'N/A' }}</td>
                                                    <td>{{ $purchase->quantity }}</td>
                                                    <td>{{ $purchase->unit_price }}</td>
                                                    <td>{{ $purchase->total_cost }}</td>
                                                    <td>{{ $purchase->supplier_name }}</td>
                                                    <td>{{ $purchase->supplier_contact ?? 'N/A' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <a href="{{ route('admin.purchase.edit', $purchase->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.purchase.destroy', $purchase->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this purchase?');">
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
                            {{ $purchases->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
