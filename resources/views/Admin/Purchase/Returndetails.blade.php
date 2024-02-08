@extends('Admin.layouts.main')

@section('pageTitle')
    استعادة المشتريات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Add any additional styles here if needed */

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .invoice-container {
            display: flex;
            flex-wrap: wrap;
        }

        .invoice-box {
            width: 200px;
            height: auto;
            margin: 10px;
            padding: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            font-size: 14px; /* Adjust the font size as needed */
        }

        .invoice-details {
            width: 100%;
            display: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 10px;
            border-radius: 10px;
            overflow: hidden;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Adjust the column width as needed */
            gap: 10px; /* Adjust the gap between items as needed */
        }

        .invoice-details h5,
        .invoice-details p {
            margin: 0; /* Remove default margin for better alignment */
            padding: 10px; /* Add padding for spacing */
        }

        .invoice-details h5 {
            grid-column: span 2; /* Make h5 span two columns for a wider appearance */
        }




        .invoice-details th,
        .invoice-details td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .invoice-details th {
            background-color: #007bff;
            color: #fff;
        }

        .invoice-details tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .invoice-details tr:hover {
            background-color: #e5e5e5;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }

        .return-btn {
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .review-btn {
            cursor: pointer;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Additional styles for improved table design */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e5e5e5;
        }

        /* Styles for modal and form */
        #returnModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #returnModal h5 {
            color: #007bff;
        }

        #returnForm {
            margin-top: 15px;
        }

        #returnForm label {
            display: block;
            margin-bottom: 5px;
        }

        #returnForm input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #returnForm button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('Content')
    <main id="main" class="main">
        <div class="invoice-container">
            @foreach($purchases as $purchase)
                <div class="invoice-box" onclick="toggleInvoiceDetails('{{ $purchase->id }}')">
                    <h5>رقم الفاتورة: {{ $purchase->id }}</h5>
                    <p>تاريخ الشراء: {{ $purchase->created_at }}</p>
                    <p>اسم المورد: {{ $purchase->supplier->name }}</p>
                    <p>المبلغ الإجمالي: {{ $purchase->total}}</p>
                    <p>المبلغ المدفوع: {{ $purchase->amount_paid }}</p>
                </div>
                <div class="invoice-details" id="invoiceDetails{{ $purchase->id }}" style="display: none; width: 100%;">
                    <h5>تفاصيل الفاتورة:</h5>
                    <p>رقم الفاتورة: {{ $purchase->id }}</p>
                    <p>تاريخ الشراء: {{ $purchase->created_at }}</p>
                    <p>اسم المورد: {{ $purchase->supplier->name }}</p>
                    <p>المبلغ الإجمالي: {{ $purchase->total }}</p>
                    <p>المبلغ المدفوع: {{ $purchase->amount_paid }}</p>
                    <p>طريقة الدفع: {{ $purchase->payment_method }}</p>
                    <p>المصاريف الإضافية: {{ $purchase->additional_costs }}</p>

                    <table>
                        <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>استرجاع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($purchase->purchaseDetails as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->price }}</td>
                                <td>
                                    <button class="return-btn" onclick="openReturnModal('{{ $purchase->id }}', '{{ $detail->product->id }}')">استرجاع</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

        <!-- Return Invoice Modal -->
        <div id="returnModal">
            <h5>استعادة المشتريات</h5>
            <form id="returnForm" method="post" action="{{ route('admin.purchase.processReturn') }}">
                @csrf
                <input type="hidden" id="modalPurchaseId" name="purchase_id" value="">
                <input type="hidden" id="modalProductId" name="product_id" value="">
                <label for="return_date">تاريخ الاسترجاع</label>
                <input type="date" id="return_date" name="return_date" required>

                <label for="quantity_returned">الكمية المسترجعة</label>
                <input type="number" id="quantity_returned" name="quantity_returned" placeholder="ادخل الكمية المسترجعة" required>

                <label for="amount_returned">المبلغ المسترجع</label>
                <input type="number" id="amount_returned" name="amount_returned" placeholder="ادخل المبلغ المسترجع" required readonly>

                <button type="button" onclick="submitReturnForm()">استرجاع</button>
            </form>
            <button onclick="closeReturnModal()">إلغاء</button>
        </div>

        <!-- Modal Overlay -->
        <div class="modal-overlay" id="modalOverlay"></div>

        <script>
            function openReturnModal(purchaseId, productId) {
                document.getElementById('modalPurchaseId').value = purchaseId;
                document.getElementById('modalProductId').value = productId;
                document.getElementById('returnModal').style.display = 'block';
                document.getElementById('modalOverlay').style.display = 'block';
            }

            function closeReturnModal() {
                document.getElementById('returnModal').style.display = 'none';
                document.getElementById('modalOverlay').style.display = 'none';
            }

            function toggleInvoiceDetails(purchaseId) {
                var detailsElement = document.getElementById('invoiceDetails' + purchaseId);
                detailsElement.style.display = detailsElement.style.display === 'none' ? 'block' : 'none';
            }

            function submitReturnForm() {
                var formData = {
                    'purchase_id': document.getElementById('modalPurchaseId').value,
                    'product_id': document.getElementById('modalProductId').value,
                    'return_date': document.getElementById('return_date').value,
                    'quantity_returned': document.getElementById('quantity_returned').value,
                    'amount_returned': document.getElementById('amount_returned').value,
                };

                // Perform AJAX request to submit the return form
                fetch("{{ route('admin.purchase.processReturn') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(formData),
                })
                    .then(response => {
                        // Log the full response for debugging
                        console.log(response);
                        return response.json();
                    })
                    .then(data => {
                        // Handle the response data as needed
                        console.log(data);

                        // Close the modal after successful submission
                        closeReturnModal();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Handle errors if any
                    });
            }

            // Calculate the amount returned based on the quantity and original price
            document.getElementById('quantity_returned').addEventListener('input', function () {
                var quantityReturned = parseFloat(document.getElementById('quantity_returned').value);
                var originalPrice = parseFloat('{{ $purchases[0]->purchaseDetails[0]->price }}'); // Use the original price of the product from the first purchase (adjust this if needed)
                var amountReturned = quantityReturned * originalPrice;
                document.getElementById('amount_returned').value = amountReturned.toFixed(2);
            });
        </script>
    </main>
@endsection
