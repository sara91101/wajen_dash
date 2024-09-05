@extends('welcome')

@section('content')
@php
      $i = ($page * $perPage) - $perPage + 1;

@endphp

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item">
                            <a href="#">  نظام الولاء </a>
                            <span class="breadcrumb-item active" aria-current="page"> /  الإستفسارات </span>
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
                <th class="font-weight-bold">رقم الهاتف</th>
                <th class="font-weight-bold"> الإستفسار</th>
                <th class="font-weight-bold">حذف</th>
            </thead>

            <tbody>
            @foreach ($results as $question)
                <tr>
                    <td >{!! $i !!}</td>
                    <td>{{ $question->phone }}</td>
                    <td>{{ $question->message }}</td>

                    <td>
                        <a onclick="destroyItem( 'destroyLoyaltyContacts', {{ $question->id }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
