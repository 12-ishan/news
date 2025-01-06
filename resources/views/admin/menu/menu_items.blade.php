

@extends('layout.admin')
@section('content')

<div class="row">
   

<div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->

            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">


                       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> --}}

                        {{-- <link rel="stylesheet" href="{{ asset('assets/bs-iconpicker/css/bootstrap-iconpicker.min.css') }}"> --}}

       <style>
        *{
    box-sizing: border-box;
}

.main-heading {
    text-transform: uppercase;
    color: red;
    font-weight: bold;
}
.d-flex {
    display: flex;
    align-items: center; 
    justify-content: space-between; 
}

.caption{
    display: flex;
    align-items: center;
}

.icon-settings {
    margin-right: 5px; 
}
.menu-item-form-container{
    border: 2px solid rgb(27, 137, 226);
    padding-bottom: 10px;

}
.edit-item-heading{
    background-color: rgb(27, 137, 226);
    padding: 10px;
    margin-bottom: 15px;
    color: white
}
.menu-item-container{
    border: 2px solid rgb(243, 242, 242);
    padding-bottom: 10px;
}
.menu-heading{
    background-color:rgb(241, 241, 241);
    padding: 10px;
    margin-bottom: 15px;
    color: black
}

       </style>

                        
                        
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                                <div class="page-content">
                                    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                                    
                                
                                
                                
                                    <!-- END PAGE HEADER-->
                                    
                                    
                                    <div class="row row-stat">        
                                            <div class="col-md-12 col-sm-12">
                                            
                                              <div class="portlet light bordered">
                                               <div class="portlet-title">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="caption font-red-sunglo">
                                                        <i class="icon-settings font-red-sunglo"></i>
                                                        <span class="main-heading caption-blog bold uppercase">Menu Item Builder</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <button id="btnOut" type="button" class="btn btn-success">
                                                            <i class="glyphicon glyphicon-ok"></i> Save Changes
                                                        </button>
                                                    </div>
                                                </div>
                                                
                        
                        
                        
                                                    </div>
                        
                                                    
                                                     <div class="portlet-body form">
                        <span id="err" style="color:red;"></span>
                                    
                                    <?php if(isset($imageerror)){echo "<span id='imgerror' style='color:red;'>Please upload a image with resolution 500 * 500 </span>
                                   ";} ?>
                                   
                                    <?php if(isset($message)){ ?> <span style='color:red;'><?php echo $message; ?></span> <?php } ?>
                                    
                                    <br>  <br>
                                        
                        
                                            <div class="row">  
                                    
                                    <div class="col-md-12 col-sm-12">
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                               
                                   
                                    <div class="row">
                                      
                                        <div class="col-md-6">
                                            <div class="panel panel-primary menu-item-form-container">
                                                <div class="edit-item-heading panel-heading">Edit item</div>
                                                <div class="panel-body">
                                                    <form id="frmEdit" class="form-horizontal">
                                                        <div class="form-group">
                                                            <label for="text" class="col-sm-2 control-label">Title</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Tilte">
                                                                    <div class="input-group-btn">
                                                                        <button type="button" id="myEditor_icon" class="btn btn-default" data-iconset="fontawesome"></button>
                                                                    </div>
                                                                    <input type="hidden" name="icon" class="item-menu">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="href" class="col-sm-2 control-label">URL</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="target" class="col-sm-2 control-label">Target</label>
                                                            <div class="col-sm-10">
                                                                <select name="target" id="target" class="form-control item-menu">
                                                                    <option value="_self">Self</option>
                                                                    <option value="_blank">Blank</option>
                                                                    <option value="_top">Top</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="col-sm-2 control-label">Tooltip</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Tooltip">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="ml-2 panel-footer">
                                                    <input type="hidden" id="menuId" value="<?php if(isset($menuId)){echo $menuId;}?>" >
                                                    <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fa fa-refresh"></i> Update</button>
                                                    <button type="button" id="btnAdd" class="btn btn-success"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                        
                                 
                        
                        
                                       
                                    </div> 
                                    
                                    
                                    <div class="col-md-6">
                                            <div class="panel panel-default menu-item-container">
                                                <div class="panel-heading clearfix menu-heading"><h5 class="pull-left">Menu</h5>
                                                    <!-- <div class="pull-right">
                                                        <button id="btnReload" type="button" class="btn btn-default">
                                                            <i class="glyphicon glyphicon-triangle-right"></i> Load Data</button>
                                                    </div> -->
                                                </div>
                                                <div class="panel-body" id="cont">
                                                    <ul id="myEditor" class="sortableLists list-group">
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <button id="btnOut" type="button" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Output</button>
                                            </div> -->
                        
                        
                        
                                            <!-- <div class="form-group"><textarea id="out" class="form-control" cols="50" rows="10"></textarea>
                                            </div> -->
                        
                        
                                               <div class="form-group" style="display:none;"><textarea id="jsonString" class="form-control" cols="50" rows="10"><?php if(isset($jsonString)) {echo $jsonString; }?></textarea>
                                            </div>
                        
                        
                                        </div>
                        
                                    </div>
                                    
                              
                               
                            </div>
                        </div>       
                                                            
                                                                 
                                </div>
                                </div>
                                    
                                </div>
                            </div>
                            <!-- END CONTENT -->
                        
                        
                        
                        
                        




</div>
</div>
</div>
<!-- basic form end -->
</div>
</div>
</div>


@section('js')
<script>
    var addMenuItemsUrl = "{{ route('menu.addMenuItems') }}"; // Correct route URL
</script>
<script src="{{ asset('assets/admin/js/console/menu.js') }}"  type="text/javascript"></script>





@append

@endsection