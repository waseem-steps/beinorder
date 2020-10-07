@extends('layouts.master')

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
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="container">
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">Logo<span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="file" name="image" class="image" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
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
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="create-product" data-parsley-validate class="form-horizontal form-label-left"
                        action="{{ Route('product.store',$request->cat_id) }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()  }}
                        <input type="hidden" name="cat_id" id="cat_id" value="{{ $request->cat_id }}" />
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="cat_name">Product Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="product_name" name="product_name" required="required" class="form-control ">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_product_name">Product Arabic Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="ar_product_name" name="ar_product_name" required="required" class="form-control ">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="product_description">Product Description<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="product_description" name="product_description" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_product_description">Product Arabic Description<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="ar_product_description" name="ar_product_description" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="price">Price<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="price" name="price" required="required" class="form-control ">
                            </div>
                        </div>
                        <input type="hidden" id="img" name="img" class="form-control ">
						<input type="hidden" id="thumb_img" name="thumb_img" class="form-control ">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
                url: '{{url("/product/upload_product")}}',
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
                url: '{{url("/product/upload_product_thumbnail")}}',
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
