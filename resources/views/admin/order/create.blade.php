@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Create Order</h3>

        <div class="mb-3">
            <label>Customer</label>
            <select id="customer_id" class="form-control">
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->mobile_no }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="customer_mobile_div" style="display:none;">
            <label>Customer Mobile</label>
            <input type="text" id="customer_mobile" class="form-control" placeholder="Enter mobile number">
        </div>

        <div class="mb-3">
            <label>Scan Barcode</label>
            <input type="text" id="barcode" class="form-control" placeholder="Scan or type barcode" autocomplete="off">
        </div>

        <table class="table table-bordered" id="orderTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="mb-3">
            <strong>Grand Total: </strong> <span id="grandTotal">0.00</span> BDT
        </div>

        <button class="btn btn-primary" id="saveOrder">Save Order</button>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#customer_id').select2({
                placeholder: "Select or type customer name",
                tags: true,
                allowClear: true
            });

            function toggleMobileInput() {
                const val = $('#customer_id').val();
                if (!val || isNaN(val)) {
                    $('#customer_mobile_div').show();
                } else {
                    $('#customer_mobile_div').hide();
                    $('#customer_mobile').val('');
                }
            }
            $('#customer_id').on('change select2:select', toggleMobileInput);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const barcodeInput = document.getElementById("barcode");
            const tableBody = document.querySelector("#orderTable tbody");
            const grandTotalEl = document.getElementById("grandTotal");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function updateGrandTotal() {
                let total = 0;
                tableBody.querySelectorAll("tr").forEach(row => {
                    const totalCell = row.querySelector(".total");
                    if (totalCell) total += parseFloat(totalCell.textContent) || 0;
                });
                grandTotalEl.textContent = total.toFixed(2);
            }

            function removeProductRow(button) {
                const row = button.closest('tr');
                if (row) {
                    row.remove();
                    updateGrandTotal();
                }
            }

            function addProductRow(product) {
                const exists = tableBody.querySelector(`tr[data-product-id="${product.id}"]`);
                if (exists) {
                    toastr.warning("Product already added");
                    return;
                }

                const row = document.createElement("tr");
                row.dataset.productId = product.id;
                row.innerHTML = `
            <td>${product.name || 'N/A'}</td>
            <td>${product.color || '-'}</td>
            <td>${product.size || '-'}</td>
            <td><input type="number" class="form-control price" value="${product.price || 0}" min="0" step="0.01"></td>
            <td><input type="number" class="form-control qty" value="1" min="1"></td>
            <td class="total">${(product.price || 0).toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row">Remove</button></td>
        `;
                row.querySelector('.remove-row').addEventListener('click', function() {
                    removeProductRow(this);
                });
                tableBody.appendChild(row);
                updateGrandTotal();
            }

            function fetchProduct(code) {
                if (!code) return;

                barcodeInput.disabled = true;
                barcodeInput.placeholder = "Loading...";

                fetch(`{{ url('orders/products/by-code') }}/${encodeURIComponent(code)}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.product) {
                            addProductRow(data.product);
                            barcodeInput.value = "";
                        } else {
                            toastr.error(data.message || "Product not found");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        toastr.error("Error fetching product");
                    })
                    .finally(() => {
                        barcodeInput.disabled = false;
                        barcodeInput.placeholder = "Scan or type barcode";
                        barcodeInput.focus();
                    });
            }

            barcodeInput.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    fetchProduct(barcodeInput.value.trim());
                }
            });

            barcodeInput.addEventListener("blur", function() {
                const code = barcodeInput.value.trim();
                if (code) setTimeout(() => fetchProduct(code), 100);
            });

            tableBody.addEventListener("input", function(e) {
                if (e.target.classList.contains("price") || e.target.classList.contains("qty")) {
                    const row = e.target.closest("tr");
                    const price = parseFloat(row.querySelector(".price").value) || 0;
                    const qty = parseInt(row.querySelector(".qty").value) || 1;
                    row.querySelector(".total").textContent = (price * qty).toFixed(2);
                    updateGrandTotal();
                }
            });

            document.getElementById('saveOrder').addEventListener('click', function() {
                const customerVal = $('#customer_id').val();
                const mobileVal = $('#customer_mobile').val();

                let payload = {};

                if (!customerVal || isNaN(customerVal)) {
                    if (!customerVal || !mobileVal) {
                        toastr.warning("Please enter customer name and mobile");
                        return;
                    }
                    payload.customer_id = null;
                    payload.customer_name = customerVal;
                    payload.customer_mobile = mobileVal;
                } else {
                    payload.customer_id = parseInt(customerVal);
                    payload.customer_name = null;
                    payload.customer_mobile = null;
                }

                const products = [];
                document.querySelectorAll('#orderTable tbody tr').forEach(row => {
                    products.push({
                        id: row.dataset.productId,
                        price: parseFloat(row.querySelector(".price").value) || 0,
                        qty: parseInt(row.querySelector(".qty").value) || 1,
                        color: row.cells[1].textContent.trim() !== '-' ? row.cells[1]
                            .textContent.trim() : null,
                        size: row.cells[2].textContent.trim() !== '-' ? row.cells[2]
                            .textContent.trim() : null
                    });
                });

                if (products.length === 0) {
                    toastr.warning("No products added");
                    return;
                }

                payload.products = products;

                fetch("{{ route('orders.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(data.message || "Something went wrong");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        toastr.error("Error saving order");
                    });
            });

            barcodeInput.focus();
        });
    </script>
@endsection
