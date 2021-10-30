<div class="jumbotron jumbotron-fluid p-0">
      <div class="container">
        <h1 class="display-4 text-monospace font-weight-bold"><a href="/" class="text-decoration-none text-dark">{{ config('app.name') }}</a></h1>
        <!-- <p class="lead"><a href="/akun" class="text-decoration-none font-weight-bold text-dark">{{ Auth::user()->name ?? ''}}</a></p> -->
        <p class="lead font-weight-bold" style="color:#9900cc">{{ Auth::user()->name ?? ''}}</p>
      </div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">
  <a class="navbar-brand" href={{route('pendaftaran')}}>Pendaftaran</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href={{url("/pendaftaran")}}>Home <span class="sr-only">(current)</span></a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Pasien
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href={{url("/pendaftaran/pasien")}}>Data Pasien</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href={{url("/pendaftaran/pasien/create")}}>+pasien</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href={{url("/about")}} tabindex="-1" aria-disabled="true">About</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</div>
</nav>

</div>
