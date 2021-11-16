$(document).ready(function () {
  $('#copper_modal').on('hidden.bs.modal', function () {
    canvas.cropper("destroy");
  });
});
$("#copper_modal").modal("hide");
var canvas  = $("#canvas"),
context = canvas.get(0).getContext("2d"),
$result = $('#result');

$('#file-input').on( 'change', function(){
  
  $('#copper_modal').modal("show");
  setTimeout(function() { 
    if (this.files && this.files[0]) {
      if ( this.files[0].type.match(/^image\//) ) {
        var reader = new FileReader();
        reader.onload = function(evt) {
         var img = new Image();
         img.onload = function() {
           context.canvas.height = img.height;
           context.canvas.width  = img.width;
           context.drawImage(img, 0, 0);
           var cropper = canvas.cropper({
             aspectRatio: 16 / 9
           });
           $('#btnCrop').click(function() {
            // alert('1');
                    // Get a string base 64 data url
                    $("#copper_modal").modal("hide");
                    var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png"); 
                    $result.append( $('<img>').attr('src', croppedImageDataURL));
                    $('#croppedImageDataURL').val(croppedImageDataURL);
                  });
           $('#btnRestore').click(function() {
             canvas.cropper('reset');
             $result.empty();
           });
         };
         img.src = evt.target.result;
       };
       reader.readAsDataURL(this.files[0]);

     } else {
      Swal.fire(
        'error!',
        "Invalid file type! Please select an image file.",
        'error'
      )
    }
  } else {
    Swal.fire(
      'error!',
      "No file(s) selected.",
      'error'
    )
  }
}.bind(this), 300);
});