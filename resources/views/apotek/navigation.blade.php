<div class="jumbotron jumbotron-fluid p-0">
      <div class="container">
        <h1 class="display-4 text-monospace font-weight-bold"><a href="/" class="text-decoration-none text-dark">{{ config('app.name') }}</a></h1>
        <!-- <p class="lead"><a href="/akun" class="text-decoration-none font-weight-bold text-dark">{{ Auth::user()->name ?? ''}}</a></p> -->
        <p class="lead font-weight-bold" style="color:#9900cc">{{ Auth::user()->name ?? ''}}</p>
      </div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">
  <a class="navbar-brand" href={{route('apotek')}}>Apotek</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href={{url("/apotek")}}>Home <span class="sr-only">(current)</span></a>
      </li> -->
      <li class="nav-item active">
        <a class="nav-link" href="/apotek/obat">Daftar Obat <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href={{url("/about")}} tabindex="-1" aria-disabled="true">About</a>
      </li>
    </ul>
  </div>
</div>
</nav>

</div>
