@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Update Lookup</h4>
            <a href="{{ route('lookup.index') }}" class="btn btn-secondary btn-sm">Back to Lookup</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('lookup.update', $lookup->id) }}" method="POST" enctype="multipart/form-data"
                    id= "lookupForm">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="lookup_type" class="form-label fw-bold">
                                Lookup Type <span class="text-danger">*</span>
                            </label>
                            <select name="lookup_type" id="lookup_type" class="form-control form-control-sm">
                                <option value="">Select Type</option>
                                @foreach (config('lookup') as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($lookup) && $lookup->lookup_type == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach

                            </select>
                            <span class="text-danger error-text lookup_type_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="lookup_name" class="form-label fw-bold">Lookup Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="lookup_name" id="lookup_name" class="form-control form-control-sm"
                                value="{{ isset($lookup) ? $lookup->lookup_name : '' }}">
                            <span class="text-danger error-text lookup_name_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="is_active" class="form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select form-select-sm">
                                <option value="1" {{ isset($lookup) && $lookup->is_active == 1 ? 'selected' : '' }}>
                                    Active </option>
                                <option value="0" {{ isset($lookup) && $lookup->is_active == 0 ? 'selected' : '' }}>
                                    Inactive </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('lookup.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Update Lookup</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).on('submit', '#lookupForm', function(e) {
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
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                            $(form).find('[name="' + prefix + '"]').addClass('is-invalid');
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>
@endsection
