<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Suhaim Soft Lab</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;0,800;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { display: flex; height: 100vh; overflow: hidden; background: #fff; }
        .left-panel {
            width: 50%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        }
        .right-panel {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 40px;
            overflow-y: auto;
        }
        
        .logo-box {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: #ffffff;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .title { font-size: 38px; font-weight: 800; letter-spacing: 2px; margin-bottom: 5px; z-index: 1; text-align: center; }
        .subtitle { font-size: 14px; font-weight: 600; letter-spacing: 4px; color: #bfdbfe; z-index: 1; text-transform: uppercase; }
        
        .login-form { width: 100%; max-width: 420px; }
        .form-header { margin-bottom: 30px; }
        .form-header h2 { font-size: 40px; font-weight: 800; color: #0f172a; line-height: 1.2; }
        .form-header h2 .highlight { color: #2563eb; }
        .gradient-line { width: 50px; height: 5px; background: #3b82f6; margin-top: 15px; border-radius: 4px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #718096;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 14px 20px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 15px;
            color: #1e293b;
            outline: none;
            transition: all 0.3s;
        }
        .form-group input:focus, .form-group select:focus { 
            border-color: #3b82f6; 
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); 
        }
        
        .text-danger { font-size: 12px; color: #e53e3e; font-weight: 600; margin-top: 6px; display: block; }
        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            text-transform: uppercase;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4); background: #1d4ed8; }
        
        .request-clearance {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            padding-bottom: 20px;
        }
        .request-clearance a { color: #2563eb; text-decoration: none; font-weight: 700; transition: color 0.3s; }
        .request-clearance a:hover { color: #1e3a8a; }
        
        @media (max-width: 768px) {
            body { flex-direction: column; overflow-y: auto; height: auto; }
            .left-panel, .right-panel { width: 100%; }
            .left-panel { height: 40vh; padding: 40px 0; border-bottom-left-radius: 30px; border-bottom-right-radius: 30px; }
            .right-panel { height: auto; padding: 30px 20px; }
            .logo-box { width: 80px; height: 80px; font-size: 35px; margin-bottom: 10px; }
            .title { font-size: 28px; }
            .form-header h2 { font-size: 32px; }
        }
    </style>
</head>
<body>

    <div class="left-panel">
        <div class="logo-box">
            <i class="fa-solid fa-flask"></i>
        </div>
        <div class="title">SUHAIM SOFT LAB</div>
        <div class="subtitle">Secure Control Panel</div>
    </div>

    <div class="right-panel">
        <div class="login-form">
            <div class="form-header">
                <h2>ACCESS<br><span class="highlight">PORTAL</span></h2>
                <div class="gradient-line"></div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Operator Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Operator ID</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="example@softlab.com">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••••••">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required placeholder="••••••••••••">
                </div>

                <div class="form-group">
                    <label for="role">Clearance Level</label>
                    <select id="role" name="role" required>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Laboratory Staff (Operational Hub)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Full Network Control)</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Register</button>

                <div class="request-clearance">
                    Already have clearance? <a href="{{ route('login') }}">Access Portal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>

