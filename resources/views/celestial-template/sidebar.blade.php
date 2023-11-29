<div class="container-fluid page-body-wrapper">
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <div class="d-flex sidebar-profile">
              <div class="sidebar-profile-image">
                <img src="/images/faces/face29.png" alt="image">
                <span class="sidebar-status-indicator"></span>
              </div>
              <div class="sidebar-profile-name">
                <p class="sidebar-name">
                {{Session::get('user')['nm_completo']}}
                </p>
                <p class="sidebar-designation">
                {{Session::get('user')['de_rol']}}
                </p>
              </div>
            </div>
            <p class="sidebar-menu-title">Menú Principal</p>
          </li>
          {!!html_entity_decode(App\Http\Controllers\Seguridad\Autenticacion::fnDesplegarSideBarPorUsuario())!!}
        </ul>
      
        <ul class="sidebar-legend">
          <li>
            <p class="sidebar-menu-title">Category</p>
          </li>
          <li class="nav-item"><a href="#" class="nav-link">#Sales</a></li>
          <li class="nav-item"><a href="#" class="nav-link">#Marketing</a></li>
          <li class="nav-item"><a href="#" class="nav-link">#Growth</a></li>
        </ul>
      </nav>