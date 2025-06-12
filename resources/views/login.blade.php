<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rumah Makan Podomoro</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('css/styles.min.css')}}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM6g0g5z5e5e5e5e5e5e5e5e5e5e5e5e5e5e5" crossorigin="anonymous" />
  <style>
    body {
      background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .form-label {
      font-weight: bold;
    }

    .btn-primary {
      background-color: #ffb703;
      border: none;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: #fb8500;
    }

    .error-message {
      color: red;
      margin-bottom: 15px;
    }

    .welcome-message {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>

<body>
  <!-- Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{asset('images/logos/mukena.PNG')}}" width="180" alt="">
                </a>

                <!-- Welcome Message -->
                <div class="welcome-message">
                  Selamat Datang di Rumah Makan Podomoro!
                </div>

                <!-- Alert for errors -->
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">Username</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your username">
                    </div>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4 rounded-2">Login</button>
          
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>
