<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Validation\Rule;
use App\Mail\SendInvoiceMail;
use Razorpay\Api\Api;
use App\Mail\PaymentLinkMail;
class InvoiceController extends Controller
{
    public function index($id)
    {
        $invoices = Invoice::with('client')->where('client_id',$id)->get();
    
        return view('invoices.index', compact('invoices','id'));
    }

    public function create($id,$type)
    {
        $clients = auth()->user()->clients;
        $invlices = Invoice::where('client_id',$id)->get();
        if($type == 'new')
        {
            $value='';
        }
        else
        {
            $value = Invoice::where('id',$type)->first();
        }
        return view('invoices.create', compact('clients','invlices','id','type','value'));
    }

    public function store(Request $request)
    {
        // echo "<pre>";print_r($request->all());die;

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => [
                'required',
                Rule::unique('invoices')->ignore($request->id),
            ],
            'invoice_date' => 'required|date',
            'status' => 'required',
            'total' => 'required|numeric|min:100',
        ]);
        if($request->id == 'new')
        {
            $invoice = Invoice::create([
                'client_id' => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'total' => $request->total,
                'status' => $request->status,
            ]);
        }
        else{
            $invoice = Invoice::where('id', $request->id)->update([
                'client_id' => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'total' => $request->total,
                'status' => $request->status,
            ]);
            
        }

      

       return redirect()->route('index',['id'=>$request->client_id])->with('success', 'Invoice created!');
    }

    public function edit(Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $invoice->update($request->only(['invoice_date', 'status']));

        return redirect()->route('invoices.index')->with('success', 'Invoice updated!');
    }

    public function delete($id)
    {
        Invoice::where('id',$id)->delete();
        return back()->with('success', 'Invoice deleted.');
    }
    public function exportPDF(Invoice $invoice) {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice_{$invoice->invoice_number}.pdf");
    }
    public function sendEmail(Invoice $invoice) {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))->output();
    
        Mail::send([], [], function ($message) use ($invoice, $pdf) {
            $message->to($invoice->client->email)
                ->subject("Invoice #{$invoice->invoice_number}")
                ->attachData($pdf, "invoice_{$invoice->invoice_number}.pdf")
                ->setBody('Please find your invoice attached.', 'text/html');
        });
    
        return back()->with('success', 'Invoice sent successfully!');
    }
    public function send(Request $request, Invoice $invoice)
{
    Mail::to($invoice->client->email)->send(new SendInvoiceMail($invoice));
    return back()->with('success', 'Invoice sent successfully!');
}

public function sendPaymentLink($id)
{
    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    $invoice =  Invoice::where('id',$id)->first();
    if($invoice)
    {

        $client = Client::where('id',$invoice->client_id)->first();
            $payment = $api->paymentLink->create([
                'amount' => intval($invoice->total), // Amount in paise (e.g., ₹100)
                'currency' => 'INR',
                'description' => 'Service Payment',
                'customer' => [
                    'name' => $client->name,
                    'email' => $client->email,
                    'contact' => $client->phone,
                ],
                'notify' => [
                    'email' => false,
                    'sms' => false,
                ],
                'callback_url' => url('/payment/callback'),
                'callback_method' => 'get',
            ]);

          $link = $payment['short_url'];
            Mail::to($client->email)->send(new PaymentLinkMail($link));


            return back()->with('success', 'Payment link sent successfully!');
    }
    else{
        return back()->with('error', 'invoice not found');
    }

    
}
}
