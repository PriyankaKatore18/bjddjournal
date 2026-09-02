<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login · BJJD Journal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #ffffff, #00004d);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      animation: fadeIn 0.6s ease-in-out;
      max-width: 600px; /* wider card */
      margin: auto;
    }

    .login-header {
      text-align: center;
      padding: 1.5rem 1rem 1rem;
      background: #00004d; /* dark blue header */
      border-bottom: 1px solid #003300;
      color: #ffffff;
    }

    .login-header img {
      width: 100px;
      margin-bottom: .5rem;
    }

    .btn-primary {
      background-color: #cc7a00;
      border-color: #cc7a00;
    }
    .btn-primary:hover {
      background-color: #003300;
      border-color: #003300;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
      <div class="card login-card">
        <div class="login-header">
          <img src="{{ asset('public/assets/img/logo.jpg') }}" alt="BJDD Logo" class="img-fluid" style="height:120px; width:150px; object-fit:contain;">
          <h5 class="mb-0 fw-semibold">Admin Login</h5>
          <small class="text-light">BJJD Journal Panel</small>
        </div>
        <div class="card-body p-4">
          @if ($errors->any())
            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
          @endif
          <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label text-dark">Email</label>
              <input type="email" name="email" class="form-control form-control-lg" 
                     value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3 position-relative">
              <label class="form-label text-dark">Password</label>
              <input type="password" name="password" id="password" class="form-control form-control-lg" required>
              <i class="bi bi-eye-slash password-toggle" id="togglePassword"></i>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label text-dark" for="remember">Remember me</label>
            </div>
            <button class="btn btn-primary w-100 btn-lg">Sign in</button>
          </form>
        </div>
      </div>
      <p class="text-center mt-3 text-muted small">© {{ date('Y') }} BJJD Journal</p>
    </div>
  </div>
</div>

<script>
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");

  togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // toggle eye / eye-slash icon
    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });
</script>
</body>
</html>
