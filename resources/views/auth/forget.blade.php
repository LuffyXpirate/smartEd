<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Forget Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="AdminLTE 4 | Login Page v2">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard with 30 example pages using Vanilla JS.">
  <meta name="keywords" content="bootstrap 5, admin dashboard, vanilla js, adminlte, colorlibhq">

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous">

  <!-- Third-Party Plugins -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous">

  <!-- AdminLTE Styles -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.css">
</head>
<body class="login-page bg-body-secondary">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
          <h1 class="mb-0"><b>Forget Password</b></h1>
        </a>
      </div>
      <div class="card-body login-card-body">
        @include('message')
        <form action="" method="post">
          @csrf
          <div class="input-group mb-3">
            <div class="form-floating">
              <input id="loginEmail" type="email" class="form-control" name="email" placeholder="Enter your email" required>
              <label for="loginEmail">Email</label>
            </div>
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
          </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary w-100" ">Forget</button>
            </div>
            <br>
            <p class="mb-1">
                <a href="{{ url('login') }}">Login</a>
              </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="{{ url('public/dist/js/adminlte.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const sidebarWrapper = document.querySelector('.sidebar-wrapper');
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: 'os-theme-light',
            autoHide: 'leave',
            clickScroll: true,
          },
        });
      }
    });
  </script>
</body>
</html>
