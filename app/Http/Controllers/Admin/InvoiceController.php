<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Assuming dompdf is installed or will be used for PDF generation
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function generate($paymentId)
    {
        $payment = Payment::with(['user', 'userPlan.plan', 'employee'])->findOrFail($paymentId);

        // check if invoice already exists
        $existingInvoice = Invoice::where('payment_id', $paymentId)->first();
        if ($existingInvoice) {
             return redirect()->route('admin.invoices.show', $existingInvoice->id);
        }

        $invoiceNumber = 'INV-' . strtoupper(Str::random(6)) . '-' . time();
        
        // In a real app, generate PDF here and save to path
        // For now, we'll simulate it or just create the record to view a blade invoice
        // Let's create the record first.
        
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'payment_id' => $payment->id,
            'invoice_date' => now(),
            'pdf_path' => 'invoices/' . $invoiceNumber . '.pdf', // Placeholder
        ]);

        return redirect()->route('admin.invoices.show', $invoice->id);
    }

    public function consolidated($userPlanId)
    {
        $userPlan = \App\Models\UserPlan::with(['user', 'plan', 'payments' => function($q) {
            $q->latest();
        }])->findOrFail($userPlanId);

        return view('Admin.invoices.consolidated', compact('userPlan'));
    }

    public function show($id)
    {
        $invoice = Invoice::with(['payment.user', 'payment.userPlan.plan'])->findOrFail($id);
        return view('Admin.invoices.show', compact('invoice'));
    }
    
    public function streamPdf($id)
    {
         // Logic to stream generated PDF using DomPDF
         // Need to install dompdf if not present: composer require barryvdh/laravel-dompdf
         // For now, just show the HTML view which can be printed
         $invoice = Invoice::with(['payment.user', 'payment.userPlan.plan'])->findOrFail($id);
         return view('Admin.invoices.pdf', compact('invoice'));
    }
}
