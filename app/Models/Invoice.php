<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'date',
        'due_date',
        'subtotal',
        'tax_total',
        'discount_total',
        'total',
        'status',
        'public_token',
        'note',
        'currency',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = $invoice->generateInvoiceNumber();
            }
            $invoice->public_token = (string) \Illuminate\Support\Str::uuid();
        });
    }

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function generateInvoiceNumber()
    {
        // Get all invoice numbers for this user and find the highest number
        $invoices = self::where('user_id', $this->user_id)->pluck('invoice_number');

        $maxNumber = 0;
        foreach ($invoices as $invoiceNumber) {
            if (preg_match('/INV-(\d+)/', $invoiceNumber, $matches)) {
                $number = (int) $matches[1];
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
        }

        $nextNumber = $maxNumber + 1;
        return 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
