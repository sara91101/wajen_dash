@extends("welcome")

@section("content")
<div class="container content">
    <div class="container-fluid">
      <div class="card">

        <div class="card-header" dir="rtl">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb bg-inverse-primary justify-content-between">
                    <li class="breadcrumb-item"><a href="#">      الأسئلة والإستفسارات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /  رد  </span>
                    </li>
                </ol>
            </div>
        </div>
          <table class="table text-center">
              <form method="POST" name="myform" action="/reply">
                @csrf
                <input type="hidden" name="question_id" value="{{ $person['id'] }}">
              <tr>
                  <td >{{ $person['name'] }}</td>
                  <td class="font-weight-bold">إلى</td>
              </tr>
              <tr>
                  <td><input class="form-control text-right" type="email" name="email" value="{{ $person['email'] }}" required></td>
                  <td class="font-weight-bold">البريد الإلكتروني</td>
              </tr>
              <tr>
                  <td><input dir="rtl" class="form-control text-right" type="text" name="title" required></td>
                  <td class="font-weight-bold"> العنوان</td>
              </tr>
              <tr>
                  <td>
                    {{--  <div id="quillExample1" class="quill-container">
                    </div>  --}}
                    <textarea dir="rtl" rows="15" name="body" class="form-control quill-container text-right" id="quillExample1"></textarea>
                 </td>
                 <td class="font-weight-bold">الرسالة</td>
              </tr>
              {{--  <tr>
                <td>
                    <input type="file" name="attachments[]" class="form-control">
               </td>
               <td class="font-weight-bold">المرفقات</td>
            </tr>  --}}

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
