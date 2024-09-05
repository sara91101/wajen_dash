@extends("welcome")

@section("content")
<script>
    let counter = {{ $counter }};
    function increaseSecond()
    {
        counter++;
        var myDiv = document.getElementById("second");
        var newDiv = document.createElement('blockquote');
        newDiv.classList.add('blockquote');
        newDiv.innerHTML +='<div class="form-group" id="second'+counter+'">'+
        '<label class="text-primary-purple form-label">البنود الفرعية ('+counter+')</label>'+
        '<div class="row"><div class="col-11">'+
        '<textarea name="second[]" class="form-control text-right" placeholder="البنود الفرعية"></textarea>'+
        '</div>'+
        '<label class="col-1">'+
        '<button onclick="deleteRow(this)" type="button" class="btn btn-danger btn-rounded btn-icon">'+
        '<i class="mdi mdi-delete"></i></button></label><br><br>'+
        '<div class="container form-group"><label class="container text-primary-purple form-label col-lg-12">'+
        'تفاصيل البنود الفرعية</label>'+
        '<div class="container row col-lg-12"><div class="col-11">'+
        '<textarea name="third'+counter+'[]" class="form-control text-right" placeholder="تفاصيل البنود الفرعية"></textarea>'+
        '</div><div class="col-1">'+
        '<label onclick="increaseThird('+counter+')" class="badge badge-primary"><i class="mdi mdi-plus-circle"></i></label>'+
        '<br><br></div></div><div id="third'+counter+'"></div></div></div></blockquote>';
        myDiv.appendChild(newDiv);
    }
    function increaseThird(secondCounter)
    {
        var myDiv = document.getElementById("third"+secondCounter);
        var newDiv = document.createElement('div');
        newDiv.classList.add('container');
        newDiv.classList.add('row');
        newDiv.classList.add('col-lg-12');
        newDiv.innerHTML +='<div class="col-11">'+
        '<input type="text" name="third'+secondCounter+'[]" class="form-control text-right" placeholder="تفاصيل البنود الفرعية">'+
        '</div>'+
        '<label class="col-1">'+
        '<button onclick="deleteThird(this)" type="button" class="btn btn-danger btn-rounded btn-icon">'+
        '<i class="mdi mdi-delete"></i></button></label>'
        +'<br><br></div>';
        myDiv.appendChild(newDiv);
    }
    function deleteRow(row)
    {
        counter--;
        row.parentNode.parentNode.parentNode.parentNode.remove();
    }
    function deleteThird(row)
    {
        row.parentNode.parentNode.remove();
    }
</script>
<div class="row" dir="rtl">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" dir="rtl">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-inverse-primary justify-content-between">
                        <li class="breadcrumb-item"><a href="#">
                            سياسة الخصوصية</a>
                            <span class="breadcrumb-item active" aria-current="page"> /  تعديل </span>
                        </li>
                    </ol>
                </div>
            </div>
                <form method="POST" action="/updatePrivacy/{{ $privacy->id }}">
                    @csrf
                    <div class="card-body">
                        <div class="text-right font-weight-bold row" dir="rtl">
                            <div class="form-group col-lg-12">
                                <label class="text-primary-purple form-label">
                                    <i class="mdi mdi-star text-danger"></i>
                                    البند الأساسي
                                </label>
                                <textarea name="first" class="form-control text-right" required>{{ $privacy->ar_first }}</textarea>
                            </div>
                            @php $i=1; @endphp
                            @foreach ($privacy["second"] as $second)
                            <blockquote class="blockquote">
                                <div class="form-group">
                                    <label class="text-primary-purple form-label col-lg-12">
                                        البنود الفرعية ({{ $i }})
                                    </label>
                                    <div class="row col-lg-12">
                                        <div class="col-10">
                                            <textarea  name="second[]" class="form-control text-right" placeholder="البنود الفرعية">{{ $second->ar_second }}</textarea>
                                        </div>
                                        @if($loop->first)
                                        <div class="col-1">
                                            <label onclick="increaseSecond()" class="badge badge-success"><i class="mdi mdi-plus"></i></label>
                                        </div>
                                        @endif
                                        <div class="col-1">
                                            <label onclick="deleteRow(this)" class="badge badge-danger"><i class="mdi mdi-delete"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="container form-group">
                                    <label class="container text-primary-purple form-label col-lg-12">
                                        تفاصيل البنود الفرعية
                                    </label>
                                    @foreach ($second["third"]  as $third)
                                    <div class="container row col-lg-12">
                                        <div class="col-10">
                                            <textarea name="third{{ $i }}[]" class="form-control text-right" placeholder="تفاصيل البنود الفرعية">{{ $third->ar_third }}</textarea>
                                        </div>
                                        @if($loop->first)
                                        <div class="col-1">
                                            <label onclick="increaseThird({{ $i }})" class="badge badge-primary"><i class="mdi mdi-plus-circle"></i></label>
                                            <br><br>
                                        </div>
                                        @endif
                                        <div class="col-1">
                                            <label onclick="deleteThird(this)" class="badge badge-danger badge-rounded"><i class="mdi mdi-delete"></i></label>
                                            <br><br>
                                        </div>
                                    </div>
                                    @endforeach
                                        <div id="third1"></div>
                                    {{--  </div>  --}}
                                </div>
                            </blockquote>
                            @php $i++; @endphp
                            @endforeach

                            <div id="second"></div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center" align="center">
                        <input type="submit" value="تعديل" class="btn  my-btn btn-lg btn-primary">
                    </div>
                </form>
        </div>
    </div>
</div>

@endsection
