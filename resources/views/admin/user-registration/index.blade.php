@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Add User</h5>
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Lookup List</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Branch</th>
                                <th>Position</th>
                                <th>Date of Joining</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name ?? '' }}</td>
                                    <td>{{ $user->email ?? '' }}</td>
                                    <td>{{ $user->phone_no ?? '' }}</td>
                                    <td>{{ $user->branch->branch_name ?? '' }}</td>
                                    <td>{{ $user->user_type == 2 ? 'Manager' : 'Salesman' }}</td>
                                    <td>{{ $user->date_of_joining ?? '' }}</td>
                                    <td>{{ $user->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>
                            @empty
                                <td colspan="5" class="text-danger"> No Lookup Found</td>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
