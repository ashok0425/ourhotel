<style>
  .loader {
  display: flex;
  justify-content: center;
  align-items: center;
height: 100vh;
width: 100vw;
background: rgba(0,0,0,0.4);
position: fixed;
top: 0;
left: 0;
z-index: 99999;
}

.spinner {
  height: 5vh;
  width: 5vh;
  border: 6px solid rgba(1, 90, 122, 0.2);
  border-top-color: rgb(0, 131, 239);
  border-radius: 100%;
  animation: rotation 0.6s infinite linear 0.25s;

  /* the opacity is used to lazyload the spinner, see animation delay */
  /* this avoid the spinner to be displayed when visible for a very short period of time */
  opacity: 0;
}
.custom-text-success{
  color: green!important;
}

.custom-bg-success{
  background: green!important;
  color: #fff;
}

@keyframes rotation {
  from {
    opacity: 1;
    transform: rotate(0deg);
  }
  to {
    opacity: 1;
    transform: rotate(359deg);
  }
}
</style>
<div class="loader d-none">
  <div class="spinner"></div>
</div>
<div id="detail">

  
</div>
  @push('scripts')
      
  <script>
  
  $(window).on('load',function(){
    loadreview()
})
 function loadreview(){
    $.ajax({
    url:'{{url('load-review')}}/'+{{$place->id}},
    beforeSend:function(){
          // $(".loader").removeClass("d-none");
              },
     success:function(data){
      $('#detail').html(data)
      $(".loader").addClass("d-none");

     }
  })
  }
    // storing rating 
    $(document).on('submit','.submit',function(e){
ele=$(this)
     e.preventDefault()
      if ($('.main_rating:checked').val()!=null&& $('#main_comment').val()!='') {
        
      token=$("meta[name='csrf-token']").attr('content');
  
      var fdata = new FormData()
      var files = $('#main_file')[0].files[0];
          fdata.append('file',files);
          fdata.append('star',$('.main_rating:checked').val());
          fdata.append('product_id',$('#main_product_id').val());
          fdata.append('comment',$('#main_comment').val());
          fdata.append('_token',token);
      let url =$('#main_form').attr('action');
      $.ajax({
        url:url,
        type:'POST',
        data:fdata,
        contentType: false,
         processData: false,
         cache: false,
  
               success:function(res){
                console.log('first')
                ele.trigger("reset");
                loadreview()
           },
    
      })
    }
  
    })
  
  
  
    // Replying rating 
    $(document).on('submit','.reply',function(e){

      e.preventDefault()
      var fdata = new FormData(this);
    
      let url =$(this).attr('action');
      let method =$(this).attr('method');
      $.ajax({
        url:url,
        type:method,
        data:fdata,
        contentType: false,
        processData:false,
        beforeSend:function(){
          $(".detail").html("<div class='d-flex justify-content-center py-5'><div class='spinner-border custom-text-primary text-center ' role='status'></div></div>");
      },
               success:function(res){
                loadreview()
         
               }
      })
  
    })
  
  
  
  // reply form open close 
    $(document).on('click','.reply-form-link',function(e){
      e.preventDefault()
      $('.reply-form').addClass('d-none')
      let form=$(this).data('id');
      $('#'+form).toggleClass('d-none');
  
    })
  
    $(document).on('click','.cancel',function(e){
      e.preventDefault()
      let id=$(this).data('id');
      $(this).parent().addClass('d-none');
  
  
    })
  </script>
  
  @endpush
  