@extends('welcome')

@section('content')
@php
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if ($page <= 0) $page = 1;

  $per_page = 15;

  $i = ($page * $per_page) - $per_page + 1;

@endphp

<script>
    function editKey(Key_id)
    {
        document.getElementById("Key_id").value = Key_id;
        document.getElementById("Key_ar").value = document.getElementById("KeyAr"+Key_id).innerHTML;
        document.getElementById("Key_en").value = document.getElementById("KeyEn"+Key_id).innerHTML;
        $("#edit").modal("show");
    }
</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>Create Key</b></h3>
        </div>
        <form method="POST" action="/newKey">
            @csrf
            <div class="modal-body text-right font-weight-bold" >
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        Key Name
                    </label>
                    <input type="text" name="key_name" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">Key Value</label>
                    <input type="text" name="key_value" class="form-control text-right">
                </div>

            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="Save" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header align-self-center">
            <h3 align="center" class="modal-title text-primary-purple"><b>Update Key</b></h3>
        </div>
        <form method="POST" action="/updateKey">
            @csrf
            <input type="hidden" name="key_id" id="Key_id">

            <div class="modal-body text-right font-weight-bold" >
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">
                        <i class="mdi mdi-star text-danger"></i>
                        Key Name
                    </label>
                    <input type="text" id="Key_ar" name="key_name" class="form-control text-right" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1" class="text-primary-purple">Key Value</label>
                    <input type="text" id="Key_en" name="key_value" class="form-control text-right">
                </div>
            </div>
            <div class="modal-footer justify-content-center" align="center">
                <input type="submit" value="Edit" class="btn  my-btn btn-lg btn-primary">
            </div>
        </form>
      </div>
    </div>
</div>

<div class="card">

    <div class="card-header" >

                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                      <li class="breadcrumb-item"><a href="#">Keys</a>
                        {{--  <span class="breadcrumb-item active" aria-current="page"> /  عرض </span>  --}}
                       </li>

                      <label class="badge badge-primary text-white" data-bs-toggle="modal" data-bs-target="#add" data-whatever="@fat">
                        <i class="mdi mdi-plus"></i>
                      </label>
                    </ol>

                </div>
    </div>

    <div class="card-body">
        @if(count($keys) > 0)
        <div class="table-responsive">
            <table class="table text-center" >
            <thead>
                <th class="font-weight-bold">#</th>
                <th class="font-weight-bold">Key Name</th>
                <th class="font-weight-bold">Key Value</th>
                <th class="font-weight-bold">Edit</th>
                <th class="font-weight-bold">Delete</th>
            </thead>

            <tbody>
            @foreach ($keys as $a)
                <tr>
                    <td >{!! $i !!}</td>
                    <td id="KeyAr{{ $a['id'] }}">{{ $a['key_name'] }}</td>
                    <td id="KeyEn{{ $a['id'] }}">{{ $a['key_value'] }}</td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm btn-icon-text me-3" onclick="editKey({{ $a['id'] }})">
                            <i class="typcn typcn-edit btn-icon-append"></i>
                        </a>
                    </td>
                    <td>
                        <a onclick="destroyItem( 'destroyKey', {{ $a['id'] }})"  href="#" class="btn btn-danger btn-sm btn-icon-text">
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
        <div class="alert alert-fill-primary text-right" role="alert" >
            <i class="typcn typcn-warning"></i>No Keys</div>
        @endif
    </div>

</div>

@endsection
