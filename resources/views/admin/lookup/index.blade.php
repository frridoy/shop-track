@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Add Lookup</h5>
            <a href="{{ route('lookup.create') }}" class="btn btn-primary btn-sm">Add New Lookup</a>
        </div>
    </div>

    <div class="card shadow-sm mb-3" style="background-color: #f3f8fb;">
        <div class="card-body">
            <form action="{{ route('lookup.index') }}" method="GET" class="row g-2 align-items-end">

                <div class="col-md-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="lookup_name" id="lookup_name" value="{{ request('lookup_name') }}" placeholder="Enter Lookup Name"
                        class="form-control form-control-sm">
                </div>

                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="lookup_type" id="lookup_type" class="form-select form-select-sm">
                        <option value="">All</option>
                        @foreach(config('lookup') as $key => $val)
                        <option value="{{ $key }}" {{ request('lookup_type')==$key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="1" {{ request('is_active')=='1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('is_active')=='0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('lookup.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>

            </form>
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
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($lookups as $lookup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lookup->lookup_name ?? '' }}</td>
                            <td>{{ config('lookup')[$lookup->lookup_type] ?? '' }}</td>
                            <td>{{ $lookup->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                            <td><a href="{{ route('lookup.edit', $lookup->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a></td>
                        </tr>
                        @empty
                        <td colspan="5" class="text-danger"> No Lookup Found</td>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
            {{ $lookups->links() }}
        </div>
        </div>
    </div>

</div>
@endsection
