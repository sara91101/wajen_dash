@extends('welcome')

@section('content')
@php
      $i = ($page * $perPage) - $perPage + 1;

@endphp
<script>
    function linkMinors(sel)
    {
        var major = sel.value;
        var minors = document.getElementById("minors");
        for (var i = 0; i < minors.options.length; i++)
        {
            if(minors.options[i].className != parseInt(major))
            {
                minors.options[i].style.display = "none";
                minors.options[i].selected = false;
            }
            else
            {
                minors.options[i].style.display = "block";
            }
        }
    }
    </script>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">
                            الأسئلة والإستفسارات</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>
                        </li>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($questions))
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <!--th class="font-weight-bold">IP Address</th-->
                <th class="font-weight-bold"> الإسم</th>
                <th class="font-weight-bold">رقم الهاتف</th>
                <th class="font-weight-bold">البريد الإلكتروني</th>
                <th class="font-weight-bold"> المدينة</th>
                <th class="font-weight-bold"> إسم النشاط</th>
                <th class="font-weight-bold"> نوع النشاط</th>
                <th class="font-weight-bold"> الرد</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($results as $question)
                <tr>
                    <td >{!! $i !!}</td>
                    <!--td>{{ $question->ip_address }}</td--> 
                    <td>{{ $question->name }}</td>
                    <td>{{ $question->phone }}</td>
                    <td>{{ $question->email }}</td>
                    <td>{{ $question->ar_name }}</td>
                    <td>{{ $question->activity_name }}</td>
                    <td>{{ $question->activity_type }}</td>
                    <td>
                        @if($question->answers > 0)
                        <i class="mdi mdi-check-circle text-success"></i>
                        @else
                        <i class="mdi mdi-close-circle text-warning"></i>
                        @endif
                    </td>

                    <td>
                        <a href="/detailQuestion/{{ $question->id }}" class="btn btn-info btn-sm btn-icon-text me-3">
                            <i class="mdi mdi-information btn-icon-append"></i>
                                
                        </a>
                        &nbsp;&nbsp;
                        {{--  <a href="/answerQuestion/{{ $question->id }}" class="btn btn-success btn-sm btn-icon-text me-3">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                رد / إجابة
                        </a>
                        &nbsp;&nbsp;  --}}
                        <a onclick="destroyItem( 'destroyQuestion', {{ $question->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                
                        </a>
                    </td>

                </tr>
                @php $i++; @endphp
            @endforeach
            </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-fill-primary text-right" role="alert" dir="rtl">
            <i class="typcn typcn-warning"></i>
            لا توجد بيانات
        </div>
        @endif
    </div>
    <div class="card-footer">
        <div  dir="rtl" align="center" class="pagination flat rounded rounded-flat" style="display: flex;justify-content: center;">
            {{ $results->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
