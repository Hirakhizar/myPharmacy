<!DOCTYPE html>
<html lang="en">
 {{-- head --}}
 @include('admin.head')
 {{-- end head --}}
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
    @include('admin.sidebar')
      <!-- End Sidebar -->

      <div class="main-panel">
       {{-- main-header --}}
@include('admin.main_header')
       {{-- end main-header --}}
        <div class="container">
@include('admin.inner_page')
        </div>

       {{-- footer --}}

       @include('admin.footer')
        {{-- end footer --}}
      </div>

      <!-- Custom template | don't include it in your project! -->
      @include('admin.custom')
      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
 @include('admin.scripts')
  </body>
</html>
