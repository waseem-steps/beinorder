@extends('layouts.master-ar')

<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg {
        max-width: 1000px !important;
    }
</style>

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>تعديل نوع المنتج</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="container">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">الصورة<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="file" name="image" class="image" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="img-container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-primary" id="crop">قص</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="update-branch" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data"
                    action="{{ Route('product-category.update-ar',$cat->id) }}" method="POST">
                    {{csrf_field()  }}
					<input type="hidden" name="thumb_img" id="thumb_img"  />
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="category_name">اسم نوع المنتج<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $cat->category_name }}" id="category_name" name="category_name"
                                required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_category_name">الاسم العربي<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $cat->ar_category_name }}" id="ar_category_name"
                                name="ar_category_name" required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="img">الصورة<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="img" name="img" class="form-control" value="{{ $cat->img_path }}">
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">حفظ التغيرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script>
    var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;

$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
		viewMode: 1,
		dragMode: 'move',
		aspectRatio: 1,
		cropBoxResizable:false,
		preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
	    width: 500,
	    height: 500,
      });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob);
         reader.onloadend = function() {
            var base64data = reader.result;

            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{url("/product-category/upload_cat_edit")}}',
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    $modal.modal('hide');
                   /*  alert("success upload image"); */
                   /* window.location.assign("/restaurants/crop"); */
                   //alert(data.success);
                   document.getElementById("img").value = data.success;
                }
              });
         }
    });

	canvas = cropper.getCroppedCanvas({
	    width: 160,
	    height: 160,
      });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob);
         reader.onloadend = function() {
            var base64data = reader.result;

            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{url("/product-category/upload_cat_edit")}}',
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    $modal.modal('hide');
                   /*  alert("success upload image"); */
                   /* window.location.assign("/restaurants/crop"); */
                   //alert(data.success);
                   document.getElementById("thumb_img").value = data.success;
                }
              });
         }
    });

})

</script>
@endsection
