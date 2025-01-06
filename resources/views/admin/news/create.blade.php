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

                            <form id="newsForm" method="post"
                                action="@if (isset($editStatus)) {{ route('news.update', $news->id) }} @else {{ route('news.store') }} @endif"
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
                                            <label for="categoryId">News Category</label>
                                            <select class="form-control selectpicker" id="categoryId" name="categoryId"
                                                data-live-search="true">
                                                <option value="">Select News Category</option>

                                                @if (isset($newsCategory))
                                                    @php
                                                        $categoriesByType = $newsCategory->groupBy('parent_id');
                                                    @endphp

                                                    @foreach ($categoriesByType as $parentId => $categories)
                                                        @php
                                                            $parentName =
                                                                $newsCategory->firstWhere('id', $parentId)->name ?? '';
                                                        @endphp
                                                        <optgroup class="text-dark" label="{{ $parentName }}">
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    @if (old('categoryId', isset($news->category_id) ? $news->category_id : null) == $category->id) selected="selected" @endif>
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
                                            <label for="name">Title</label>
                                            <input type="text" class="form-control" id="name" name="title"
                                                placeholder="Enter news title"
                                                value="{{ old('name', isset($news->title) ? $news->title : null) }}">
                                        </div>
                                    </div>

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="metaDescription">Meta Description</label>
                                            <input type="text" class="form-control" id="metaDescription"
                                                name="metaDescription" placeholder="Enter news metaTitle"
                                                value="{{ old('metaDescription', isset($news->meta_description) ? $news->meta_description : null) }}">
                                        </div>
                                    </div>


                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="image">Thumbnail</label>
                                            <input type="file" id="image" name="image" class="form-control"
                                                value="{{ old('image', isset($news->image->id) ? $news->image->id : null) }}">
                                        </div>
                                    </div>


                                    @if (isset($news->image->name) && $news->image->category_id == '')
                                        <div class="col-12 mt-6">
                                            <div class="upload-image">
                                                <img width="100" height="60"
                                                    src="{{ URL::to('/') }}/uploads/newsImage/{{ $news->image->name }}"
                                                    alt="image">
                                            </div>
                                        </div>
                                        @endif
                                   
                                    @if (isset($news->image) && !empty($news->image->name))
                                    <div class="col-12 mt-6">
                                        <div class="upload-image">
                                            <img width="100" height="60" src="{{ URL::to('/') }}/uploads/media/{{ $news->image->name }}" alt="Selected Image">
                                        </div>
                                    </div>
                                @endif
                                
                                  
                                    {{-- @if (isset($news->image->category_id))
                                    <div class="col-12 mt-6">
                                        <div class="upload-browse-image">
                                            @if(isset($news->image->name))
                                                <img width="100" height="60" src="{{ $news->image->name }}" alt="Selected Image">
                                            @endif
                                        </div>
                                    </div>
                                @endif --}}
                                <div class="col-12 mt-6">
                                    <div class="upload-browse-image">
                                        @if(isset($imageUrl))
                                            <img width="100" height="60" src="{{ $imageUrl }}" alt="Selected Image">
                                        @endif
                                    </div>
                                </div>
                                
                                    <input type="hidden" name="imagePath" id="imagePath" value="">




                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <button id="gallery-btn" class="btn btn-primary">Browse Gallery</button>
                                        </div>
                                    </div>

                                </div>





                                <div class="row">
                                    <div class="col-12 mt-10">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{ old('description', isset($news->description) ? $news->description : null) }}</textarea>
                                        </div>

                                        @if (isset($news->id))
                                            <input type="hidden" name="id" id="newsId"
                                                value="{{ $news->id }}">
                                        @endif


                                        <input type="hidden" name="mediaId" id="mediaId" value="">


                                        <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">Save</button>
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


    <div class="modal fade" id="mediaModal" style="padding-right: 15px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button id="back" class="btn btn-outline-secondary btn-sm" style="display: none;">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>

                <div class="modal-body">
                    <p id="err-1" style="color:red;"></p>
                    <div id="mediaMessageBox">

                    </div>
                </div>
                <div class="modal-footer" id="modal-footer-image">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>


                </div>
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



        function useSelectedImage() {
            const selectedMedia = $('input[name="media"]:checked');
            console.log(selectedMedia);
            if (!selectedMedia.length) {
                $("#err-1").text("Please select image");
                return;
            }

            const mediaId = selectedMedia.val();
            const imageSrc = selectedMedia.siblings('img').attr('src');
            console.log(imageSrc);

            previewImage(mediaId, imageSrc);
        }


        function previewImage(mediaId, imageSrc) {
            if (!mediaId || !imageSrc) {
                console.error('Invalid arguments passed to previewImage.');
                return;
            }

            $.ajax({
                url: '/preview-image',
                type: 'GET',
                data: {
                    media_id: mediaId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response.image_url);
                    $('.upload-browse-image').html('<img width="100" height="60" src="' + '{{ url('/uploads/media/') }}' + '/' + response.image_url + '" alt="Selected Image" />');



                    $('#mediaId').val(mediaId);
                    $('#imagePath').val(imageSrc);
                    $('#mediaModal').modal('hide');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }


        var mediaCategory = `{!! $mediaCategory !!}`;

        $('#gallery-btn').on('click', function(event) {
            event.preventDefault();
            $("#mediaModal").modal('show');
            $("#mediaMessageBox").html(mediaCategory);
        });


        $(document).on('click', '.category-link', function() {
            var categoryId = $(this).data('category-id');

            $.ajax({
                url: '/get-media-by-category/' + categoryId,
                method: 'GET',
                success: function(response) {

                    $('#mediaMessageBox').html(response.html);
                    $('#modal-footer-image').html(
                        '<button type="button" class="btn btn-success btn-sm" id="use-image">Use Image</button>' +
                        '<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>'
                    );

                    $('#use-image').on('click', useSelectedImage);
                },
                error: function() {
                    $('#mediaMessageBox').html(
                        '<p>Failed to load media. Please try again later.</p>');
                }
            });
        });



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

    $(document).on('click', '.delete-image', function (event) {
    event.preventDefault();

    const mediaId = $(this).data('media-id');
    const $label = $(this).closest('label');

    if (!mediaId) {
        console.error('Media ID not found.');
        return;
    }


    // if (!confirm('Are you sure you want to delete this image?')) {
    //     return;
    // }


    $.ajax({
        url: '/delete-media', 
        type: 'POST',
        data: {
            media_id: mediaId,
            _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (response) {
            if (response.success) {
              
                $label.remove();
            } else {
               
                $('#err-1').text('Failed to delete the image. Please try again.');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
           
            $('#err-1').text('An error occurred while deleting the image.');
        }
    });
});

</script>

@endsection
