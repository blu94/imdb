<ul class="nav navbar-nav side-nav nicescroll-bar">
  <li class="navigation-header">
    <span>Main</span>
    <i class="zmdi zmdi-more"></i>
  </li>
  <li>
    <a href="{{url("admin/")}}" class="markSideBar" data-nav-lvl="home">
      <div class="pull-left">
        <i class="icon-home mr-20"></i>
        <span class="right-nav-text">
          Home
        </span>
      </div>
      <div class="clearfix"></div>
    </a>
  </li>
  <li>
    <a href="javascript:void(0);" data-toggle="collapse" data-target="#movieDrp" class="markSideBar" data-nav-lvl="movie">
      <div class="pull-left">
        <i class="fa fa-file-movie-o mr-20"></i>
        <span class="right-nav-text">Movie</span>
      </div>
      <div class="pull-right">
        <i class="zmdi zmdi-caret-down"></i>
      </div>
      <div class="clearfix"></div>
    </a>
    <ul id="movieDrp" class="collapse collapse-level-1 two-col-list">
      <li>
        <a href="{{route("admin.movie.index")}}" class="markSideBar" data-nav-lvl="movie-all">all movie</a>
      </li>
      <li>
        <a href="{{route("admin.movie.create")}}" class="markSideBar" data-nav-lvl="movie-create">Create movie</a>
      </li>
    </ul>
  </li>
</ul>
