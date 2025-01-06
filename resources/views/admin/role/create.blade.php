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

                        <form id="roleForm" method="post" action="@if(isset($editStatus)){{ route('role.update', $role->id) }} @else {{ route('role.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="roleName">Role Name</label>
                                        <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Enter role" value="{{old('roleName',  isset($role->name) ? $role->name : NULL)}}">
                                    </div>
                                </div> 
                            </div>

 
                            
                            <div class="row">
                                
                                <div class="col-12 mt-5">
                                @foreach($permissionHead as $group)
                                    <div class="">
                                        <li class="mt-2"><label  for="permission"><strong class="h5 text-dark">{{ $group->name ?? '' }}</strong></label></li>
                            
                                        @if($group->permissionByGroup->isNotEmpty())
                                            @foreach($group->permissionByGroup as $value)
                                            @if(isset($group->permissionByGroup))
                                                <div class="pl-4">
                                                    <input type="checkbox" class="checkBoxClass" name="permissions[]" 
                                                           value="{{ $value->id }}" 
                                                           id="permission_{{ $value->id }}"
                                                           @if(in_array($value->id, $rolePermissions)) checked @endif>  
                                                    {{ $value->name ?? 'NA' }}
                                                </div>
                                               
                                                @endif
                                               
                                            @endforeach
                                            @else
                                            <p class="pl-4">no permission</p>
                                           
                                      @endif
                                    </div>
                                @endforeach
                                </div>
                         
                           
                                </div>
                        
                        
                            @if(isset($role->id))
                            <input type="hidden" name="id" value="{{ $role->id }}">
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
<script src="{{ asset('assets/admin/js/console/role.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    });
</script>
@append

<script type="text/javascript">

 $(document).ready(function(){

    $("#roleForm").submit(function(){

        if($("#roleName").val()=="")
        {
            $("#err").text("Please enter role name");
            $("#roleName").focus();
            return false;
        }
        });
    });
 
 </script>

@endsection