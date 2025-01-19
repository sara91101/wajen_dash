@extends("welcome")

@section("content")
<div class="container content">
    <div class="container-fluid">
      <div class="card">

        <div class="card-header" dir="rtl">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">     المشتركين</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  البريد الإلكتروني  </span>
                    </li>
                </ol>
            </div>
        </div>
          <table class="table text-center">
              <form method="POST" name="myform" action="/sendInvoice" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer['id'] }}">
              <tr>
                  <td >{{ $customer['first_name'] }} {{ $customer['last_name'] }}</td>
                  <td class="font-weight-bold">إلى</td>
              </tr>
              <tr>
                  <td><input class="form-control text-right" type="email" name="email" value="{{ $customer['email'] }}" required></td>
                  <td class="font-weight-bold">البريد الإلكتروني</td>
              </tr>
              <tr>
                  <td><input dir="rtl" class="form-control text-right" type="text" name="title" required></td>
                  <td class="font-weight-bold"> عنوان الرسالة</td>
              </tr>
              <tr>
                  <td>
                    {{--  <div id="quillExample1" class="quill-container">
                    </div>  --}}
                    <textarea dir="rtl" rows="15" name="body" class="form-control quill-container text-right" id="quillExample1"></textarea>
                 </td>
                 <td class="font-weight-bold">الرسالة</td>
              </tr>
              <tr>
                <td>
                    <input type="file" name="attachment" class="form-control">
               </td>
               <td class="font-weight-bold">المرفق</td>
            </tr>

              <tr><td colspan="2">
                  <div align="center">
                    <input type="submit" value="إرسال" class="btn  my-btn btn-lg btn-primary">
                    </div>
                    </td>
              </tr>
              </form>

          </table>

              </div>

      </div>
    </div>





@endsection
