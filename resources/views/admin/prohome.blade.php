@extends('admin.layouts.masterlayout')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Production Orders
            </h3>
            {{-- <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <span></span>Overview <i
                                class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                        </li>
                    </ul>
                </nav> --}}
        </div>

        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap">Sr.</th>
                                    <th class="d-none d-sm-table-cell text-nowrap">Order ID</th>
                                    <th class="text-nowrap">Product</th>
                                    <th class="text-nowrap">Image</th>
                                    <th class="d-none d-md-table-cell text-nowrap">Size</th>
                                    <th class="d-none d-md-table-cell text-nowrap">Color</th>
                                    <th class="text-nowrap">Qty</th>
                                    <th class="text-nowrap">Image/CDR</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="d-none d-lg-table-cell text-nowrap">Designer</th>
                                    <th class="d-none d-xl-table-cell text-nowrap">Delivery Date</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $task->payment->order_id ?? '' }}</td>
                                    <td>{{ $task->product->title ?? '' }}</td>
                                    <td>
                                        @if (isset($task->product->image))
                                            <a href="{{ url('product_images/' . $task->product->image) }}" target="_blank">
                                                <img src="{{ asset('product_images/' . $task->product->image) }}"
                                                    alt="Product Image"
                                                    style="width: 50px; height: 50px; object-fit: cover;"> </a>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $task->paymentItem->variant->size ?? '' }}</td>
                                    <td class="d-none d-md-table-cell">{{ $task->paymentItem->color ?? '' }}</td>
                                    <td>{{ $task->paymentItem->quantity ?? '' }}</td>
                                    {{--  <td>
                                        @if ($task->file)
                                            <a href="{{ asset('customizations/' . $task->file) }}" target="_blank">
                                                Open File
                                            </a>
                                        @else
                                            <span class="text-muted">Not uploaded</span>
                                        @endif
                                    </td>  --}}
                                    <td>
                                        @if ($task->file)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#imageModal{{ $task->id }}">
                                                View Image
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal{{ $task->id }}" tabindex="-1"
                                                aria-labelledby="imageModalLabel{{ $task->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <!-- modal-lg makes it larger -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="imageModalLabel{{ $task->id }}">
                                                                {{ $task->product->title }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body text-center">
                                                            <div class="row">
                                                                <div class="col-7">
                                                                    <img src="{{ asset('customizations/' . $task->file) }}"
                                                                        alt="Task Image" class="img-fluid"
                                                                        style="width: 250px; height: 250px;">
                                                                </div>
                                                                <div class="col-5">
                                                                    <p>
                                                                        {{ $task->paymentItem->customizationRequest->description ?? '' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>

                                    <td>{{ ucfirst($task->status) }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $task->paymentItem->customizationRequest->designer->name ?? '' }}({{ $task->paymentItem->customizationRequest->designer->mobile ?? '--' }})
                                    </td>
                                    <td class="d-none d-xl-table-cell">{{ $task->paymentItem->payment->delivery_date }}</td>
                                    <td>
                                        @if ($task->status === 'pending')
                                            <form method="POST"
                                                action="{{ route('production.updateStatus', $task->id) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="ready_to_dispatch">
                                                <button class="btn btn-sm btn-primary">Ready </button>
                                            </form>
                                        @elseif($task->status === 'ready_to_dispatch')
                                            <span class="badge bg-success">Dispatched</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- content-wrapper ends -->
@endsection
