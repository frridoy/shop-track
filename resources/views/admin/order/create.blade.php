@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Create Order</h4>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select id="customer_id" class="form-control">
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->mobile_no }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6" id="customer_mobile_div" style="display:none;">
                        <label for="customer_mobile" class="form-label">Customer Mobile</label>
                        <input type="text" id="customer_mobile" class="form-control" placeholder="Enter mobile number">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="barcode" class="form-label">Scan Barcode</label>
                        <input type="text" id="barcode" class="form-control" placeholder="Scan or type barcode"
                            autocomplete="off">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="orderTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Price (BDT)</th>
                                <th>Qty</th>
                                <th>Total (BDT)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h5>Grand Total: <span id="grandTotal">0.00</span> BDT</h5>
                    <button class="btn btn-success btn-lg" id="saveOrder"><i class="bi bi-cart-plus"></i> Save
                        Order</button>
                </div>

            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        $(document).ready(function() {

            $('#customer_id').select2({
                placeholder: "Select or type customer name",
                tags: true,
                allowClear: true
            });
            const toggleMobileInput = () => {
                const val = $('#customer_id').val();
                if (!val || isNaN(val)) {
                    $('#customer_mobile_div').show();
                } else {
                    $('#customer_mobile_div').hide();
                    $('#customer_mobile').val('');
                }
            };
            $('#customer_id').on('change select2:select', toggleMobileInput);

            const barcodeInput = $('#barcode')[0];
            const tableBody = $('#orderTable tbody')[0];
            const grandTotalEl = $('#grandTotal')[0];
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            const updateGrandTotal = () => {
                let total = 0;
                $(tableBody).find('tr').each(function() {
                    total += parseFloat($(this).find('.total').text()) || 0;
                });
                grandTotalEl.textContent = total.toFixed(2);
            };

            const addProductRow = (product) => {
                if (product.stock <= 0) {
                    toastr.error("Product is out of stock");
                    return;
                }
                if ($(tableBody).find(`tr[data-product-id="${product.id}"]`).length) {
                    toastr.warning("Product already added");
                    return;
                }

                const row = document.createElement('tr');
                row.dataset.productId = product.id;
                row.dataset.stock = product.stock;

                if (product.is_active === 0) row.classList.add('table-warning');

                row.innerHTML = `
            <td>${product.name}</td>
            <td>${product.color || '-'}</td>
            <td>${product.size || '-'}</td>
            <td><input type="number" class="form-control price" value="${product.price}" min="0" step="0.01"></td>
            <td><input type="number" class="form-control qty" value="1" min="1" max="${product.stock}"></td>
            <td class="total">${product.price.toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>
        `;
                row.querySelector('.remove-row').addEventListener('click', () => {
                    row.remove();
                    updateGrandTotal();
                });
                tableBody.appendChild(row);
                updateGrandTotal();
            };

            const fetchProduct = (code) => {
                if (!code) return;
                barcodeInput.disabled = true;
                barcodeInput.placeholder = "Loading...";
                fetch(`{{ url('orders/products/by-code') }}/${encodeURIComponent(code)}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.product) addProductRow(data.product);
                        else toastr.error(data.message || "Product not found");
                        barcodeInput.value = "";
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
            };

            barcodeInput.addEventListener("keydown", e => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    fetchProduct(barcodeInput.value.trim());
                }
            });
            barcodeInput.addEventListener("blur", () => {
                const code = barcodeInput.value.trim();
                if (code) setTimeout(() => fetchProduct(code), 100);
            });

            $(tableBody).on("input", ".price,.qty", function() {
                const row = this.closest("tr");
                let qty = parseInt($(row).find(".qty").val()) || 1;
                const stock = parseInt(row.dataset.stock);
                if (qty > stock) {
                    qty = stock;
                    $(row).find(".qty").val(qty);
                    toastr.warning(`Max available stock is ${stock}`);
                }
                const price = parseFloat($(row).find(".price").val()) || 0;
                $(row).find(".total").text((price * qty).toFixed(2));
                updateGrandTotal();
            });

            $('#saveOrder').click(function() {
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
                $(tableBody).find('tr').each(function() {
                    products.push({
                        id: $(this).data('product-id'),
                        price: parseFloat($(this).find('.price').val()) || 0,
                        qty: parseInt($(this).find('.qty').val()) || 1,
                        color: $(this).find('td:eq(1)').text().trim() !== '-' ? $(this)
                            .find('td:eq(1)').text().trim() : null,
                        size: $(this).find('td:eq(2)').text().trim() !== '-' ? $(this).find(
                            'td:eq(2)').text().trim() : null
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
