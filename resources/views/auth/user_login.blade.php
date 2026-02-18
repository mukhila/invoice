<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldSaver App - Secure Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .auth-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        .brand-logo {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #d4a017; /* Gold color */
        }
        .brand-logo i {
            font-size: 3rem;
        }
        .nav-pills .nav-link {
            border-radius: 50px;
            color: #6c757d;
            font-weight: 600;
        }
        .nav-pills .nav-link.active {
            background-color: #d4a017;
            color: white;
        }
        .form-control:focus {
            border-color: #d4a017;
            box-shadow: 0 0 0 0.25rem rgba(212, 160, 23, 0.25);
        }
        .btn-gold {
            background-color: #d4a017;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            background-color: #b88a12;
            transform: translateY(-2px);
        }
        .input-group-text {
            background: #fff;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        /* Fix for left border on focus */
        .input-group:focus-within .input-group-text {
            border-color: #d4a017;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="brand-logo">
        <i class='bx bxs-diamond'></i>
        <h4 class="mt-2 fw-bold text-dark">GoldSaver App</h4>
    </div>

    <ul class="nav nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="true">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="false">Register</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- Login Form -->
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
            <div class="text-center mb-4">
                <h5 class="fw-bold">Welcome Back</h5>
                <p class="text-muted small">Access your gold savings securely</p>
            </div>
            
            <form action="{{ route('user.login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small text-muted">Mobile Number</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class='bx bx-mobile'></i></span>
                        <input type="text" class="form-control" name="mobile" placeholder="+91 98765 43210" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small text-muted">Date of Birth</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class='bx bx-calendar'></i></span>
                        <input type="date" class="form-control" name="dob" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold mb-3">Secure Login</button>
            </form>
        </div>

        <!-- Register Form -->
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
            <div class="text-center mb-4">
                <h5 class="fw-bold">Create Account</h5>
                <p class="text-muted small">Start your gold savings journey</p>
            </div>

            <form action="{{ route('user.register.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small text-muted">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class='bx bx-user'></i></span>
                        <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Email Address (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class='bx bx-envelope'></i></span>
                        <input type="email" class="form-control" name="email" placeholder="john@example.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Mobile Number</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class='bx bx-mobile'></i></span>
                        <input type="text" class="form-control" name="mobile" placeholder="+91 98765 43210" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small text-muted">Date of Birth</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class='bx bx-calendar'></i></span>
                        <input type="date" class="form-control" name="dob" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold mb-3">Create Account</button>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-3">
        <small class="text-muted">By continuing, you agree to our Terms & Conditions</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
