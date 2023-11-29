</div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="/js/off-canvas.js"></script>
    <script src="/js/hoverable-collapse.js"></script>
    <script src="/js/template.js"></script>
    <script src="/js/settings.js"></script>
    <script src="/js/todolist.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="/js/dashboard.js"></script>
    <script src="/sweetalerts/dist/sweetalert2.min.js"></script>

    <script>
      $(document).ready(function(){
        //aquí meteremos las instrucciones que modifiquen el DOM
        $('.show').removeClass('show');
        $('.active').removeClass('active');
      });
      
    </script>

    <script>
      $(document).ready(function(){
        
        function fnMarcarMenu(pMenu,pSubmenu){

          var liPrincipal=$('li[id="ui-prin'+pMenu+'"]');
          liPrincipal.addClass('active');

          var aPrincipal=$('a[id="ui-prev'+pMenu+'"]');
          aPrincipal.attr('aria-expanded',true);
          aPrincipal.addClass('show');

          var divMenu=$('div[id="ui-prev'+pMenu+'"]');
          divMenu.addClass('show');

          var amenu=$('a[id="ui-menu'+pSubmenu+'"]');
          amenu.addClass('active');
        };
        fnMarcarMenu({{$menu}},{{$submenu}});
      });
    </script>
    <script type="text/javascript" src="/datatables/datatables.min.js"></script>
    @if(sizeof($scripts)>0)
     
      @foreach($scripts as $script)
        <script type="text/javascript" src="{{$script}}"></script>
      @endforeach
      
    @endif
    <!-- End custom js for this page-->
    <i class="" id="bannerClose"></i>
  </body>
</html>