<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $transaction->custom_id.'.pdf' }}</title>
    <link rel="icon" href="{{ $school_profile_photo_path }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>

<body>
<div class="watermark" style="background-image: url({{$school_profile_photo_path}})"></div>
<div class="logo-container mb-3 center">
    <img src="{{ $school_profile_photo_path }}" alt="logo" width="50" height="50"/>
    <p class="truncate-widest bold">{{ $school_name ?? env('APP_NAME', 'University') }}</p>
    <p>{{ $school_address }}</p>
</div>

<div style="border: 1px solid #dcdfe0;">
    <div style="width: 100%; border-bottom: 2px solid #c7c4c4; border-bottom-style: dotted;">
        <div class="" style="position: relative; width: 100%; padding: 20px 10px 10px 10px;">
            <table style="font-size: 14px;">
                <tr>
                    <td style="text-align: left;">Transaction Details</td>
                    <td style="text-align: right;">{{ $transaction->created_at->timezone('Asia/Manila')->format('M. d, Y g:i:s A') ?? 'N/A' }} | Transaction ID: {{ $transaction->custom_id ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="" style="width: 100%; padding: 10px 0; margin: 0 10px; border-bottom: 2px solid #c7c4c4; border-bottom-style: dotted;">
        <table style="font-size: 14px;">
            <tr>
                <td style="text-align: left;">Payment received from {{$transaction->name ?? 'N/A'}}</td>
                <td style="text-align: right;">Amount</td>
            </tr>
            <tr>
                <td style="text-align: left;">Payment Status: {{$transaction->status ?? 'N/A'}}</td>
                <td style="text-align: right; font-size: 20px; font-weight: bolder;">{{$transaction->getFormattedPriceAttribute($transaction->amount) ?? 'N/A'}}</td>
            </tr>
        </table>
    </div>

    <div class="" style="width: 100%; padding: 10px; margin-top: 30px; background-color: lightgray;">
        <table style="font-size: 14px;">
            <tr>
                <td style="text-align: left;">Payment Details</td>
            </tr>
        </table>
    </div>

    <div class="" style="border-bottom: 2px solid #c7c4c4; border-bottom-style: dotted;">
        <table style="font-size: 14px; padding: 10px;">
            <tr>
                <td style="text-align: left; padding-bottom: 10px;">Registration ID: {{$transaction->registration->custom_id ?? '--'}}</td>
                <td style="text-align: left; padding-bottom: 10px;">Subtotal</td>
                <td style="text-align: right; padding-bottom: 10px;">{{$transaction->registration->totalFees() ?? '--'}}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;"></td>
                <td style="text-align: left; padding-bottom: 10px;">Additional</td>
                <td style="text-align: right; padding-bottom: 10px;">{{$transaction->getFormattedPriceAttribute($transaction->registration->assessment->additional) ?? '--'}}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;"></td>
                <td style="text-align: left; padding-bottom: 10px;">Discount @if (filled($transaction->registration->assessment->isPercentage))
                        {{$transaction->registration->assessment->discount_type ?? ''}} @endif</td>
                <td style="text-align: right; padding-bottom: 10px;">
                    @if (filled($transaction->registration->assessment->isPercentage))
                        {{$transaction->registration->assessment->discount_amount}}
                    @else
                        --
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;"></td>
                <td style="text-align: left; padding-bottom: 10px;">Grand Total</td>
                <td style="text-align: right; padding-bottom: 10px;">{{$transaction->getFormattedPriceAttribute($transaction->registration->assessment->grand_total) ?? '--'}}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;"></td>
                <td style="text-align: left; padding-bottom: 10px;">Balance</td>
                <td style="text-align: right; padding-bottom: 10px;">{{$transaction->getFormattedPriceAttribute($transaction->running_balance) ?? '--'}}</td>
            </tr>
        </table>
    </div>

    <div class="" style="width: 100%; padding: 10px; margin-top: 20px; border-bottom: 2px solid #c7c4c4; border-bottom-style: dotted;">
        <table style="font-size: 14px; width: 70%;">
            <tr>
                <td style="text-align: left; padding-bottom: 5px;">Paid by</td>
                <td style="text-align: left; padding-bottom: 5px;">{{$transaction->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="text-align: left;"></td>
                <td style="text-align: left; padding-bottom: 5px;">{{ $transaction->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Collected by</td>
                @if (filled($transaction->collector_id))
                    <td style="text-align: left; padding-top: 5px; padding-bottom: 5px;">{{ $transaction->collector->person->shortFullName ?? 'N/A' }}</td>
                @else
                    <td style="text-align: left; padding-top: 5px; padding-bottom: 5px;">{{ $school_name ?? 'N/A' }}</td>
                @endif
            </tr>
        </table>
    </div>

    <div class="" style="width: 100%; padding: 10px; margin-top: 20px;">
        <table style="font-size: 14px;">
            <tr>
                <td style="text-align: left;">Need help?</td>
            </tr>
            <tr>
                <td style="text-align: left;">Please contact us at <span style="font-weight: bolder">{{ $school_email ?? 'N/A' }}</span> for help with this transaction.</td>
            </tr>
        </table>
    </div>
</div>

<footer>
    <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
    <p>{{ $school_address ?? 'N/A' }} | Visit us: {{ env('APP_URL', 'university-ph.herokuapp.com') ?? 'N/A' }}</p>
</footer>
</body>
</html>
