@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Add Branch</h5>
                <a href="{{ route('branches.create') }}" class="btn btn-primary btn-sm">Add New Branch</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Branch List</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Branch Name</th>
                                <th>Code</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $branch->branch_name ?? '' }}</td>
                                    <td>{{ $branch->branch_code ?? '' }}</td>
                                    <td>{{ $branch->branch_email ?? '' }}</td>
                                    <td>{{ $branch->branch_contact ?? '' }}</td>
                                    <td>{{ $branch->branch_address ?? '' }}</td>
                                    <td>{{ $branch->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <td colspan="8" class="text-danger"> No Branch Found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
