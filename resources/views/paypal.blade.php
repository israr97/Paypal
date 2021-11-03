@extends('layouts.app')

@section('content')


@if(Session::has('success'))
<div class="alert alert-danger" role="alert">
    {{Session::get('success')}}
</div>
@endif

<div style="margin-left: 400px; width: 300px;">
    <h3>My Book Store</h3>
    <div>
        <p><em>A Dummy Book Title</em></p>
        <input class="form-control" type="text" id="price" auto-focus placeholder="$USD">
    </div>
    <div style="width:120px; margin-top:10px;" id="paypal-button-container"></div>
    <br>
    <div class="links">
        <form action="/api/payment" method="POST">
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{env('STRIPE_KEY')}}" data-amount="200" data-name="Abrar" data-description="Examples" data-locale="auto" data-currency="usd">
            </script>

        </form>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    paypal.Buttons({
        style: {
            layout: 'horizontal',
            size: 'small',
            color: 'blue',
            // shape:  'pill',
            height: 30,
            // tagline: 'false'
        },
        createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                application_context: {
                    brand_name: 'ZeeShip Payment',
                    user_action: 'PAY_NOW',
                },
                purchase_units: [{
                    amount: {
                        value: $('#price').val()
                    }
                }],
            });
        },

        onApprove: function(data, actions) {
            console.log(data);
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
                if (details.status == 'COMPLETED') {
                    // console.log(JSON.stringify(details.purchase_units[0].payments.captures[0].id));
                    var transid = JSON.stringify(details.purchase_units[0].payments.captures[0].id)
                    var price = $('#price').val()

                    console.log('trans' + transid)
                    console.log('amount' + price)

                    $.ajax({
                        method: "post",
                        dataType: 'json',
                        url: "{{ route ('complete.payment') }}",
                        data: {
                            trans_id: transid,
                            amount: price,
                        },
                        header: {
                            'accept': 'application/json',
                            'content-Type': 'application/json',

                        },
                        success: function(data) {
                            if (data) {
                                // console.log('here is ',data.token)
                                console.log(data.transid + data.price)
                                alert('Success')
                            } else {
                                console.log('Error')

                            }
                            // console.log('token', localStorage.getItem('token'))
                        },
                    });

                } else {
                    console.log('error=' + data);
                    //   window.location.href = '/pay-failed?reason=failedToCapture';
                }
            });
        },

        onCancel: function(data) {
            console.log('error=' + data);
            // window.location.href = '/pay-failed?reason=userCancelled';
        }



    }).render('#paypal-button-container');
    // This function displays Smart Payment Buttons on your web page.

    function status(res) {
        if (!res.ok) {
            throw new Error(res.statusText);
        }
        return res;
    }
</script>


@endsection