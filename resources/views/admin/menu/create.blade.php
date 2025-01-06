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

                        <form id="blogForm" method="post" action="@if(isset($editStatus)){{ route('menu.update', $blog->id) }} @else {{ route('menu.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name',  isset($menu->name) ? $menu->name : NULL)}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="page">Page</label>
                                        <input type="text" class="form-control" id="page" name="page" placeholder="Enter page name" value="{{old('page',  isset($menu->page) ? $menu->page : NULL)}}">
                                    </div>
                                </div>

                               

                            </div>

                            

                            

                            @if(isset($menu->id))
                            <input type="hidden" name="id" value="{{ $menu->id }}">
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

@append

@endsection