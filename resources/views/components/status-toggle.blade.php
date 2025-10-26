<form action="{{ $route }}" method="POST" style="display:inline;">
    @csrf
    <label class="toggle-switch">
        <input type="checkbox" class="toggle-input" {{ $status ? 'checked' : '' }} onchange="this.form.submit()">
        <span class="toggle-slider"></span>
    </label>
</form>

<style>
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 32px;
    height: 16px;
}

.toggle-input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #dee2e6;
    transition: 0.25s;
    border-radius: 16px;
    border: 1px solid #adb5bd;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 1px;
    bottom: 1px;
    background-color: #fff;
    transition: 0.25s;
    border-radius: 50%;
    box-shadow: 0 1px 2px rgba(0,0,0,0.15);
}

.toggle-input:checked + .toggle-slider {
    background-color: #2828a7;
    border-color: #2828a7;
}

.toggle-input:checked + .toggle-slider:before {
    transform: translateX(16px);
}

.toggle-input:focus + .toggle-slider {
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
}

.toggle-input:disabled + .toggle-slider {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
