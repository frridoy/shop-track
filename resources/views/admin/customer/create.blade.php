@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Add New Customer</h4>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Back to Customers</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" id="customerForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm"
                                placeholder="Enter customer name">
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control form-control-sm"
                                placeholder="Enter customer email">
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="mobile_no" class="form-label fw-bold">Mobile No <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-sm"
                                placeholder="Enter mobile number">
                            <span class="text-danger error-text mobile_no_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="sex" class="form-label fw-bold">Sex</label>
                            <select name="sex" id="sex" class="form-select form-select-sm">
                                <option value="">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="text-danger error-text sex_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="blood_group" class="form-label fw-bold">Blood Group</label>
                            <select name="blood_group" id="blood_group" class="form-control form-control-sm">
                                <option value="">-- Select Blood Group --</option>
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
                            <label for="dob" class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control form-control-sm">
                            <span class="text-danger error-text dob_error"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label fw-bold">Address</label>
                            <textarea name="address" id="address" class="form-control form-control-sm" rows="2" placeholder="Enter address"></textarea>
                            <span class="text-danger error-text address_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="is_active" class="form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select form-select-sm">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger error-text is_active_error"></span>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Customer</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).on('submit', '#customerForm', function(e) {
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
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 2000); 
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
