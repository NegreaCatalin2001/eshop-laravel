@extends('layouts.front')

@section('title')
    Checkout
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-warning border-top">
        <div class="container">
            <h6 class="mb-0">
                <a href="{{ url('/') }}">
                    Home
                </a> /
                <a href="{{ url('checkout') }}">
                    Checkout
                </a>
            </h6>
        </div>
    </div>


    <div class="container mt-3">
        <form action="{{ url('place-order') }}" method="POST" id="payment-form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h6>Basic Details</h6>
                            <hr>
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="firstName">First Name</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('fname') ? 'is-invalid' : '' }}" name="fname"
                                        placeholder="Enter First Name" value="{{ old('fname', Auth::user()->fname) }}"
                                        required>
                                    @if ($errors->has('fname'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fname') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('lname') ? 'is-invalid' : '' }}" name="lname"
                                        placeholder="Enter Last Name" value="{{ old('lname', Auth::user()->lname) }}"
                                        required>
                                    @if ($errors->has('lname'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('lname') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="email">Email</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                                        placeholder="Enter Email" value="{{ old('email', Auth::user()->email) }}" required>
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone"
                                        placeholder="Enter Phone Number" value="{{ old('phone', Auth::user()->phone) }}"
                                        required pattern="^\+?(\d[\d\s\-()]{7,15})\d$">
                                    @if ($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="address">Address</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                        name="address" placeholder="Enter Address"
                                        value="{{ old('address', Auth::user()->address) }}" required>
                                    @if ($errors->has('address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="city">City</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city"
                                        placeholder="Enter City" value="{{ old('city', Auth::user()->city) }}" required>
                                    @if ($errors->has('city'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('city') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="county">County</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('county') ? 'is-invalid' : '' }}"
                                        name="county" placeholder="Enter County"
                                        value="{{ old('county', Auth::user()->county) }}" required>
                                    @if ($errors->has('county'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('county') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="country">Country</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                        name="country" placeholder="Enter Country"
                                        value="{{ old('country', Auth::user()->country) }}" required>
                                    @if ($errors->has('country'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('country') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="postalcode">Postal Code</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('postalcode') ? 'is-invalid' : '' }}"
                                        name="postalcode" placeholder="Enter Postal Code"
                                        value="{{ old('postalcode', Auth::user()->postalcode) }}" required>
                                    @if ($errors->has('postalcode'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('postalcode') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h6>Order Details</h6>
                            <hr>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total=0; @endphp
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            @php $total += ($item->products->selling_price * $item->prod_qty) @endphp
                                            <td>{{ $item->products->name }}</td>
                                            <td>{{ $item->prod_qty }}</td>
                                            <td>${{ $item->products->selling_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <h6 class="px-2">Total Price <span class="float-end">${{ $total }}</span></h6>
                            <div id="card-element">
                            </div>
                            <div id="card-errors" role="alert"></div>
                            <hr>
                            <button type="submit" class="btn btn-primary w-100">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe(
            'pk_test_51OLkz4DGYtAiiaLVxXt4DAwbj9uPX25xjR0jHZVrgHmRr6bwfDJkUqWD2mGdC3VhKnUD1HRyiPZ5i0nq9WUnOb6G00aGVwth23'
        );

        var elements = stripe.elements();

        var style = {
            base: {}
        };

        var card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });
        card.mount('#card-element');

        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

             form.submit();
        }
    </script>
@endsection
