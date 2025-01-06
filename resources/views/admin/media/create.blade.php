@extends('layout.admin')
@section('content')

<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->
            <div class="col-12 mt-5 start-form-sec">
                <div class="card">
                    <div class="card-body">
                        <p id="err" style="color:red;"></p>
                        <form id="mediaForm" method="post" action="@if(isset($editStatus)){{ route('media.update', $media->id) }} @else {{ route('media.store')}}@endif" enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            @if(isset($editStatus))
                            @method('PUT')
                            @endif
                            @if(session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                            @endif
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                            <div class="row">

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="categoryId">Media Category</label>
                                        <select class="form-control selectpicker" id="categoryId" name="categoryId"
                                            data-live-search="true">
                                            <option value="">Select Category</option>
                                            @if (isset($mediaCategory))
                                                @foreach ($mediaCategory as $value)
                                                    <option value="{{ $value->id }}"
                                                        @if (old('categoryId', isset($media->category_id) ? $media->category_id : null) == $value->id) selected="selected" @endif>
                                                        {{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                               
                               

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                @if(isset($media->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/media/{{ $media->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                              

                              

                              

                                   
                            
                            </div>
                            @if(isset($media->id))
                            <input type="hidden" name="id" value="{{ $media->id }}">
                            @endif
                           
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- basic form end -->
        </div>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/media.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){

$("#mediaForm").submit(function(){

    if($("#categoryId").val()=="")
    {
        $("#err").text("Please select category");
        $("#categoryId").focus();
        return false;
    }
    });
});

</script>
@append

@endsection
