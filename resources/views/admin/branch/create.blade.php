@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Add New Branch</h4>
            <a href="{{ route('branches.index') }}" class="btn btn-secondary btn-sm">Back to Branches</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data" id= "branchForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="branch_name" class="form-label fw-bold">Branch Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="branch_name" id="branch_name" class="form-control form-control-sm"
                                placeholder="Enter branch name" required>
                            <span class="text-danger error-text branch_name_error"></span>

                        </div>

                        <div class="col-md-4">
                            <label for="branch_email" class="form-label fw-bold">Branch Email <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="branch_email" id="branch_email" class="form-control form-control-sm"
                                placeholder="Enter branch email" required>
                            <span class="text-danger error-text branch_email_error"></span>

                        </div>

                        <div class="col-md-4">
                            <label for="branch_contact" class="form-label fw-bold">Branch Contact <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="branch_contact" id="branch_contact"
                                class="form-control form-control-sm" placeholder="Enter branch contact" required>
                            <span class="text-danger error-text branch_contact_error"></span>

                        </div>

                        <div class="col-md-4">
                            <label for="branch_address" class="form-label fw-bold">Branch Address <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="branch_address" id="branch_address"
                                class="form-control form-control-sm" placeholder="Enter branch address" required>
                            <span class="text-danger error-text branch_address_error"></span>

                        </div>

                        <div class="col-md-4">
                            <label for="is_active" class="form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select form-select-sm" required>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('branches.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Branch</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).on('submit', '#branchForm', function(e) {
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
