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
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>تعديل المطعم</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="container">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">الشعار<span class="required">*</span>
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
                <form id="update-restaurant" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data"
                    action="{{ Route('restaurant.update-ar',$rest->id) }}" method="POST">
                    {{csrf_field()  }}
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="rest_name">اسم المطعم<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $rest->rest_name }}" id="rest_name" name="rest_name" required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="description">الوصف<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $rest->description }}" id="description" name="description" required="required" class="form-control ">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_rest_name">الاسم العربي<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $rest->ar_rest_name }}" id="ar_rest_name" name="ar_rest_name" required="required"
                                class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_description">الزصف بالعربي<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $rest->ar_description }}" id="ar_description" name="ar_description" required="required"
                                class="form-control ">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="country">الدلوة<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control" id="country" name="country" required="required">
                                <option value="{{ $rest->country->id }}">{{ $rest->country->R_country_name }}</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{  $country->ar_country_name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                   <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">الشعار</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="logo" name="logo" class="form-control" value="{{ $rest->logo }}">
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
		aspectRatio: 16/9,
		cropBoxResizable:false,
		preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
	    width: 600,
	    height: 300,
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
                url: '{{url("restaurant/upload_rest_edit")}}',
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    $modal.modal('hide');
                   /*  alert("success upload image"); */
                   /* window.location.assign("/restaurants/crop"); */
                   //alert(data.success);
                   document.getElementById("logo").value = data.success;
                }
              });
         }
    });
})

</script>
@endsection
