@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editUser(User_id)
    {
        document.getElementById("User_id").value = User_id;
        document.getElementById("name").value = document.getElementById("name"+User_id).innerHTML;
        document.getElementById("email").value = document.getElementById("email"+User_id).innerHTML;
        document.getElementById("password").value = document.getElementById("password"+User_id).innerHTML;

        var level = document.getElementById("level"+User_id).innerHTML;
        var levels = document.getElementById("levels");
        for (var i = 0; i < levels.options.length; i++)
        {
            if(levels.options[i].value == parseInt(level))
            {
                levels.options[i].selected = true;
                levels.selectedIndex = i;
            }
        }
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>البحث عن مستخدم</b></h3>
        </div>
        <form method="POST" action="/users">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                         بيانات المستخدم
                    </label>
                    <input type="text" name="user" class="form-control text-right" >
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                         الصلاحية
                    </label>
                    <select name="level" class="form-select text-right">
                        <option value=0>-</option>
                        @foreach ($levels as $level)
                            <option value={{ $level->id }}>{{ $level->level }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-between" align="center">
                <input type="submit" value="بحث" class="btn  my-btn btn-lg btn-primary">
                <a href="/allUsers" class="btn  my-btn btn-lg btn-primary">إلغاء البحث</a>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>إضافة مستخدم</b></h3>
        </div>
        <form method="POST" action="/newUser">
            @csrf
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         الإسم
                    </label>
                    <input type="text" name="name" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        كلمة المرور</label>
                    <input type="password" name="password" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         الصلاحية
                    </label>
                    <select name="level_id" class="form-select text-right">
                        @foreach ($levels as $level)
                            <option value={{ $level->id }}>{{ $level->level }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="حفظ" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>تعديل بيانات المستخدم</b></h3>
        </div>
        <form method="POST" action="/updateUser">
            @csrf
            <input type="hidden" name="User_id" id="User_id">
            <div class="modal-body text-right font-weight-bold" dir="rtl">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         الإسم
                    </label>
                    <input type="text" id="name" name="name" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                         الصلاحية
                    </label>
                    <select name="level_id" id="levels" class="form-select text-right">
                        @foreach ($levels as $level)
                            <option value={{ $level->id }}>{{ $level->level }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="تعديل" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" dir="rtl">

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                      <li class="breadcrumb-item"><a href="#">   الإعدادات</a>
                        <span class="breadcrumb-item active" aria-current="page"> /   المسخدمين </span>
                       </li>

                       <label class="badge badge-primary text-white">
                        <div class="dropdown dropstart">
                            <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical  text-white"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search" data-whatever="@fat" href="#">بحث</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">إضافة</a></li>
                            </ul>
                        </div>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($users) > 0)
        <div class="table-responsive">
            <table class="table text-center" dir="rtl">
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold"> الإسم</th>
                <th class="font-weight-bold">البريد الإلكتروني</th>
                <th class="font-weight-bold">الصلاحية</th>
                <th class="font-weight-bold">العمليات</th>
            </thead>

            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="name{{ $user->id }}">{{ $user->name }}</td>
                    <td id="email{{ $user->id }}">{{ $user->email }}</td>
                    <td>{{ $user->level }}</td>
                    <label  style="display:none;" id="password{{ $user->id }}">{{ $user->pass }}</label>
                    <label  style="display:none;" id="level{{ $user->id }}">{{ $user->level_id }}</label>
                    <td>
                        <a href="javascript:;" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editUser({{ $user->id }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                                تعديل
                        </a>
                        &nbsp;&nbsp;
                        <a onclick="destroyItem( 'destroyUser', {{ $user->id }})"  href="javascript:;" class="btn btn-danger btn-sm btn-icon-text">
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                حذف
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
            {{ $users->links("pagination::bootstrap-5") }}
        </div>
    </div>

</div>

@endsection
