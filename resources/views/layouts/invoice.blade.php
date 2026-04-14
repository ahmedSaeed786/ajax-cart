@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <section class="py-3 py-md-5">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                                        <div class="row gy-3 mb-3">
                                            <div class="col-6">
                                                <h2 class="text-uppercase text-endx m-0">Invoice</h2>
                                            </div>
                                            <div class="col-6">
                                                <a class="d-block text-end" href="#!">
                                                    <img src="https://finance.naweriindustries.com/assets/images/logo%20-%20naweriindustries.jpeg"
                                                        class="img-fluid" alt="BootstrapBrain Logo" width="135"
                                                        height="44">
                                                </a>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-sm-6 col-md-8">
                                                <h4>Bill To</h4>
                                                <address>
                                                    <strong>{{ $customer->name }}</strong><br>

                                                    Date: {{ $customer->date }}<br>
                                                    Phone: {{ $customer->phone }}
                                                </address>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-4">
                                                <h6 class="row">
                                                    <span class="col-8">Invoice {{ $customer->id }}</span>

                                                </h6>

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="text-uppercase">Product</th>
                                                                <th scope="col" class="text-uppercase">Qty</th>
                                                                <th scope="col" class="text-uppercase text-end">Unit
                                                                    Price</th>
                                                                <th scope="col" class="text-uppercase text-end">Amount
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-group-divider">
                                                            @foreach ($customer->item as $item)
                                                                <tr>
                                                                    <td>{{ $item->name }}</td>
                                                                    <th scope="row">{{ $item->qty }}</th>
                                                                    <td class="text-end">{{ $item->amount }}</td>
                                                                    <td class="text-end">{{ $item->total }}</td>
                                                                </tr>
                                                            @endforeach



                                                            <tr>
                                                                <th scope="row" colspan="3"
                                                                    class="text-uppercase text-end">Total</th>
                                                                <td class="text-end">{{ $customer->item_sum_total }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-primary mb-3">Download
                                                    Invoice</button>
                                                <button type="submit" class="btn btn-danger mb-3">Submit Payment</button>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>




                </div>
            </div>
        </div>
    </div>
