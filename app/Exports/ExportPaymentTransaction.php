<?php

namespace App\Exports;

use GuzzleHttp\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPaymentTransaction implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function collection()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v2/paymentTransactions?data=1";

        $data = [];
        if(session('membership_no') != ""){$url .= "&membership_no=".session('membership_no');}
        if(session('operation_type') != ""){$url .= "&operation_type=".session('operation_type');}
        if(session('status') != ""){$url .= "&status=".session('status');}
        if(session('start_date') != ""){$url .= "&start_date=".session('start_date');}
        if(session('end_date') != ""){$url .= "&end_date=".session('end_date');}

        $results = json_decode($client->get($url,['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(),true);

        foreach($results as $result)
        {
            $data[] =['payment_id'=> $result['payment_id'],
                    'datetime'=> $result['datetime'], 'membership_no'=> $result['membership_no'],
                    'operation_type'=> $result['operation_type'], 'status'=> $result['status'],
                    'service_fee'=> $result['service_fee'], 'app_fee'=> $result['app_fee'],
                    'merchant_amount'=> $result['merchant_amount']
                ];
        }
        // print_r($data);
        // exit;
        return collect($data);

    }

    public function headings(): array
    {
        return [
            'الرقم',
            'التاريخ',
            'رقم العضوية',
            'النوع',
            'الحالة',
            'سعر الخدمة',
            'سعر التطبيق',
            'سعر التاجر',
        ];
    }
}
