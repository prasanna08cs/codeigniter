<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#Intrrest').addClass('active');
        $('#Intrrest2').addClass('active');
    });
//    function edit(val) {
////    alert("hi"+val.value);
//        $('#modal-container-1866991').modal("show");
//        $('#idoftax').val(val.value);
//
//    }
    function delete1(val) {
//    alert("hi"+val.value);


        $('#modal-container-18669912').modal("show");
        $('#idoftaxtodelete').val(val.value);
    }


    $(document).ready(function() {
        $('#upload-file-info').hide();
        
        $('#fileToUpload').change(function (){
            alert('cahnge');
           
            var formElement = $('#fileToUpload').prop('files')[0];
            var formData = new FormData(formElement);
//            formData.append('uploadType' , 'offering');
//            formData.append('type' , 'subcategory');
            $.ajax({
                url: "http://104.131.165.164:8080/Kidzo/application/views/upload_file_offering.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                async: false,
                success: function (result) {
                    alert(result.msg);
                    if (result.msg == '1') {
                        $('#ImageUrl').val("https://s3.amazonaws.com/" + result.fileName);
//                        alert($('#ImageUrl').val());
                        $('#iimg').hide();
                    } else {
                        alert('Problem In Uploading Image-' + result.folder);
                        $('#iimg').hide();
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
           
            
        });
        
        
        $('.edit_class').click(function() {
            var SubCat = $(this).closest("tr").find(".SubCat").text();
            var desc = $(this).closest("tr").find(".desc").text();

            $('#subcategory').val(SubCat);
            $("#desc").val(desc);
            $('#modal-container-1866991').modal("show");
            $('#idoftax').val($(this).val());

        });



        $("#fileToUpload").on("change", function()
        {
//            $('#imagePreview').show();
//            $('#BizLogo').hide();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    $('#upload-file-info').show();
                    $("#upload-file-info").css("background-image", "url(" + this.result + ")");
                }
            }
        });
    });

</script>
<style>
    #upload-file-info {
        width: 180px;
        height: 180px;
        background-position: center center;
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
        margin-top: 11px;
    }

</style>
<aside class="right-side">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <div style="width: 100%">
                            <div style="float: left;">
                                <h3 class="box-title">Offering Sub-Category</h3>
                            </div>

                            <div style="float: right;">

                                <!--                               <button  type="submit" class="btn btn-success btn-sm" name="action" value="active">Active</button>
                                                                <button type="submit" class="btn btn-primary btn-sm"  name="action" value="suspend" >Suspend</button>
                                                                <button type="submit" class="btn btn-danger btn-sm"  name="action" value="reject">Reject</button>-->
                                <a id="modal-186699" href="#modal-container-186699" data-toggle="modal">  <button  type="submit" class="btn bg-maroon margin"   name="action" value="add">Add</button></a>
                                <!--<button  type="submit" class="btn bg-navy margin"   name="action" value="edit">Edit</button>-->
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <!--add Category data--> 
                    <div class="modal fade in" id="modal-container-186699" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
                        <div class="modal-dialog">


                            <?php echo form_open(base_url() . 'index.php/offerings/sub_category/add/' . $id) ?>     
                            <?php echo validation_errors(); ?>
                            <!--<form method="post">-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Add data</h4>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Category Logo</label>
                                        <form action="upload_file_offering.php" method="POST" enctype="multipart/form-data" id="files_upload_form">                            
                                            <div style="position:relative;">
                                                <a class="btn btn-primary" >
                                                    Choose File...
                                                    <input type="file" name="myfileone" id="fileToUpload"  style='position:absolute;z-index:2;margin-top: -21px;cursor: pointer;margin-left: -18px;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'  size="40">
                                                </a>
                                                &nbsp;<br/>
                                                
                                                <div  id="upload-file-info"></div>
                                            </div>
                                            <input type="file" name="ram">
                                        </form>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select class="form-control"  id="countryname"  name="catid" required>
                                            <?php
                                            $GetCat = $this->mongoDB->selectCollection('OfferingCategories');
                                            $Cats = $GetCat->find();
                                            $Cats_Res = array();
                                            foreach ($Cats as $result) {
                                                $Cats_Res[] = $result;
                                            }
                                            echo '<option value="">Select ....</option>';
                                            foreach ($Cats_Res as $row) {
                                                echo '<option value=' . (string) $row['_id'] . ' name="catid">' . $row['type_name'] . '</option>';
                                            }
                                            ?> 
                                        </select>
                                    </div>
                                    <div class="form-group" >

                                        <label>Sub Category Name</label>
                                        <input type="text" class="form-control" placeholder="Enter ..." name="subcategory" required> 
                                    </div>
                                    <input type="hidden" name="ImageUrl" id="ImageUrl">
                                    <div class="form-group" >

                                        <label>Sub Category Description</label>

                                        <textarea class="form-control" placeholder="write something..."  name="desc"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="Submit" class="btn btn-primary" value="Add" id="adddata">

                                </div>
                                <?php echo form_close() ?>
                                <!--</form>-->
                            </div>
                        </div>

                    </div>

                    <!--end of add category data-->
                    <!--edit Category data--> 
                    <div class="modal fade in" id="modal-container-1866991" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
                        <div class="modal-dialog">


                            <?php echo form_open(base_url() . 'index.php/offerings/sub_category/edit/' . $id) ?>     
                            <?php echo validation_errors(); ?>
                            <!--<form method="post">-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Add data</h4>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group" >

                                        <label>Sub Category Name</label>
                                        <input type="text" class="form-control" placeholder="Enter ..." name="subcategory" id="subcategory" required>
                                    </div>
                                    <input type="hidden" id="idoftax" value="" name="id">
                                    <div class="form-group" >

                                        <label>Category Description</label>

                                        <textarea class="form-control" placeholder="write something..."  name="desc" id="desc"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="Submit" class="btn btn-primary" value="Update">

                                </div>
                                <?php echo form_close() ?>
                                <!--</form>-->
                            </div>
                        </div>

                    </div>

                    <!--end of edit category data-->
                    <!--delete data--> 
                    <div class="modal fade in" id="modal-container-18669912" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
                        <div class="modal-dialog">


                            <?php echo form_open(base_url() . 'index.php/offerings/sub_category/delete/' . $id) ?>     
                            <?php echo validation_errors(); ?>
                            <!--<form method="post">-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Add data</h4>
                                </div>

                                <div class="modal-body">
                                    <label>Are you sure to delete ?</label>

                                    <input type="hidden" id="idoftaxtodelete" value="" name="id">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <input type="Submit" class="btn btn-primary" value="Yes">

                                </div>
                                <?php echo form_close() ?>
                                <!--</form>-->
                            </div>
                        </div>

                    </div>

                    <!--end of delete category data-->

                    <div class="box-body table-responsive" style="margin-bottom: 61px;">
                        <form action="" method="post">
                            <div>
                                <div class="col-md-3">
                                    <label>Select Category</label>
                                    <select class="form-control"  id="IntCat"  name="IntCat">
                                        <?php
                                        $IntCat = $this->mongoDB->selectCollection('OfferingCategories');
                                        $IntCatRes = $IntCat->find();
                                        $IntCatRes_Arr = array();
                                        foreach ($IntCatRes as $result) {
                                            $IntCatRes_Arr[] = $result;
                                        }
                                        echo '<option>Select Category</option>';
                                        foreach ($IntCatRes_Arr as $row) {
                                            echo '<option value=' . (string) $row['_id'] . ' id=' . (string) $row['_id'] . ' name="catid">' . $row['type_name'] . '</option>';
                                        }
                                        ?> 
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="Search" class="form-control btn btn-danger btn-sm" id='Search' value="Search"/>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Sub-Category</th>
                                    <th>Description </th>

                                    <th style="width: 20%">options</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $SubCats = $this->mongoDB->selectCollection('OfferingSubCategories');
                                if (isset($_REQUEST['Search'])) {
                                    $SubCatsRes = $SubCats->find(array('cat_type' => $_REQUEST['IntCat']));
                                } else {
                                    $SubCatsRes = $SubCats->find();
                                }
                                $subs = array();
                                foreach ($SubCatsRes as $result) {
                                    $subs[] = $result;
                                }

                                foreach ($subs as $row) {

                                    $Cat = $this->mongoDB->selectCollection('OfferingCategories');
                                    $cats = $Cat->find(array('_id' => new MongoId((string) $row['cat_type'])));
                                    foreach ($cats as $result) {
                                        $subs = $result;
                                    }
                                    echo '<td>' . $subs['type_name'] . '</td>';
                                    echo '<td class="SubCat">' . $row['sub_type_name'] . '</td>';
                                    echo '<td class="desc">' . $row['sub_type_desc'] . '</td>';

                                    echo '<td>
                                                    <button class="edit_class" value="' . (string) $row['_id'] . '"  >
                                        <i class="fa fa-edit"></i> Edit</button>
                                    <button value="' . (string) $row['_id'] . '" onclick="delete1(this)"><i class="fa fa-trash-o"></i>Delete</button></td></tr>';
                                }
                                ?> 
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

<!--                            <input type="checkbox" name="businessType1" value="1">-->


                </div><!-- /.box -->

            </div>

        </div>

    </section><!-- /.content -->

