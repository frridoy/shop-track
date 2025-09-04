@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Add New User</h4>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back to Users</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
                    @csrf
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="branch_id" class="form-label fw-bold">Branch <span
                                    class="text-danger">*</span></label>
                            <select name="branch_id" id="branch_id" class="form-select form-select-sm" required>
                                <option value="">Select Branch</option>
                                @if ($branches->isEmpty())
                                    <option value="">No branches available</option>
                                @endif
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text branch_id_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm"
                                placeholder="Enter full name" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="user_type" class="form-label fw-bold">User Type <span
                                    class="text-danger">*</span></label>
                            <select name="user_type" id="user_type" class="form-select form-select-sm" required>
                                <option value="1">Admin</option>
                                <option value="2">Manager</option>
                                <option value="3">Sales Person</option>
                            </select>
                            <span class="text-danger error-text user_type_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control form-control-sm"
                                placeholder="Enter email address" required>
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="password" class="form-label fw-bold">Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control form-control-sm"
                                placeholder="Enter password" required>
                            <span class="text-danger error-text password_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="phone_no" class="form-label fw-bold">Phone Number <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="phone_no" id="phone_no" class="form-control form-control-sm"
                                placeholder="Enter phone number" required>
                            <span class="text-danger error-text phone_no_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="address" class="form-label fw-bold">Address</label>
                            <input type="text" name="address" id="address" class="form-control form-control-sm"
                                placeholder="Enter address">
                            <span class="text-danger error-text address_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="dob" class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control form-control-sm">
                            <span class="text-danger error-text dob_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="sex" class="form-label fw-bold">Gender</label>
                            <select name="sex" id="sex" class="form-select form-select-sm">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <span class="text-danger error-text sex_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="blood_group" class="form-label fw-bold">Blood Group</label>
                            <select name="blood_group" id="blood_group" class="form-select form-select-sm">
                                <option value="">Select</option>
                                <option value="A_pos">A+</option>
                                <option value="A_neg">A-</option>
                                <option value="B_pos">B+</option>
                                <option value="B_neg">B-</option>
                                <option value="O_pos">O+</option>
                                <option value="O_neg">O-</option>
                                <option value="AB_pos">AB+</option>
                                <option value="AB_neg">AB-</option>
                            </select>
                            <span class="text-danger error-text blood_group_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="emergency_contact" class="form-label fw-bold">Emergency Contact</label>
                            <input type="number" name="emergency_contact" id="emergency_contact"
                                class="form-control form-control-sm" placeholder="Enter emergency contact">
                            <span class="text-danger error-text emergency_contact_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="date_of_joining" class="form-label fw-bold">Date of Joining <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="date_of_joining" id="date_of_joining"
                                class="form-control form-control-sm" required>
                            <span class="text-danger error-text date_of_joining_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="date_of_leaving" class="form-label fw-bold">Date of Leaving</label>
                            <input type="date" name="date_of_leaving" id="date_of_leaving"
                                class="form-control form-control-sm">
                            <span class="text-danger error-text date_of_leaving_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="is_active" class="form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select form-select-sm" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger error-text is_active_error"></span>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save User</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).on('submit', '#userForm', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 1) {
                        toastr.success(data.message);
                        $(form)[0].reset();
                        window.location.href = data.redirect;
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>
@endsection
