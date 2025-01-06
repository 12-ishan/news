@extends('layout.admin')
@section('content')

<div class="row">


    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->

            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">

                        <!-- <h4 class="header-title">Basic form</h4> -->
                        <p id="err" style="color:red;"></p>

                        <form id="userfrm" method="post"
                            action="@if(isset($editStatus)){{ route('user.update', $user->id) }} @else {{ route('user.store')}}@endif"
                            enctype='multipart/form-data'>

                            {{ csrf_field() }}

                            @if(isset($editStatus))
                            @method('PUT')
                            @endif


                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif


                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach

                            <div class="row">

           

                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Enter username"
                                            value="{{old('username',  isset($user->username) ? $user->username : NULL)}}"  <?php if(isset($editStatus)){echo "readonly";} ?>>
                                    </div>
                                </div> --}}

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter name"
                                            value="{{old('name',  isset($user->name) ? $user->name : NULL)}}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Enter Email"
                                            value="{{old('email',  isset($user->email) ? $user->email : NULL)}}"  <?php if(isset($editStatus)){echo "readonly";} ?>>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                            placeholder="Enter Password" value="">
                                    </div>
                                </div>

                                {{-- @if(isset(Auth::user()->roleId))
                                @if(Auth::user()->roleId == 1)

                                 <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="parentId">Parent</label>
                                        <select class="form-control selectpicker" id="parentId" name="parentId"
                                            data-live-search="true">
                                            <option value="">Select Parent</option>
                                            @if(isset($parentUser))
                                            @foreach($parentUser as $value)
                                            <option value="{{$value->id}}" @if (old('parentId', isset($user->parentId) ?
                                                $user->parentId : NULL) == $value->id) selected="selected"
                                                @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                @endif
                                @endif --}}

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select  class="form-control selectpicker" id="role" name="role"
                                            data-live-search="true">
                                            <option value="">Select Role</option>
                                    {{print_r($role)}}
                                            @if(isset($role))
                                            @foreach($role as $value)
                                            <option value="{{$value->id}}" @if (old('role', in_array($value->id, $hasRole ?? ""))) 
                                                selected="selected" 
                                            @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                              
                              

                              
                                <div class="col-6 mt-6">
                                    <div class="form-group">
                                        <label for="name">Thumbnail</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>                                
                                @if(isset($user->image->name))
                                <div class="col-6 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60"
                                            src=" {{ URL::to('/') }}/uploads/user/{{ $user->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>
                            {{-- <div class="row">
                                
                            </div> --}}

                            {{-- <div class="row">
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="meetingUsername">Meeting User ID</label>
                                        <input type="text" class="form-control" id="meetingUsername" name="meetingUsername"
                                            placeholder="Enter meeting user Id"
                                            value="{{old('meetingUsername',  isset($user->meetingUsername) ? $user->meetingUsername : NULL)}}" >
                                    </div>
                                </div>
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="meetingPassword">meeting User Password</label>
                                        <input type="text" class="form-control" id="name" name="meetingPassword"
                                            placeholder="Enter meeting user password"
                                            value="{{old('meetingPassword',  isset($user->meetingPassword) ? $user->meetingPassword : NULL)}}">
                                    </div>
                                </div>
                            </div> --}}

                            @if(isset($user->id))
                            <input type="hidden" name="id" value="{{ $user->id }}">
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
<script src="{{ asset('assets/admin/js/console/user.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    });
</script>
@append

<script type="text/javascript">
$(document).ready(function() {

    $("#userfrm").submit(function() {

      
        if ($("#name").val() == "") {
            $("#err").text("Please enter your name");
            $("#name").focus();
            return false;
        }

        if ($("#email").val() == "") {
            $("#err").text("Please enter your email");
            $("#email").focus();
            return false;
        }
        <?php if(!isset($editStatus)){?>

        if ($("#password").val() == "") {
            $("#err").text("Please enter password");
            $("#password").focus();
            return false;
        }
        <?php } ?>

        if ($("#roleId").val() == "") {
            $("#err").text("Please enter role");
            $("#roleId").focus();
            return false;
        }
    });
});
</script>

@endsection