<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function generateInvoiceNumber()
    {
        $uniqueServiceNo = false;
        while (!$uniqueServiceNo) {
            $ServiceNo = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Check if the generated Service number is unique
            if (!DB::table('invoices')->where('invoice_number', $ServiceNo)->exists()) {
                $uniqueServiceNo = true;
            }
        }

        return $ServiceNo;
    }

    public function storeServiceNumber($number , $membership , $path ,$type)
    {
        $invoice = new Invoice();
        $invoice->invoice_number = $number;
        $invoice->membership_no = $membership;
        $invoice->type = $type;
        $invoice->path = $path;
        $invoice->save();
    }
}
