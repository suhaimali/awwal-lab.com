<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Suhaim Soft Lab</title>
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
        .form-header { margin-bottom: 40px; }
        .form-header h2 { font-size: 40px; font-weight: 800; color: #0f172a; line-height: 1.2; }
        .form-header h2 .highlight { color: #2563eb; }
        .gradient-line { width: 50px; height: 5px; background: #3b82f6; margin-top: 15px; border-radius: 4px; }
        
        .form-group { margin-bottom: 25px; }
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
            padding: 16px 20px;
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
        
        .stay-active { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .stay-active input { width: 18px; height: 18px; accent-color: #3b82f6; border-radius: 4px; border: none; }
        .stay-active label { font-size: 12px; font-weight: 600; color: #64748b; letter-spacing: 0.5px; cursor: pointer; }
        
        .btn-submit {
            width: 100%;
            padding: 18px;
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
        }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4); background: #1d4ed8; }
        
        .request-clearance {
            text-align: center;
            margin-top: 35px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
        }
        .request-clearance a { color: #2563eb; text-decoration: none; font-weight: 700; transition: color 0.3s; }
        .request-clearance a:hover { color: #1e3a8a; }
        
        @media (max-width: 768px) {
            body { flex-direction: column; overflow-y: auto; }
            .left-panel, .right-panel { width: 100%; }
            .left-panel { height: 40vh; border-bottom-left-radius: 30px; border-bottom-right-radius: 30px; }
            .right-panel { height: auto; min-height: 60vh; padding: 30px 20px; }
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

            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; border-left: 4px solid #10b981;">
                    <svg style="width: 20px; height: 20px; margin-right: 10px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Operator ID</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="example@softlab.com">
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
                    <label for="role">Clearance Level</label>
                    <select id="role" name="role" required>
                        <option value="admin">Administrator (Full Network Control)</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Laboratory Staff (Operational Hub)</option>
                    </select>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="show-password" style="width: 15px; height: 15px; margin: 0; cursor: pointer;" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
                    <label for="show-password" style="margin: 0; text-transform: none; color: #718096; font-size: 11px; cursor: pointer;">
                        Show password
                    </label>
                </div>


                <button type="submit" class="btn-submit">Authenticate</button>

                <div class="request-clearance">
                    New Operator? <a href="{{ route('register') }}">Register</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>

