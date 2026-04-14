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
                                    <div class="modal fade" id="editModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5>Edit Customer</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" id="edit_id">

                                                    <div class="mb-2">
                                                        <input type="text" name="c_name" id="c_name"
                                                            class="form-control" placeholder="Customer Name">
                                                    </div>

                                                    <div class="mb-2">
                                                        <input type="text" name="phone" id="phone"
                                                            class="form-control" placeholder="Phone">
                                                    </div>

                                                    <div class="mb-2">
                                                        <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>"
                                                            class="form-control datetimepicker" name="date"
                                                            placeholder="Select Date">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" id="btnUpdate">Update</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- <button type="submit" id="action" value="customer"
                                        name="action"class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>

                        </form>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-primary">
                            <thead>
                                <tr>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">total</th>

                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orders as $order)
                                    <tr class="">
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->date }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->item_sum_total }}</td>

                                        <td>
                                            <a href="{{ route('customer.show', $order->id) }}" class="btn btn-primary"
                                                onclick="return showAlert()">Show</a>
                                            <button class="btn btn-warning btnEdit" data-id="{{ $order->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('customer.destroy', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            let items = [];

            let isValid = {
                customer_name: false,
                phone: false,
                name: false,
                qty: false,
                amount: false,
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


                        items.push({
                            name: name,
                            qty: qty,
                            amount: amount,
                            total: total
                        });


                        $('#itemsInput').val(JSON.stringify(items));


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


                        $('#itemsInput').val(JSON.stringify(items));

                        $('#customerForm')[0].submit();
                    }

                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            // open edit modal
            $('.btnEdit').click(function() {
                let id = $(this).data('id');

                $.ajax({
                    url: '/customers/' + id + '/edit',
                    type: 'GET',
                    success: function(data) {

                        $('#edit_id').val(data.id);
                        $('#c_name').val(data.name);
                        $('#phone').val(data.phone);
                        $('#date').val(data.date);

                        $('#editModal').modal('show');
                    }
                });
            });


            // update Data
            $('#btnUpdate').click(function() {

                let id = $('#edit_id').val();

                $.ajax({
                    url: '/customers/' + id,
                    type: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: $('#c_name').val(),
                        phone: $('#phone').val(),
                        date: $('#date').val()
                    },

                    success: function(response) {
                        alert('Updated Successfully');

                        $('#editModal').modal('hide');

                        location.reload(); // refresh table
                    },

                    error: function(xhr) {
                        alert('Error updating data');
                    }
                });

            });

        });
    </script>

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
