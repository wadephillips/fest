<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.2/css/regular.css" integrity="sha384-4Cp0kYV2i1JFDfp6MQAdlrauJM+WTabydjMk5iJ7A9D+TXIh5zQMd5KXydBCAUN4" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.2/css/brands.css" integrity="sha384-BKw0P+CQz9xmby+uplDwp82Py8x1xtYPK3ORn/ZSoe6Dk3ETP59WCDnX+fI1XCKK" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.2/css/fontawesome.css" integrity="sha384-iD1qS/uJjE9q9kecNUe9R4FRvcinAvTcPClTz7NI8RI5gUsJ+eaeJeblG1Ex0ieh" crossorigin="anonymous">

  <title>@yield('title', config('app.name'))</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/"><img src="/img/chair.svg" width="50px" alt="POCA Recliner Logo">POCA Events</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
          aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/events">Upcoming</a>
      </li>
      {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">Pricing</a>--}}
      {{--</li>--}}
    </ul>
  </div>
</nav>
<div id="app" v-cloak>
  <main>
    @yield('content')
  </main>
</div>
<footer>
  <div class="container-fluid bg-secondary py-3">
    <div class="row m-3">
      <div class="col-md-4">
        <address>
          <strong>The People's Organization of Community Acupuncture</strong><br/>
          3526 NE 57th Ave.<br/>
          Portland, OR 97213<br/>
        </address>
        <p>
          <a href="mailto:events@pocacoop.com"><i class="far fa-link"></i> Contact the Events Circle!</a>
        </p>
      </div>
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <h4>Social</h4>
        <div class="">
          <span class="p-1"><a href="https://pocacoop.com/" title="pocacoop.com"><i class="far fa-globe-americas fa-2x"></i></a></span>
          <span class="p-1"><a href="https://facebook.com/groups/POCAChat/" title="Facebook"><i class="fab fa-facebook fa-2x"></i></a></span>
          <span class="p-1"><a href="https://instagram.com/pocacooperative/" title="Instagram"><i class="fab fa-instagram fa-2x"></i></a></span>
        </div>

      </div>
    </div>
  </div>
</footer>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>