@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">





                        <form method="POST" action="{{ route('customer') }}" id="customerForm">
                            @csrf
                            <input type="hidden" name="items" id="itemsInput">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col">
                                    <input type="text" id="customer_name" placeholder="Customer Name"
                                        name="customer_name" class="form-control">

                                </div>
                                <div class="col">


                                    <input type="text" value="<?php echo date('Y-m-d'); ?>" class="form-control datetimepicker"
                                        name="date" placeholder="Select Date">
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="phone" placeholder="Customer Phone" name="phone"
                                        class="form-control">

                                </div>

                            </div>

                            <br>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="name" placeholder="Item Name">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="qty" placeholder="Quantity">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control " name="amount"
                                        value="{{ old('amount') }}"placeholder="Amount">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" value="{{ old('total') }}" name="total"
                                        placeholder="Total">
                                </div>
                                <div class="col">
                                    <input type="button" value="Add Item" id="btnAddItem" class="btn btn-success">
                                    {{-- <input type="submit" id="action"name="action" value="Add Item" id="btnsubmit"> --}}
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($items as $item)
                                            <tr class="">
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td> {{ $item->amount }}</td>
                                                <td>{{ $item->total }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row" style="float: right">
                                <div class="col">
                                    <button type="submit" name="action" value="customer" class="btn btn-primary">
                                        Submit
                                    </button>
                                    {{-- <button type="submit" id="action" value="customer"
                                        name="action"class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            let items = []; // ✅ store all items

            let isValid = {
                customer_name: false,
                phone: false,
                name: false,
                qty: false,
                amount: false,
                total: false
            };

            // ✅ AJAX FIELD VALIDATION
            function validateField(fieldName, value) {
                return $.ajax({
                    url: "{{ route('customer.validate') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        field: fieldName,
                        value: value
                    },
                    success: function() {
                        let input = $('[name="' + fieldName + '"]');

                        input.removeClass('is-invalid');
                        $('#error-' + fieldName).remove();

                        isValid[fieldName] = true;
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON.error;
                        let input = $('[name="' + fieldName + '"]');

                        input.addClass('is-invalid');
                        $('#error-' + fieldName).remove();

                        input.after(
                            '<div id="error-' + fieldName + '" class="invalid-feedback">' +
                            error +
                            '</div>'
                        );

                        isValid[fieldName] = false;
                    }
                });
            }

            // ✅ AUTO CALCULATE TOTAL
            $('[name="qty"], [name="amount"]').on('keyup', function() {
                let qty = parseFloat($('[name="qty"]').val()) || 0;
                let amount = parseFloat($('[name="amount"]').val()) || 0;
                $('[name="total"]').val(qty * amount);
            });

            // ✅ ADD ITEM
            $('#btnAddItem').on('click', function() {

                let name = $('[name="name"]').val();
                let qty = $('[name="qty"]').val();
                let amount = $('[name="amount"]').val();
                let total = $('[name="total"]').val();

                $.when(
                    validateField('name', name),
                    validateField('qty', qty),
                    validateField('amount', amount),
                    validateField('total', total)
                ).done(function() {

                    if (isValid.name && isValid.qty && isValid.amount && isValid.total) {

                        // ✅ push into array
                        items.push({
                            name: name,
                            qty: qty,
                            amount: amount,
                            total: total
                        });

                        // ✅ store in hidden input
                        $('#itemsInput').val(JSON.stringify(items));

                        // ✅ append to table
                        let row = `
                    <tr>
                        <td>${name}</td>
                        <td>${qty}</td>
                        <td>${amount}</td>
                        <td>${total}</td>
                    </tr>
                `;

                        $('table tbody').append(row);

                        // clear fields
                        $('[name="name"]').val('');
                        $('[name="qty"]').val('');
                        $('[name="amount"]').val('');
                        $('[name="total"]').val('');

                        // reset validation
                        isValid.name = false;
                        isValid.qty = false;
                        isValid.amount = false;
                        isValid.total = false;
                    }

                });

            });

            // ✅ FINAL SUBMIT (CUSTOMER ONLY)
            $('#customerForm').on('submit', function(e) {
                e.preventDefault();

                let customer_name = $('#customer_name').val();
                let phone = $('#phone').val();

                $.when(
                    validateField('customer_name', customer_name),
                    validateField('phone', phone)
                ).done(function() {

                    if (isValid.customer_name && isValid.phone) {

                        // ✅ ensure items are sent
                        $('#itemsInput').val(JSON.stringify(items));

                        $('#customerForm')[0].submit();
                    }

                });
            });

        });
    </script>


    {{-- <script>
        $(document).ready(function() {


            let isValid = {
                customer_name: false,
                phone: false,
                name: false,
                qty: false,
                amount: false,
                action: false,
                total: false
            };


            function validateField(fieldName, value) {
                return $.ajax({
                    url: "{{ route('customer.validate') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        field: fieldName,
                        value: value
                    },
                    success: function() {
                        let input = $('[name="' + fieldName + '"]');

                        input.removeClass('is-invalid');
                        $('#error-' + fieldName).remove();

                        isValid[fieldName] = true;
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON.error;
                        let input = $('[name="' + fieldName + '"]');

                        input.addClass('is-invalid');
                        $('#error-' + fieldName).remove();

                        input.after('<div id="error-' + fieldName + '" class="invalid-feedback">' +
                            error + '</div>');

                        isValid[fieldName] = false;
                    }
                });
            }


            $('#action').on('blur', function() {
                validateField('action', $(this).val());
            });
            $('#customer_name').on('blur', function() {
                validateField('customer_name', $(this).val());
            });

            $('#phone').on('blur', function() {
                validateField('phone', $(this).val());
            });


            $('[name="qty"], [name="amount"]').on('keyup', function() {
                let qty = parseFloat($('[name="qty"]').val()) || 0;
                let amount = parseFloat($('[name="amount"]').val()) || 0;
                $('[name="total"]').val(qty * amount);
            });


            $('#btnAddItem').on('click', function() {

                let name = $('[name="name"]').val();
                let action = $('[name="action"]').val();
                let qty = $('[name="qty"]').val();
                let amount = $('[name="amount"]').val();
                let total = $('[name="total"]').val();

                $.when(
                    validateField('name', name),
                    validateField('qty', qty),
                    validateField('amount', amount),
                    validateField('total', total)
                ).done(function() {

                    if (
                        isValid.name &&
                        isValid.qty &&
                        isValid.amount &&
                        isValid.total
                    ) {


                        let row = `
                    <tr>
                        <td>${name}</td>
                        <td>${qty}</td>
                        <td>${amount}</td>
                        <td>${total}</td>
                    </tr>
                `;

                        $('table tbody').append(row);

                        $('[name="name"]').val('');
                        $('[name="qty"]').val('');
                        $('[name="amount"]').val('');
                        $('[name="total"]').val('');

                        isValid.name = false;
                        isValid.qty = false;
                        isValid.amount = false;
                        isValid.total = false;
                    }

                });

            });


            $('#customerForm').on('submit', function(e) {
                e.preventDefault();

                let customer_name = $('#customer_name').val();
                let phone = $('#phone').val();

                $.when(
                    validateField('customer_name', customer_name),
                    validateField('phone', phone)
                ).done(function() {

                    if (isValid.customer_name && isValid.phone) {
                        $('#customerForm')[0].submit();
                    }

                });

            });

        });
    </script> --}}


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".datetimepicker", {
                dateFormat: "d-m-Y",
                enableTime: true,
                allowInput: true,
                defaultDate: "today"
            });
        });
    </script>

@endsection
