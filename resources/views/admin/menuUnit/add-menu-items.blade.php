@extends('layout.admin')
@section('content')

    <div class="row">


        <div class="col-lg-12 col-ml-12">
            <div class="row">
                <!-- basic form start -->

                <div class="col-12 mt-5 start-form-sec">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="grid-col control-bar">
            
                                        <div class="row control">
                                          
            
                                            <div class="col-12 right-control">
            
                                                <a href="javascript:void(0);" onclick="window.history.back();">
                                                    <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                                </a>
        
            
                                            </div>
            
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                      
                           
                            <!-- <h4 class="header-title">Basic form</h4> -->
                            <p id="err" style="color:red;"></p>

                            <form id="menuItemForm" method="post"
                                action="@if (isset($editStatus)) {{ route('menu-unit.updateMenuItems', $menuItem->id) }} @else {{ route('menu-unit.storeMenuItems') }} @endif"
                                enctype='multipart/form-data'>

                                {{ csrf_field() }}

                                @if (isset($editStatus))
                                    @method('PUT')
                                @endif


                                @if (session()->has('message'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif


                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                                <div class="row">

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="parentId">ParentId</label>
                                            <select class="form-control selectpicker" id="parentId" name="parentId" data-live-search="true">
                                                <option value="">Select Menu Item</option>
                                                @if (isset($parentMenuItem))
                                                    @foreach ($parentMenuItem as $parentId)
                                                        <option value="{{ $parentId->id }}" 
                                                            {{ old('parentId', $menuItem->parent_id ?? null) == $parentId->id ? 'selected' : '' }}>
                                                            {{ $parentId->title }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    
                                    


                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="name">Title</label>
                                            <input type="text" class="form-control" id="name" name="title"
                                                placeholder="Enter title"
                                                value="{{ old('name', isset($menuItem->title) ? $menuItem->title : null) }}">
                                        </div>
                                    </div>

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="url">URL</label>
                                            <input type="text" class="form-control" id="url" name="url"
                                                placeholder="Enter url"
                                                value="{{ old('url', isset($menuItem->url) ? $menuItem->url : null) }}">
                                        </div>
                                    </div>


                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="target">Target</label>
                                            <select class="form-control selectpicker" id="target" name="target" data-live-search="true">
                                               
                                                <option value="_self">Self</option>
                                                <option value="_blank">Blank</option>
                                                <option value="_top">Top</option>       
                                                   
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="sortOrder">SortOrder</label>
                                            <input type="text" class="form-control" id="sortOrder" name="sortOrder"
                                                placeholder="Enter sortOrder"
                                                value="{{ old('sortOrder', isset($menuItem->sortOrder) ? $menuItem->sortOrder : null) }}">
                                        </div>
                                    </div>

                                 {{-- @if(isset($menuId)) --}}
                                    {{-- <input type="hidden" id="menuId" name="menuId" value="{{ $menuId }}" > --}}
                                    {{-- @endif --}}

                                    {{-- <input type="hidden" name="menuId" value="{{ $menuId ?? '' }}"> --}}

                                </div>


                              


                                <div class="row">
                                    <div class="col-12 mt-10">
                                  
                                  
                                        @if(isset($menuItem->id))
                                        <input type="hidden" name="id" value="{{ $menuItem->id }}">
                                        @endif
                                        @if($menuId)
                                        <input type="hidden" name="menuId" value="{{ $menuItem->menu_id }}">
                                    @endif
                                    
                                   
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button> 
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- basic form end -->
            </div>
        </div>
    </div>

@section('js')
    <script src="{{ asset('assets/admin/js/console/news.js') }}"></script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
        });
    </script> --}}

    {{-- <script>
        CKEDITOR_BASEPATH = "{{ asset('/ckeditor/') }}/";
        CKEDITOR.replace('description');
    </script> --}}
@append


<script type="text/javascript">
//CKEDITOR.replace('description');
   

    $(document).ready(function() {

        $("#newsForm").submit(function() {

            if ($("#categoryId").val() == "") {
                $("#err").text("Please select news category");
                $("#categoryId").focus();
                return false;
            }
            if ($("#name").val() == "") {
                $("#err").text("Please enter news name");
                $("#name").focus();
                return false;
            }
         
         
        });

    
});


</script>

@endsection
