<html>

<head></head>

<body>
    <h1>Subscription Management</h1>
    {{-- <form method="POST" action="{{ route('process-subscription') }}"
        data-stripe-publishable-key="pk_test_51N4Ia5SJ1UYNZRihdQIIfzZb05pMLX1ezs0n2umyWxHxiKcsK2GLUTdl36Bp8exdpzZT6KaLILHw3MSeI5UxcTfi00D6MkmhIE">
        @csrf
        <input type="text" name="card" id="">
        <input type="text" name="expMon" id="">
        <input type="text" name="expYr" id="">
        <input type="text" name="Cvv" id="">
        <button type="submit">Pay Next Subscription</button>
    </form> --}}
    <form role="form" action="{{ route('process-subscription') }}" method="post" class="validation"
        data-cc-on-file="false"
        data-stripe-publishable-key="pk_test_51N5PI0DEotjugn5yovpe3ZxjMGCXkG6GRzV8lqWZ9UN0RYUV4fOZsq5gawDDVDQsZOaUjxlzPPRtZNPUhF7KOdlg00JgyRXwue"
        id="payment-form">
        @csrf
        <input type="hidden" name="item_name" value="ponds">
        <input type="hidden" name="amount" value="50">
        <!-- <input type="hidden" name="currency_code" value="AUD"> -->
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="product_id" value="129">
        <input type="hidden" name="coach_id" value="916">
        <div class="row">
            <div class="col">
                <div class="form-group required">
                    <label class="control-label" for="email">Name on Card</label>
                    <input class="form-control" size="4" type="text">
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col">
                <div class="form-group card required">
                    <label class="control-label" for="Card Number">Card Number</label>
                    <input autocomplete="off" class="form-control card-num" size="20" type="text">
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group cvc required">
                    <label class="control-label" for="CVC">CVC</label>
                    <input autocomplete="off" class="form-control card-cvc" placeholder="e.g 415" size="4"
                        type="text">
                </div><!--form-group-->
            </div><!--col-->
            <div class="col-12 col-md-4">
                <div class="form-group expiration required">
                    <label class="control-label" for="Expiration Month">Expiration Month</label>
                    <input class="form-control card-expiry-month" placeholder="MM" size="2" type="text">
                </div><!--form-group-->
            </div><!--col-->
            <div class="col-12 col-md-4">
                <div class="form-group expiration required">
                    <label class="control-label" for="Expiration Year">Expiration Year</label>
                    <input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text">
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
        <div class="form-row row">
            <div class="col-md-12 hide error form-group">
                <div class=" alert"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" id="paymentpay1" class="btn btn-success">Payment ($USD 50)</button>
            </div>
        </div>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function() {
        var $form = $(".validation");
        $('form.validation').bind('submit', function(e) {
            var $form = $(".validation"),
                inputVal = ['input[type=email]', 'input[type=password]', 'input[type=text]',
                    'input[type=file]', 'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputVal),
                $errorStatus = $form.find('div.error'),
                valid = true;
            $errorStatus.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorStatus.removeClass('hide');
                    e.preventDefault();
                }
            });
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-num').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeHandleResponse);
            }
        });

        function stripeHandleResponse(status, response) {
            if (response.error) {
                $('.error').removeClass('hide').find('.alert').addClass('alert-danger').text(response.error
                    .message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
</script>

</html>
