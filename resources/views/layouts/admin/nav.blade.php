 <!-- Main Content -->
 <div id="content">

     <!-- Topbar -->
     <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

         <!-- Sidebar Toggle (Topbar) -->
         <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
             <i class="fa fa-bars"></i>
         </button>

         <!-- Topbar Search -->
         <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

         </form>

         <!-- Topbar Navbar -->
         <ul class="navbar-nav ml-auto">



             <!-- Nav Item - Alerts -->


             <!-- Nav Item - Messages -->


             <div class="topbar-divider d-none d-sm-block"></div>

             <!-- Nav Item - User Information -->
             <li class="nav-item dropdown no-arrow">
                 <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                 </a>
                 <!-- Dropdown - User Information -->
                 <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                     <form action="{{route('logout')}}" method="post">
                         @csrf
                         @method('post')
                         <button class="dropdown-item" type="submit" >
                             <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                             Logout
                         </button>
                     </form>
                     <hr>
                     <a class="dropdown-item btn btn-primary" type="submit" href="{{route('password.index')}}">
                         <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                         update password
                     </a>
                 </div>
                 
             </li>

         </ul>

     </nav>
     <!-- End of Topbar -->