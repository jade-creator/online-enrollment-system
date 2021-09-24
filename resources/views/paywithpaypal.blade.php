{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <title>How to integrate paypal payment in Laravel - websolutionstuff.com</title>--}}
{{--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--}}
{{--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-8 col-md-offset-2">--}}
{{--            <h3 class="text-center" style="margin-top: 30px;">How to integrate paypal payment in Laravel - websolutionstuff.com</h3>--}}
{{--            <div class="panel panel-default" style="margin-top: 60px;">--}}

{{--                @if ($message = Session::get('success'))--}}
{{--                    <div class="custom-alerts alert alert-success fade in">--}}
{{--                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
{{--                        {!! $message !!}--}}
{{--                    </div>--}}
{{--                    <?php Session::forget('success');?>--}}
{{--                @endif--}}

{{--                @if ($message = Session::get('error'))--}}
{{--                    <div class="custom-alerts alert alert-danger fade in">--}}
{{--                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
{{--                        {!! $message !!}--}}
{{--                    </div>--}}
{{--                    <?php Session::forget('error');?>--}}
{{--                @endif--}}
{{--                <div class="panel-heading"><b>Paywith Paypal</b></div>--}}
{{--                <div class="panel-body">--}}
{{--                    <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('paypal') !!}" >--}}
{{--                        {{ csrf_field() }}--}}

{{--                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">--}}
{{--                            <label for="amount" class="col-md-4 control-label">Enter Amount</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" autofocus>--}}

{{--                                @if ($errors->has('amount'))--}}
{{--                                    <span class="help-block">--}}
{{--                                        <strong>{{ $errors->first('amount') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <div class="col-md-6 col-md-offset-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    Paywith Paypal--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

<x-app-layout>
<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Payment"></x-table.title>

{{--        @isset ($registration)--}}
            <form class="" method="POST" id="payment-form" role="form" action="{!! URL::route('student.paypal') !!}" >
                {{ csrf_field() }}

                <div class="">
                    <label for="registrationId" class="">Registration ID:</label>

                    <div class="">
                        <input id="registrationId" type="text" class="" name="registrationId" value="{{ $registration->id }}" readonly autofocus>
                    </div>

                    <label for="total" class="">Grand Total:</label>
                    <div class="">
                        <input id="total" type="number" class="" name="total" value="{{ $registration->assessment->grand_total }}" readonly autofocus>
                    </div>

                    <label for="balance" class="">Balance</label>
                    <div class="">
                        <input id="balance" type="number" class="" name="balance" value="{{ $registration->assessment->balance }}" readonly autofocus>
                    </div>

                    <label for="amount" class="">Enter Amount</label>
                    <div class="">
                        <input id="amount" type="number" class="" name="amount" value="{{ old('amount') }}" min="0" autofocus>
                    </div>
                </div>

                <div class="">
                    <div class="">
                        <button type="submit" class="">
                            Pay with Paypal
                        </button>
                    </div>
                </div>
            </form>
{{--        @endisset--}}
    </div>
</div>
</x-app-layout>
