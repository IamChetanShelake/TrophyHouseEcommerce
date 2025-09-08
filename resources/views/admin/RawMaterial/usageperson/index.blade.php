@extends('admin.layouts.masterlayout')
@section('content')
    <style>
        .form-control,
        .btn {
            font-size: 16px;
        }

        .form-label {
            font-size: 16px;
            font-weight: 500;
            color: #000;
        }

        .btn-primary {
            background-color: #FFE235;
            border: none;
            color: #000;
        }

        .btn-primary:hover {
            background-color: #f5f5f5;
        }

        .btn-add-row {
            background-color: #0d6efd;
            border: none;
            color: #fff;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            color: #fff;
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
                <div class="row">
                    <div class="col-lg-12">
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Usage Persons List</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('admin.usage-person.create') }}" class="btn btn-primary mb-3">Add New
                                    Usage Person</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Date</th>
                                                <th>Total Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usagePersons as $usagePerson)
                                                <tr>
                                                    <td>{{ $usagePerson->name }}</td>
                                                    <td>{{ $usagePerson->contact ?? 'N/A' }}</td>
                                                    <td>{{ $usagePerson->date }}</td>
                                                    <td>{{ $usagePerson->usages_sum_quantity ?? 0 }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.usage-person.edit', $usagePerson->id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                        <form
                                                            action="{{ route('admin.usage-person.destroy', $usagePerson->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $usagePersons->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
