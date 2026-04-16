<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Suhaim Soft Lab</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;0,800;1,700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { display: flex; height: 100vh; overflow: hidden; background: #fff; }
        .left-panel {
            width: 50%;
            background: linear-gradient(135deg, #2b1d6f 0%, #b8227b 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 20px;
            position: relative;
        }
        .logo-box span:nth-child(1) { color: #f52988; }
        .logo-box span:nth-child(2) { color: #1f1140; }
        .logo-dot {
            width: 4px;
            height: 4px;
            background: #f52988;
            border-radius: 50%;
            position: absolute;
            left: -15px;
            bottom: 20px;
        }
        
        .title { font-size: 42px; font-weight: 800; letter-spacing: 1px; margin-bottom: -5px; }
        .subtitle { font-size: 14px; font-weight: 700; font-style: italic; letter-spacing: 2px; color: rgba(255,255,255,0.8); }
        
        .login-form { width: 100%; max-width: 400px; }
        .form-header { margin-bottom: 40px; }
        .form-header h2 { font-size: 42px; font-weight: 800; color: #1a202c; line-height: 1.1; }
        .form-header h2 .highlight { color: transparent; background: linear-gradient(90deg, #7c3aed, #d946ef); -webkit-background-clip: text; }
        .gradient-line { width: 40px; height: 4px; background: linear-gradient(90deg, #7c3aed, #d946ef); margin-top: 10px; border-radius: 2px; }
        
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
            background: #f0f5ff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            color: #1a202c;
            outline: none;
            transition: all 0.3s;
        }
        .form-group input:focus, .form-group select:focus { box-shadow: 0 0 0 2px #d946ef; }
        
        .text-danger { font-size: 12px; color: #e53e3e; font-weight: 600; margin-top: 6px; display: block; }
        
        .stay-active { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .stay-active input { width: 18px; height: 18px; accent-color: #d946ef; border-radius: 4px; border: none; background: #f0f5ff; }
        .stay-active label { font-size: 11px; font-weight: 700; color: #a0aec0; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; }
        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(90deg, #9b2add, #df2a82);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            cursor: pointer;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(223, 42, 130, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 15px 25px rgba(223, 42, 130, 0.3); }
        
        .request-clearance {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #a0aec0;
            text-transform: uppercase;
        }
        .request-clearance a { color: #8b5cf6; text-decoration: none; transition: color 0.3s; }
        .request-clearance a:hover { color: #d946ef; }
        
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel, .right-panel { width: 100%; }
            .left-panel { height: 30vh; }
            .right-panel { height: 70vh; padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="left-panel">
        <div class="logo-box">
            <div class="logo-dot"></div>
            <span>S</span><span>S</span><span>L</span>
        </div>
        <div class="title">SUHAIM SOFT LAB</div>
        <div class="subtitle">SUHAIM SOFT LAB</div>
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
                    <label for="role">System Role</label>
                    <select id="role" name="role" required style="width: 100%; padding: 14px 20px; background: #f0f5ff; border: none; border-radius: 12px; font-size: 14px; outline: none; margin-bottom: 10px;">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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

