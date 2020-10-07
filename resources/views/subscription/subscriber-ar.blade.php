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
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel" style="border: 0px;">
                <div class="x_title">
                    <h2>اشترك</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
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
            <form id="create-subscription" data-parsley-validate class="form-horizontal form-label-left"
                action="{{ Route('subscription.store-ar') }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()  }}

                <input type="hidden" name="plan_id" id="plan_id" value={{ $id }}>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="x_panel" style="border: 0px;">
                    <div class="x_title">
                        <h2>معلومات المطعم</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="rest_name">اسم المطعم<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="rest_name" name="rest_name" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="ar_rest_name">الاسم العربي<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="ar_rest_name" name="ar_rest_name" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="description">الوصف<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea id="description" name="description" required="required"
                                            class="form-control "></textarea>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="ar_description">الوصف العربي<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea id="ar_description" name="ar_description" required="required"
                                            class="form-control "></textarea>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="country">الدولة<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" id="country_id" name="country_id" >
                                             @foreach(App\Http\Controllers\CountryController::getCountries() as $country)
                                            <option value="{{ $country->id }}">
                                            {{  $country->ar_country_name }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="logo">الشعار<span
                                            class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="logo" name="logo"
                                            class="form-control " radonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel" style="border: 0px;">
                    <div class="x_title">
                        <h2>مدير المطعم</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="username">الاسم<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="username" name="username" required="required"
                                            class="form-control ">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">الايميل<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="email" id="email" name="email" required="required" class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">كلمة السر<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="password" id="password" name="password" required="required" class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="c_password">تأكيد كلمة السر<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="password" id="c_password" name="c_password" required="required" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel" style="border: 0px;">
                    <div class="x_content text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-round btn-success" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                url: '{{url("/restaurant/upload_rest")}}',
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
