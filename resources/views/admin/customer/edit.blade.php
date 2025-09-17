<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-3">

        {{-- Name --}}
        <div class="col-md-6">
            <label for="name" class="form-label fw-semibold">Name</label>
            <input type="text" id="name" name="name"
                class="form-control form-control-sm @error('name') is-invalid @enderror"
                value="{{ old('name', $customer->name) }}">
            @error('name')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="col-md-6">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" id="email" name="email"
                class="form-control form-control-sm @error('email') is-invalid @enderror"
                value="{{ old('email', $customer->email) }}">
            @error('email')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mobile No --}}
        <div class="col-md-6">
            <label for="mobile_no" class="form-label fw-semibold">Mobile No</label>
            <input type="text" id="mobile_no" name="mobile_no"
                class="form-control form-control-sm @error('mobile_no') is-invalid @enderror"
                value="{{ old('mobile_no', $customer->mobile_no) }}">
            @error('mobile_no')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Sex --}}
        <div class="col-md-6">
            <label for="sex" class="form-label fw-semibold">Sex</label>
            <select id="sex" name="sex" class="form-select form-select-sm @error('sex') is-invalid @enderror">
                <option value="">Select</option>
                <option value="Male" {{ old('sex', $customer->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex', $customer->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('sex', $customer->sex) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('sex')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Blood Group --}}
        <div class="col-md-6">
            <label for="blood_group" class="form-label fw-semibold">Blood Group</label>
            <select id="blood_group" name="blood_group" class="form-select form-select-sm @error('blood_group') is-invalid @enderror">
                <option value="">Select</option>
                @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                    <option value="{{ $bg }}" {{ old('blood_group', $customer->blood_group) == $bg ? 'selected' : '' }}>
                        {{ $bg }}
                    </option>
                @endforeach
            </select>
            @error('blood_group')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- DOB --}}
        <div class="col-md-6">
            <label for="dob" class="form-label fw-semibold">Date of Birth</label>
            <input type="date" id="dob" name="dob"
                class="form-control form-control-sm @error('dob') is-invalid @enderror"
                value="{{ old('dob', $customer->dob) }}">
            @error('dob')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Address --}}
        <div class="col-12">
            <label for="address" class="form-label fw-semibold">Address</label>
            <textarea id="address" name="address"
                class="form-control form-control-sm @error('address') is-invalid @enderror"
                rows="2">{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="col-md-6">
            <label for="is_active" class="form-label fw-semibold">Status</label>
            <select id="is_active" name="is_active" class="form-select form-select-sm @error('is_active') is-invalid @enderror">
                <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('is_active')
                <div class="invalid-feedback small">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success btn-sm">
            <i class="bi bi-save me-1"></i> Update Customer
        </button>
    </div>
</form>
