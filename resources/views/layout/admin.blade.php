<!doctype html>
<html class="no-js" lang="en">
<head>
  @include('admin/partials.head')  
</head>
<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        @include('admin/partials.sidebar')
        <!-- main content area start -->
        <div class="main-content">

        @include('admin/partials.header')

            <div class="main-content-inner">
            @yield('content') 
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright <script>document.write(new Date().getFullYear());</script>. All right reserved.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end --> 
  
  @include('admin/partials.offset')
  @include('admin/partials.applicationTableOrder')
  @include('admin/partials.applicationFilter')
  @include('admin/partials.modal')
  @include('admin/partials.footer')
  @yield('js')


  <script>
    CKEDITOR.replace( 'description', {
    versionCheck: false
    // Add other configurations here as needed
});

</script>
</body>
</html>
