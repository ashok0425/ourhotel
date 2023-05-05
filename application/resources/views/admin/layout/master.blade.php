<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf_token" content="{{csrf_token()}}">
  <title>Skydash Admin</title>

  <link rel="stylesheet" href="{{asset('admin/css/vertical-layout-light/style.css')}}">
  <link rel="stylesheet" href="{{asset('admin/css/feather.css')}}">
  <link rel="stylesheet" href="{{asset('admin/css/ti-icons/css/themify-icons.css')}}">
  <link rel="shortcut icon" href="images/favicon.png" />
  @stack('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  @vite('resources/js/app.js')
</head>
<body>
  <div class="container-scroller">
   @include('admin.layout.header')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      @include('admin.layout.sidebar')
      <div class="content-wrapper">
     
          <x-errormsg/>
      <!-- partial -->
      @yield('content')
      
      </div>
    </div>  
  </div>


<!-- Modal -->
<div class="container">
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalTitle">Are you sure you want to delete this item ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
       <form action="" method="post" id="delete_form" class="text-right">
        @method('DELETE')
        @csrf
          <button type="button" class="btn btn-secondary btn-rounded"  data-dismiss="modal">&nbsp; No &nbsp;</button>
          <button  class="btn btn-primary btn-rounded">&nbsp; Yes &nbsp;</button>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>



  <script src="{{asset('admin/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('admin/vendors/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('admin/vendors/js/template.js')}}"></script>
  @stack('script')

  <script>
    $(document).ready(function(){
     //delete row
     $(document).on('click','.delete_row',function(){
      let url=$(this).attr('href');
      $('#delete_form').attr('action',url)
     })

    })
  </script>
</body>

</html>

