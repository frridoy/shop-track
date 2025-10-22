@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Add Customer</h5>
                <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">Add New Customer</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Customer List</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Sex</th>
                                <th>Blood Group</th>
                                <th>DOB</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name ?? '' }}</td>
                                    <td>{{ $customer->email ?? '' }}</td>
                                    <td>{{ $customer->mobile_no ?? '' }}</td>
                                    <td>{{ $customer->sex ?? '' }}</td>
                                    <td>{{ $customer->blood_group ?? '' }}</td>
                                    <td>{{ $customer->dob ? date('d M, Y', strtotime($customer->dob)) : '' }}</td>
                                    <td>{{ $customer->address ?? '' }}</td>
                                    <td>
                                        <x-status-toggle
                                            :id="$customer->id"
                                            :status="$customer->is_active"
                                            :route="route('admin.toggleStatus', $customer->id) . '?model=' . urlencode(App\Models\Customer::class)"
                                        />
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm open-modal"
                                            data-url="{{ route('customers.edit', $customer->id) }}"
                                            data-title="Edit Customer: {{ $customer->name }}" title="Edit Customer">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="10" class="text-danger"> No Customer Found</td>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
