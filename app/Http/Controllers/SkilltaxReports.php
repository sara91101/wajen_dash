<?php

namespace App\Http\Controllers;

use App\Exports\ExportPaymentTransaction;
use App\Http\Controllers\Controller;
use App\Models\Info;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SkilltaxReports extends Controller
{
    public function paymentTransactions(Request $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v2/paymentTransactions?data=1";

        if($request->membership_no){$url .= "&membership_no=$request->membership_no";Session(['membership_no' => $request->membership_no]);}
        if($request->operation_type){$url .= "&operation_type=$request->operation_type";Session(['operation_type' => $request->operation_type]);}
        if($request->status){$url .= "&status=$request->status";Session(['status' => $request->status]);}
        if($request->start_date){$url .= "&start_date=$request->start_date";Session(['start_date' => $request->start_date]);}
        if($request->end_date){$url .= "&end_date=$request->end_date";Session(['end_date' => $request->end_date]);}

        $paymentTransactions = json_decode($client->get($url,['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(), true);
        return view('paymentTransactions',compact('paymentTransactions'));
    }
    public function paymentTransactionsPdf()
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = "https://back.skilltax.sa/api/v2/paymentTransactions?data=1";

        if(session('membership_no') != ""){$url .= "&membership_no=".session('membership_no');}
        if(session('operation_type') != ""){$url .= "&operation_type=".session('operation_type');}
        if(session('status') != ""){$url .= "&status=".session('status');}
        if(session('start_date') != ""){$url .= "&start_date=".session('start_date');}
        if(session('end_date') != ""){$url .= "&end_date=".session('end_date');}

        $data["info"] = Info::first();

        $data['paymentTransactions'] = json_decode($client->get($url,['headers' => ['Authorization' => 'Bearer ' . $token]])->getBody()->getContents(),true);

        $pdf = PDF::loadView('paymentTransactionsPdf', $data);

        return $pdf->stream();
    }

    public function paymentTransactionsExcel()
    {
        return Excel::download(new ExportPaymentTransaction, 'تقرير المدفوعات.xlsx');
    }

    public function removeSearch()
    {
        Session(['membership_no' => ""]);
        Session(['operation_type' => ""]);
        Session(['status' => ""]);
        Session(['start_date' => ""]);
        Session(['end_date' => ""]);

        return redirect('/paymentTransactions');
    }

    public function skilltaxLoginReport(Request $request)
    {
        $client = new Client();
        $token = session("skillTax_token");
        $url = Config('app.skilltax_v1')."loginLogs";

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ],
            'query' => [ 
                'membership_no' => $request->membership_no,
                'status' => $request->status,
                'paginate' => 25,
                'page' => $request->get('page', 1)
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        $items = collect($result['data']);

        $data = new LengthAwarePaginator(
            $items,
            $result['total'],
            $result['per_page'],
            $result['current_page'],
            ['path' => url()->current() , 'query' => $request->query()]
        );

        return view('skilltaxLoginReport',['logins' => $data]);
    }
}
