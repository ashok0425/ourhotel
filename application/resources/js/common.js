let img_path=location.origin+'/storage/uploads/'
function previewUploadImage(input, element_id) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $(`#${element_id}`).removeClass('d-none');
            $(`#${element_id}`).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('#thumb').change(function () {
    previewUploadImage(this, 'preview_thumb')
});



$('#gallery').change(function (e) {
    if($('.remove_gallery').length>=3){
        $('.max_file').html('Only 3 File can be uploaded');
        return false;
    }
    e.stopPropagation()
    stop()
    $('.max_file').html('');
 
    var form_data = new FormData();
    form_data.append('image', this.files[0]);
    form_data.append('_token',$("meta[name='csrf_token']").attr('content'));
    $.ajax({
        url: '/upload-image',
        data: form_data,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function (res) {
                if (res.code === 200) {
                    
                    if(res.status=='error'){
                        console.log(res.file_name)
                        $('.max_file').html(res.file_name);
                   return false;
                    }
        $('#gallery_preview').append(`
        <div style="position:relative;width:100px">
        <input type="hidden" name="gallery[]" value="${res.file_name}"/>
        <img src="${img_path+res.file_name}" alt="" width='100' height='100'>
        <a style="position:absolute;top:10px;right:10px;color:red;cursor:pointer"  class="remove_gallery" id="${res.file_name}"><i class='fas fa-trash'></i></a>
        
        </div>
        `)
    };
}
            });
 
 });

 $(document).on('click','.remove_gallery',function(e){
    e.stopPropagation()
    stop();
    $('.max_file').html('');
    let image=$(this).attr('id');
    let id=$(this).attr('data-id');
    let model=$(this).attr('data-model');

  $(this).parent().remove();
  
  $.ajax({
    url: `/delete-image?image=${image}&id=${id}&model=${model}`,
    type: 'GET',
    contentType: false,
    processData: false,
    success: function (res) {
        console.log(res);
    }
});
 })