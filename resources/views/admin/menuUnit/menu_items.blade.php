@extends('layout.admin')
@section('content')

<div class="row">
    <!-- data table start -->
    
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body list-grid">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

                <div class="row">
                    <div class="col-12">
                        <div class="grid-col control-bar">

                            <div class="row control">
                                <div class="col-6 left-control">

                                    <div class="loading"></div>

                                </div>

                                <div class="col-6 right-control">

                                    <a href="javascript:void(0);" onclick="window.history.back();">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Back</button>
                                    </a>

                                    <a href="{{ route('menu-unit.index') }}">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Refresh</button>
                                    </a>

                                    <a href="{{ route('menu-unit.addMenuItems', $menuId) }}">
                                        <button type="button" class="btn btn-flat btn-secondary mb-3">Add Menu Item</button>
                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="data-tables">
                    <style>
                       
                    </style>
               
               <div class="col-md-6">
                <div class="panel panel-default menu-item-container">
                    <div class="panel-heading clearfix menu-heading"><h5 class="pull-left">Menu</h5>
                      
                    </div>
                 
                    

                    <div class="panel-body" id="cont">
                        <ul id="myEditor" class="sortableLists list-group">
                            @foreach($items as $item)
                               
                                @if($item->parent_id == 0)
                                    <li id="item{{ $item->id }}" class="list-group-item">
                                        <div style="margin-bottom: 5px;">
                                            <span class="txt">{{ $item->title }}</span>
                                            <div class="btn-group pull-right">
                                                <a class="m-2" href="{{ route('menu-unit.editMenuItems', $item->id) }}">
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                                <a class="m-2" onclick="deleteMenuItem('{{ route('menu-unit.deleteMenuItems', $item->id) }}', '{{ $item->id }}', 'Delete this Menu details?', 'Are you sure you want to delete this menu details?');">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </a>
                                            </div>
                                        </div>
                                        
                                      
                                        @if($item->children && $item->children->isNotEmpty())
                                            <ul class="sortableLists list-group">
                                                @foreach($item->children as $child)
                                                    <li id="item{{ $child->id }}" class="list-group-item">
                                                        <div style="margin-bottom: 5px;">
                                                            <span class="txt">{{ $child->title }}</span>
                                                            <div class="btn-group pull-right">
                                                                <a class="m-2" href="{{ route('menu-unit.editMenuItems', $child->id) }}">
                                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                                </a>
                                                                <a class="m-2" onclick="deleteMenuItem('{{ route('menu-unit.deleteMenuItems', $child->id) }}', '{{ $child->id }}', 'Delete this Menu details?', 'Are you sure you want to delete this menu details?');">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        
                                                      
                                                       @if($child->children && $child->children->isNotEmpty())
                                                            <ul class="sortableLists list-group">
                                                                @foreach($child->children as $grandchild)
                                                                    <li id="item{{ $grandchild->id }}" class="list-group-item">
                                                                        <div style="margin-bottom: 5px;">
                                                                            <span class="txt">{{ $grandchild->title }}</span>
                                                                            <div class="btn-group pull-right">
                                                                                <a class="m-2" href="{{ route('menu-unit.editMenuItems', $grandchild->id) }}">
                                                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                                                </a>
                                                                                <a class="m-2" onclick="deleteMenuItem('{{ route('menu-unit.deleteMenuItems', $grandchild->id) }}', '{{ $grandchild->id }}', 'Delete this Menu details?', 'Are you sure you want to delete this menu details?');">
                                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif 
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div> 
                    
                    
                </div>
               


             

                  

            </div>
                
                </div>

            </div>
        </div>
    </div>
    <!-- data table end -->
</div>




@section('js')
<script>
    var url;
  
    function deleteMenuItem(deleteUrl, itemId, title, message) {
        url = deleteUrl;
       // console.log(url)
       
    $("#deleteAlertBox").modal('show');
    $('#deleteMessageHeading').html(title);
    $('#deleteMessageText').html(message);

    $("#deleteAllModalButton").on("click", function () {

        $("#deleteAlertBox").modal('hide');
        $.ajax({
            type: "POST",
            data: {
               id: itemId,
                _method: "DELETE",
            },
            url: url,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $(".loading").show();
            },
            complete: function () {
                $(".loading").hide();
            },
            success: function (result) {
                //admin.log(result);
                if (result.status) {

                   $('#item' + itemId).hide();
                    $("#messageModal").modal('show');
                    $("#messageBox").html('<p>menu information  deleted successfully</p>');

                }

            }
        });
    });
    }
</script>
<script src="{{ asset('assets/admin/js/console/menu_unit.js') }}"></script>
@append

@endsection

