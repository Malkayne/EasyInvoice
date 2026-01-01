<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->invoices()->with('customer')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = auth()->user()->customers()->orderBy('name')->get();
        // Generate the next invoice number based on the highest existing number
        $invoice = new \App\Models\Invoice(['user_id' => auth()->id()]);
        $nextInvoiceNumber = $invoice->generateInvoiceNumber();
        
        return view('invoices.create', compact('customers', 'nextInvoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0', // Passed from UI for calculation verification
        ]);

        $subtotal = 0;
        $itemsData = [];

        foreach ($request->items as $item) {
            $amount = round($item['quantity'] * $item['unit_price'], 2);
            $subtotal += $amount;
            $itemsData[] = [
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'amount' => $amount,
            ];
        }

        $taxRate = $request->input('tax_rate', auth()->user()->businessProfile->tax_rate ?? 0);
        $taxTotal = round($subtotal * ($taxRate / 100), 2);
        $total = $subtotal + $taxTotal;

        $invoice = auth()->user()->invoices()->create([
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'],
            'due_date' => $validated['due_date'],
            'subtotal' => $subtotal,
            'tax_total' => $taxTotal,
            'total' => $total,
            'status' => 'draft',
        ]);

        $invoice->items()->createMany($itemsData);

        return redirect()->route('dashboard')->with('success', 'Invoice created successfully.');
    }

    public function show(\App\Models\Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }
        $invoice->load('customer', 'items');
        return view('invoices.show', compact('invoice'));
    }

    public function download(\App\Models\Invoice $invoice)
    {
        // Allow public download if accessed via valid public token context, or auth check
        // For simplicity, we'll check auth OR if the request refers to a valid public link?
        // Actually, let's keep it simple: Auth check for now, Public controller for public.
        
        // Wait, requirements say "Public Share Link".
        // Let's implement a public download check:
        // If user is logged in & owns it -> OK.
        // If not logged in, we need a public token route for download too? 
        // Let's stick to auth for this specific route, and make a separate public route if needed.
        // Actually, standard practice: secure download route for admin, public route for client.
        
        if (auth()->check() && $invoice->user_id === auth()->id()) {
             // download allowed
        } else {
             abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function publicShow($token)
    {
        $invoice = \App\Models\Invoice::where('public_token', $token)->with('user.businessProfile', 'customer', 'items')->firstOrFail();
        return view('invoices.public', compact('invoice'));
    }

    public function email(\App\Models\Invoice $invoice, Request $request)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'recipient_email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'attach_pdf' => 'boolean',
        ]);

        try {
            // Generate PDF if attachment is requested
            $pdfPath = null;
            if ($request->boolean('attach_pdf')) {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', compact('invoice'));
                $pdfPath = storage_path('app/temp/invoice_' . $invoice->invoice_number . '.pdf');
                $pdf->save($pdfPath);
            }

            // Send email
            \Mail::to($validated['recipient_email'])->send(new \App\Mail\InvoiceMail($invoice, $validated['subject'], $validated['message'], $pdfPath));

            // Update invoice status to 'sent'
            if ($invoice->status === 'draft') {
                $invoice->update(['status' => 'sent']);
            }

            // Clean up temporary PDF
            if ($pdfPath && file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            return response()->json(['success' => true, 'message' => 'Invoice sent successfully!']);

        } catch (\Exception $e) {
            \Log::error('Failed to send invoice: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send invoice. Please try again.']);
        }
    }

    public function markAsPaid(\App\Models\Invoice $invoice, Request $request)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $invoice->update(['status' => 'paid']);

        return response()->json(['success' => true, 'message' => 'Invoice marked as paid!']);
    }
}
