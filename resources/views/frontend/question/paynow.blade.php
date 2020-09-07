@extends('frontend.layout.app')
@section('main')
    <section class="container main-content">
        <div class="row mt-5">
            <div class="col-md-12">
                <ul class="process-steps clearfix">
                    <li class="acttive done" style="width: 50%">
                        <div class="icon">1</div>
                        <div class="title">Expert List</div>
                    </li>
                    <li class="acttive done" style="width: 50%">
                        <div class="icon">2</div>
                        <div class="title">Payment</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="page-content page-shortcode mt-5">
                    <div class="box_icon">
                        @if ($amount = Session::get('amount'))
                            <h2>Total Fees:   {{ $amount }} USD</h2>
                        @endif
                        <div class="gap"></div>
                        <div class="poll_2">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div><!-- End main -->
        </div>
        <!-- End row -->
    </section><!-- End container -->
@endsection
@push("js")
    <script src="https://www.paypal.com/sdk/js?client-id={{$client}}&currency=USD">
    </script>
    <script>
        let amount = {{Session::get('amount')}};
        paypal.Buttons({
            style: {
                color:  'blue',
                shape:  'pill',
                label:  'pay',
                height: 40
            },
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount
                        }
                    }],
                    application_context: {
                        shipping_preference: 'NO_SHIPPING'
                    }
                });
            },
            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
                    addPypalData(data)
                    /*alert('Transaction completed by ' + details.payer.name.given_name + '!');*/
                });
            }
        }).render('#paypal-button-container');

        function addPypalData(data){
            $.post('{{ route('payments_sdk') }}', {_token:'{{ @csrf_token() }}',data:data}, function(data){
                if(data['status']==200){
                    Swal.fire({
                        title: "Payment ",
                        text: "Completed Successfully!",
                        type: "success"
                    }).then((result) => {
                        window.location.href = "{{route('/')}}";
                    });
                }
            });
        }
    </script>
@endpush
