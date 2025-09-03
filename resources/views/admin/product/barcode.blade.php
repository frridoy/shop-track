@extends('admin.layouts.app')

@section('content')
    <style>
        .barcode-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            justify-content: center;
        }

        .barcode-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .barcode-name {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        .barcode-code {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .barcode-image {
            display: flex;
            justify-content: center;
            margin: 5px 0;
        }

        .selling-price {
            margin-top: 5px;
            font-weight: 500;
            color: #007bff;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printable-area,
            #printable-area * {
                visibility: visible;
            }

            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .barcode-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .barcode-card {
                box-shadow: none;
                background-color: #fff !important;
                border: 1px solid #000;
                page-break-inside: avoid;
            }
        }
    </style>

    <div class="container-fluid">
        <h4 class="mb-3">Generated Barcodes</h4>

        <div class="barcode-grid d-print-none">
            @php
                $grouped = collect($createdProducts)->groupBy('product_code');
            @endphp

            @foreach ($grouped as $code => $products)
                @php
                    $product = $products->first();
                    $qty = $products->count();
                @endphp
                <div class="barcode-card">
                    <div class="barcode-name">
                        {{ $product->product_name }}
                        @if ($product->color_name || $product->size_name)
                            ({{ $product->color_name ?? '-' }} - {{ $product->size_name ?? '-' }})
                        @endif
                    </div>

                    <div class="barcode-code">{{ $product->product_code }}</div>

                    <div class="barcode-image">
                        {!! DNS1D::getBarcodeHTML($product->product_code, 'C128') !!}
                    </div>

                    <div class="selling-price">Price: {{ $product->selling_price }} BDT</div>

                    <div class="mt-2">
                        <span class="badge bg-dark">x{{ $qty }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="printable-area" class="barcode-grid d-none d-print-grid">
            @foreach ($createdProducts as $product)
                <div class="barcode-card">
                    <div class="barcode-name">
                        {{ $product->product_name }}
                        @if ($product->color_name || $product->size_name)
                            ({{ $product->color_name ?? '-' }} - {{ $product->size_name ?? '-' }})
                        @endif
                    </div>

                    <div class="barcode-code">{{ $product->product_code }}</div>

                    <div class="barcode-image">
                        {!! DNS1D::getBarcodeHTML($product->product_code, 'C128') !!}
                    </div>

                    <div class="selling-price">Price: {{ $product->selling_price }} BDT</div>
                </div>
            @endforeach
        </div>

        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary" onclick="window.print()">Print Barcodes</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>

    <script>
        // Auto confirm print on load
        window.addEventListener('load', function() {
            const shouldPrint = confirm('Do you want to print the barcodes now?');

            if (shouldPrint) {
                window.print();
            } else {
                window.location.href = "{{ route('products.index') }}";
            }
        });
    </script>
@endsection
