@extends('welcome')

@section('content')

<script>
    function showMessage(messageID)
    {
        var message_text = "message_text"+messageID;
        var message_date = "message_date"+messageID;
        document.getElementById("message-content").innerHTML = document.getElementById(message_text).innerHTML;
        document.getElementById("msg_date").innerHTML = document.getElementById(message_date).innerHTML;

        var allMesaages = document.getElementsByClassName("mail-list");
        for(let m=0; m < allMesaages.length; m++)
        {
            allMesaages[m].classList.remove("new_mail");
        }
        document.getElementById("mail_list"+messageID).classList.add("new_mail");
    }
</script>

@if(count($messages) > 0)
<div class="email-wrapper wrapper" dir="rtl">
    <div class="row align-items-stretch">
        <div class="mail-list-container col-lg-3 pt-4 pb-4 border-right bg-white">
            <div class="border-bottom pb-4 mb-3 px-3">
                <a href="/emailCustomer/{{ $customer['id'] }}" class="btn btn-primary btn-block">إنشاء</a>
            </div>
            @foreach ($messages as $message)
                <div class="mail-list @if($loop->first) new_mail @endif" id="mail_list{{ $message->id }}">
                    <div class="content" onclick="showMessage({{ $message->id }})">
                        <p class="sender-name">{{ $message->title }}</p>
                        <p class="message_text" id="message_text{{ $message->id }}">
                            {!! $message->body !!}
                        </p>

                        <p class="sender-date" id="message_date{{ $message->id }}" style="display: none">{{ $message->created_at }}</p>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="mail-view d-none d-md-block col-lg-9 bg-white">
            <div class="message-body">
                <div class="sender-details">
                    <img class="img-sm rounded-circle me-3" src="/imgs/logo.jpeg" alt=""> &nbsp;&nbsp;&nbsp;
                    <div class="details">
                        <p class="msg-subject">
                            شركه وﺟﻴﻦ ﻟﺘﻘﻨﻴﺔ اﻟﻤﻌﻠﻮﻣﺎت - (<span id="msg_date">{{ $messages[0]->created_at }}</span>)
                        </p>
                        <p class="sender-email">
                            <a href="#">wajen@wajen.sa</a>
                        </p>
                    </div>
                </div>
                <div class="message-content">
                    <p id="message-content">
                        {!! $messages[0]->body !!}
                    </p>
                </div>
                <div class="attachments-sections">
                    <ul>
                        <li>
                            <div class="thumb"><i class="typcn typcn-document"></i></div>
                            <div class="details">
                            <p class="file-name">Invoice.pdf</p>
                            <div class="buttons">
                                {{--  <p class="file-size">678Kb</p>  --}}
                                <a href="/CustomerBill/{{ $customer['id'] }}/{{ $customer['package_id'] }}/2" class="view">View</a>
                            </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body">
        <div class="alert alert-fill-primary justify-content-between" role="alert" dir="rtl">
            <label class="float-right">
                <i class="typcn typcn-warning"></i>
                لا توجد رسائل سابقة
            </label>
            {{--  <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon text" style="float: left !important;">
                <i class="mdi mdi-plus"></i>
            </button>  --}}
            <a href="/emailCustomer/{{ $customer['id'] }}" class="badge badge-outline-primary text-white" style="float: left !important;">
                <i class="mdi mdi-plus"></i>
            </a>
        </div>
    </div>
</div>
@endif

@endsection
