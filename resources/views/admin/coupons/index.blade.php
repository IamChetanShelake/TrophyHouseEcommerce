@extends('admin.layouts.masterlayout')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-tag-multiple"></i>
                </span>Coupon Management
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Coupons</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">All Coupons</h4>
                            <a href="{{ route('coupons.create') }}" class="btn btn-gradient-primary btn-sm">
                                <i class="mdi mdi-plus"></i> Add New Coupon
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->id }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-outline-primary">{{ strtoupper($coupon->code) }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $coupon->type == 'fixed' ? 'badge-success' : 'badge-info' }}">
                                                    {{ ucfirst($coupon->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($coupon->type == 'fixed')
                                                    &#8377;{{ number_format($coupon->value, 2) }}/-
                                                @else
                                                    {{ $coupon->value }}%
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->expiry_date)
                                                    @if ($coupon->expiry_date->isFuture())
                                                        <span
                                                            class="text-success">{{ $coupon->expiry_date->format('M d, Y') }}</span>
                                                    @else
                                                        <span
                                                            class="text-danger">{{ $coupon->expiry_date->format('M d, Y') }}
                                                            (Expired)
                                                        </span>
                                                    @endif
                                                @endif

                                            </td>
                                            <td>
                                                @if ($coupon->status == 'active')
                                                    <span class="badge"
                                                        style="background-color: #98ff98;color:green;border-radius:20px;">
                                                        {{ ucfirst($coupon->status) }}
                                                    </span>
                                                @else
                                                    <span class="badge"
                                                        style="border-radius:20px;background-color: #ffc8c8;color:red;">
                                                        {{ ucfirst($coupon->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                        class="btn btn-outline-primary">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>

                                                    {{-- <form method="POST"
                                                        action="{{ route('admin.coupons.toggle', $coupon->id) }}"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn {{ $coupon->status == 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                            <i
                                                                class="mdi {{ $coupon->status == 'active' ? 'mdi-pause' : 'mdi-play' }}"></i>
                                                            
                                                        </button>
                                                    </form> --}}

                                                    <form method="POST"
                                                        action="{{ route('coupons.destroy', $coupon->id) }}"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm  "
                                                            onclick="return confirm('Are you sure you want to delete this coupon?')">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <div class="py-4">
                                                    <i class="mdi mdi-tag-off-outline" style="font-size: 48px;"></i>
                                                    <p class="mt-2">No coupons found</p>
                                                    <a href="{{ route('coupons.create') }}"
                                                        class="btn btn-gradient-primary btn-sm">Create First Coupon</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection
