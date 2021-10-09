<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Registration;
use App\Services\PaypalPaymentService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PayPal\Api\InputFields;
use PayPal\Api\WebProfile;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaypalPaymentController extends Controller
{
    use AuthorizesRequests, WithSweetAlert;

    public ?Registration $registration;
    private $_api_context;

    public function __construct()
    {
        $this->registration = new Registration();

        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function payWithPaypal($registrationId = null)
    {
        $this->registration = Registration::with('assessment')->where('custom_id', $registrationId)->first();

        $this->authorize('pay', $this->registration);
        if (is_null($this->registration)) return redirect()->route('student.payments.view');

        Session::put('registration_id', $this->registration->custom_id);
        return view('paywithpaypal', ['registration' => $this->registration]);
    }

    public function postPaymentWithpaypal(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'balance' => ['required', 'numeric', 'min:1'],
        ]);

        $registration_id = Session::get('registration_id');
        Session::put('amount', $request->get('amount'));

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Registration ID: '.$registration_id)
            ->setCurrency('PHP')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('PHP')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription("Registration's Payment");

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('student.status'))
            ->setCancelUrl(URL::route('student.status'));

        //remove shipping option
        $inputFields = new InputFields();
        $inputFields->setNoShipping(1);

        $webProfile = new WebProfile();
        $webProfile->setName('test'.uniqid())->setInputFields($inputFields);

        $webProfileId = $webProfile->create($this->_api_context)->getId();

        $payment = new Payment();
        $payment->setExperienceProfileId($webProfileId); //remove no shipping
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                return redirect()->route('student.paywithpaypal', $registration_id)->with('swal:modal', [
                    'title' => $this->errorTitle,
                    'type' => $this->errorType,
                    'text' => 'Connection timeout!',
                ]);
            } else {
                return redirect()->route('student.paywithpaypal', $registration_id)->with('swal:modal', [
                    'title' => $this->errorTitle,
                    'type' => $this->errorType,
                    'text' => 'Some error occur, sorry for inconvenience :(',
                ]);
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }

        return redirect()->route('student.paywithpaypal', $registration_id)->with('swal:modal', [
            'title' => $this->errorTitle,
            'type' => $this->errorType,
            'text' => 'Unknown error occurred!',
        ]);
    }

    public function getPaymentStatus(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');
        $registration_id = Session::get('registration_id');
        $amount = Session::get('amount');

        Session::forget(['paypal_payment_id', 'registration_id', 'amount']);

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return redirect()->route('student.paywithpaypal', $registration_id)->with('swal:modal', [
                'title' => $this->errorTitle,
                'type' => $this->errorType,
                'text' => 'Payment cancelled!',
            ]);
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        try {
            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();

            $registration = new Registration();
            $registration = Registration::with('assessment')->where('custom_id', strval($registration_id))->firstOrFail();
            $registration = (new PaypalPaymentService())->store($registration, $sale->getId(), $amount);
        } catch (\Exception $e) {
            return redirect()->route('student.payments.view')->with('swal:modal', [
                'title' => $this->errorTitle,
                'type' => $this->errorType,
                'text' => $e->getMessage(),
            ]);
        }

        if ($result->getState() == 'approved') {
            return redirect()->route('student.payments.view')->with('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'Payment success!',
            ]);
        }

        return redirect()->route('student.paywithpaypal', $registration_id)->with('swal:modal', [
            'title' => $this->errorTitle,
            'type' => $this->errorType,
            'text' => 'Payment failed!',
        ]);
    }
}
