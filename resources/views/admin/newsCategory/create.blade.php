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
                        <form id="newsCategoryForm" method="post" action="@if(isset($editStatus)){{ route('news-category.update', $newsCategory->id) }} @else {{ route('news-category.store')}}@endif" enctype='multipart/form-data'>
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
                                        <label for="parentId">Parent ID</label>
                                        <select class="form-control selectpicker" id="parentId" name="parentId" data-live-search="true">
                                            <option value="">Select Parent ID</option>
                                            
                                            @if (isset($newsParentCategory))
                                                @php
                                                    $categoriesByType = $newsParentCategory->groupBy('parent_id');
                                                @endphp
                                                
                                                @foreach ($categoriesByType as $parentId  => $categories)
                                                @php
                                                $parentName = $newsParentCategory->firstWhere('id', $parentId)->name ?? '';
                                            @endphp
                                                    <optgroup class="text-dark" label="{{ $parentName }}">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @if (old('parentId', isset($newsCategory->parent_id) ? $newsCategory->parent_id : null) == $category->id) selected="selected" @endif>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            @endif
                                        </select>
                                        
                                    </div>
                                </div>
                               
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="title">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter news category" value="{{old('name',  isset($newsCategory->name) ? $newsCategory->name : NULL)}}">
                                    </div>
                                </div>

                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div> --}}

                                {{-- @if(isset($blog->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/blogImage/{{ $blog->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif --}}

                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="publishedBy">Published By</label>
                                        <input type="text" class="form-control" id="publishedBy" name="publishedBy" placeholder="Enter publisher name" value="{{old('publishedBy',  isset($blog->published_by) ? $blog->published_by : NULL)}}">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-6 mt-5">
                                    <label for="publishedDate">Published On</label>
                                    <div class="input-group">
                                        <input type="text" name="publishedDate" placeholder="Enter publish date" id="publishedDate" class="form-control" value="{{old('publishedDate',  isset($blog->published_on) ? $blog->published_on : NULL)}}">
                                    </div>
                                </div> --}}

                              

                                    <div class="col-12 mt-10">
    
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($newsCategory->description) ? $newsCategory->description : NULL)}}</textarea>
                                        </div>
    
                                    </div>
                            
                            </div>
                            @if(isset($newsCategory->id))
                            <input type="hidden" name="id" value="{{ $newsCategory->id }}">
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
<script src="{{ asset('assets/admin/js/console/newsCategory.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    });
</script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){

$("#newsCategoryForm").submit(function(){

    if($("#name").val()=="")
    {
        $("#err").text("Please enter news category name ");
        $("#name").focus();
        return false;
    }
    });
});

</script>
@append

@endsection
