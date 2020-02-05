<!doctype html>
<html lang="en" dir="ltr">
  <head>
    @include('admin.layout.head')
    @yield('css')
  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
         @include('admin.layout.header')
        <div class="my-3 my-md-5">
        	@yield('content')
        </div>
      </div>
       @include('admin.layout.footer')
    </div>
    @include('admin.layout.js')
    @yield('js')
    <script>
      function conf(){
        let x = confirm("Are you sure to delete?");
        if(x)
          return true;
        else
          return false;
      }
    </script>
   </body>
 </html> 
