<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CelestialUI Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="/vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="/sweetalerts/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="/css/loaders.css">
  <link rel="stylesheet" href="/css/floating-labels.min.css"> 
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto" style="background-color: #cbd0e8;">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div >
                <center><img src="/images/prevision-loginv1.png" alt="logo" style="height:65px;" ></center>
                
              </div>
              @csrf()
              <br>
              <center>
                <h6 class="font-weight-light">Coloca tus credenciales para continuar</h6>
              </center>
              <form name="form-login" onsubmit="return false;">
              <div class="col-md-12">
                    <div class="form-label-group outline">
                        <input type="text" id="cd_usuario" name="cd_usuario"
                        class="form-control shadow-none" placeholder="Usuario" style="height:47px;font-size:13px;" />
                        <span><label for="cd_usuario" id="cd_usuario">Usuario</label></span>
                    </div>
                    <div id="errorcd_usuario" style="font-size:11px;display:none;color:red;"></div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="form-label-group outline">
                        <input type="password" id="de_clave" name="de_clave"
                        class="form-control shadow-none" placeholder="Contraseña" style="height:47px;font-size:13px;" />
                        <span><label for="de_clave" id="de_clave">Contraseña</label></span>
                    </div>
                    <div id="errorde_clave" style="font-size:11px;display:none;color:red;"></div>
                </div>
                <div class="col-md-12">
                <br>
                <center>
                <button type="button" class="btn" style="color:white;background:#cbd0e8" onclick="fnValidarCredenciales()" >
                ENTRAR</button>
                </center>
                <div class="container-fluid">
                
                </div>
            </div>
            <br>
            <center>
              <h6 class="font-weight-light">Si has olvidado tu contraseña, pulsa los botones de abajo</h6> 
            </center>
              <div class="row">

                  <div class="col-md-12">
                  <center>
                    <a href="">¿Desea recuperar la clave?</a>
                  </center>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="/js/off-canvas.js"></script>
  <script src="/js/hoverable-collapse.js"></script>
  <script src="/js/template.js"></script>
  <script src="/js/settings.js"></script>
  <script src="/js/todolist.js"></script>
  <script src="/sweetalerts/dist/sweetalert2.min.js"></script>
  <script src="/prevision/autenticacion/login.js"></script>
  <script src="/prevision/utiles/sweetAlertsPersonalizados.js"></script>
  <script src="/prevision/utiles/validacionFormulario.js"></script>
  <!-- endinject -->
</body>

</html>
