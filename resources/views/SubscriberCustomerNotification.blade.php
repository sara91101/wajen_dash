@extends('welcome')

@section('content')


<script>
    function processNotification(id,status,message)
    {
        swal({
                title: 'تحذير',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                customClass: {
            actions: 'vertical-buttons',
            cancelButton: 'top-margin'
            },
                buttons: {
                cancel: {
                    text: "لا",
                    value: null,
                    visible: true,
                    className: "btn btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "نعم",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
                }
            }).then(okay => {
            if (okay) {
                window.location = "/SubscriberCustomerNotification/changeStatus/"+id+"/"+status;}
                });
    }
</script>

    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog text-right" role="document">
            <div class="modal-content" dir="rtl">
                <div class="modal-header align-self-center">
                    <h3 align="center" class="modal-title text-primary-purple"><b>البحث </b></h3>
                </div>
                <form method="GET" action="/SubscriberCustomerNotification">
                    @csrf
                    <div class="modal-body text-right font-weight-bold" >
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">
                                رقم العضوية
                            </label>
                            <input type="text" name="membership_no" class="form-control text-right"><br>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1" class="text-primary-purple">الحاله</label>
                            <select class="form-select" name="status" dir="rtl">
                                <option value="">-</option>
                                <option value="under reviewing">قيد المراجعه</option>
                                <option value="accepted and Sent">مقبول</option>
                                <option value="rejected">مرفوض</option>
                            </select><br>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between" align="center">
                        <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card" dir="rtl">

        <div class="card-header" >
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">المشتركين</a>
                        <span class="breadcrumb-item active" aria-current="page">/   إشعارات الزبائن </span>
                    </li>

                    <div class="float-left">
                        <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat">
                            <i class="mdi mdi-magnify"></i>
                        </label>
                    </div>
                </ol>

            </div>
        </div>

        <div class="card-body">
            @if(count($notifications) > 0)
            @php $i=1; @endphp
            <div class="table-responsive">
                <table class="table text-center" >
                <thead>
                    <th class="font-weight-bold">#</th>
                    <th class="font-weight-bold">رقم العضوية</th>
                    <th class="font-weight-bold"> العنوان</th>
                    <th class="font-weight-bold">المحتوى</th>
                    <th class="font-weight-bold">الحاله</th>
                    <th class="font-weight-bold">العمليات</th>
                </thead>

                <tbody>
                @foreach ($notifications as $index => $record)
                    <tr>
                        <td>{{ ($notifications->currentPage() - 1) * $notifications->perPage() + $index + 1 }}</td>
                        <td>{{ $record['membership_no'] }}</td>

                        <td>{{ $record['title'] }}</td>

                        <td>{{ $record['body'] }}</td>
                        <td>
                            @if( $record['status'] == 'accepted and Sent')
                            <a href="javascript:;" class="badge badge-success text-white"  style="cursor:hand;text-decoration:none">
                                مقبول
                            </a>
                            @elseif( $record['status'] == 'rejected')
                            <a href="javascript:;" class="badge badge-danger text-white" style="cursor:hand;text-decoration:none">
                                مرفوض
                            </a>
                            @elseif( $record['status'] == 'under reviewing')
                            <a href="javascript:;" class="badge badge-warning text-white"  style="cursor:hand;text-decoration:none">
                                قيد المراجعه
                            </a>
                            @endif
                        </td>
                        <td>
                            @if( $record['status'] == 'under reviewing')
                            <div class="input-group text-center" style="text-align: center;" align="center">
                                <div class="input-group-prepend">
                                    <button class="badge badge-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal  text-white"></i>
                                    </button>
                                    <div class="dropdown-menu" style="text-align: right;">
                                        <a class="dropdown-item text-right" onclick="processNotification({{ $record['id'] }},'accept','هل أنت متأكد من قبول الاشعار')"  href="javascript:;" style="text-decoration: none">
                                            قبول 
                                        </a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item text-right" onclick="processNotification({{ $record['id'] }},'reject','هل أنت متأكد من رفض الاشعار')"  href="javascript:;" style="text-decoration: none">
                                            رفض
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
                </table>
            </div><br><br><br>

            
            <div class="d-flex justify-content-center">
                {{ $notifications->links('pagination::bootstrap-4') }}
            </div>

            @else
            <div class="alert alert-fill-primary text-right" role="alert" >
                <i class="typcn typcn-warning"></i>لا توجد بيانات</div>
            @endif
        </div>

    </div>

@endsection
