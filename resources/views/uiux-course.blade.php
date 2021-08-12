@extends('layout.app')
@section('content')
    <div>
        <img src="https://www.softopark.com/static/images/logo/Softopark_Best_IT_Firm_in_Bangladesh.png"
            class="rounded mx-auto d-block" alt="">
    </div>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Complete UI UX Masterclass Course</h2>
            <p class="lead">Please fill up the form with accurate information</p>
        </div>

        <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-secondary badge-pill">3</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Product name</h6>
                                <small class="text-muted">UI UX Course</small>
                            </div>
                            <span class="text-muted">1000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (BDT)</span>
                            <strong>
                                {{-- <input type="text" name="total_amount" class="form-control" id="total_amount"
                                    placeholder="Net Amount" required /> --}}
                                <input type="hidden" value="5000" name="amount" id="total_amount" required />10,000
                            </strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Billing address</h4>
                    <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="firstName">Full name</label>
                                <input type="text" name="customer_name" class="form-control" id="customer_name"
                                    placeholder="" required>
                                {{-- important credintials --}}
                                <input type="hidden" value="uiux" name="plan_id" id="plan_id" required>
                                {{-- <input type="hidden" value="10000" name="amount" id="total_amount" required /> --}}
                                <div class="invalid-feedback">
                                    Valid customer name is required.
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="total_amount">Enter Amount</label>
                            <input type="text" name="total_amount" id="total_amount" placeholder="Enter Your amount"
                                required />
                            <div class="invalid-feedback">
                                Valid customer name is required.
                            </div>
                        </div>
                    </div> --}}

                        <div class="mb-3">
                            <label for="mobile">Mobile</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+88</span>
                                </div>
                                <input type="text" name="customer_mobile" class="form-control" id="mobile"
                                    placeholder="Mobile" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your Mobile number is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" name="customer_email" class="form-control" id="email"
                                placeholder="you@example.com" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St"
                                required>
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div> --}}

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="country">Country</label>
                                <select class="custom-select d-block w-100" id="country" required>
                                    <option value="">Choose...</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">State</label>
                                <select class="custom-select d-block w-100" id="state" required>
                                    <option value="">Choose...</option>
                                    <option value="Dhaka">Dhaka</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Zip</label>
                                <input type="text" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                    </form>
                </div>
            </div>

            <footer class="my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">&copy; 2021 Softopark</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Privacy</a></li>
                    <li class="list-inline-item"><a href="#">Terms</a></li>
                    <li class="list-inline-item"><a href="#">Support</a></li>
                </ul>
            </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

@endsection
