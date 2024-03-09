<!DOCTYPE html>
<html>
<head>
    <title>Laravel Crop Image Before Upload Example - Harryinfo</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
</head>

<style type="text/css">
    body{
        background: #f7fbf8; 
    }
    h1{
        font-weight: bold;
        font-size:23px;
    }
    img {
        display: block;
        max-width: 100%;
    }
    .preview {
        text-align: center;
        overflow: hidden;
        width: 160px; 
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
    input{
        margin-top:40px;
    }
    .section{
        margin-top:150px;
        background:#fff;
        padding:50px 30px;
    }
    .modal-lg{
        max-width: 1000px !important;
    }
</style>
<body>
  
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 section text-center">
                <h1>Laravel Crop Image Before Upload Example - ItSolutionStuff.com</h1>
                <form action="{{ route('crop.image.upload.store') }}" method="POST">
                    @csrf
                    <input type="file" name="image1" class="image" data-input-name="image1">
                    <input type="hidden" name="image1_base64">
                    <img src="" style="width: 200px; display: none;" class="show-image" data-input-name="image1">

                    <input type="file" name="image2" class="image" data-input-name="image2">
                    <input type="hidden" name="image2_base64">
                    <img src="" style="width: 200px; display: none;" class="show-image" data-input-name="image2">

  
                    <br/>
                    <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
  
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Laravel Crop Image Before Upload Example - ItSolutionStuff.com</h5>
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
  
    <script>
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        
        $("body").on("change", ".image", function (e) {
            var inputName = $(this).attr('name');
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.data('input-name', inputName).modal('show');
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
            var inputName = $modal.data('input-name');
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview[data-input-name="' + inputName + '"]'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        
        $("#crop").click(function () {
            var inputName = $modal.data('input-name');
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $("input[name='" + inputName + "_base64']").val(base64data);
                    $(".show-image[data-input-name='" + inputName + "']").show();
                    $(".show-image[data-input-name='" + inputName + "']").attr("src", base64data);
                    $("#modal").modal('toggle');
                }
            });
        });
          
    </script>
</body>
</html> 