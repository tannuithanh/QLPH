<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hệ thống Portal - Công ty TNHH Vinh Gia</title>
  <link rel="stylesheet" href="style.css">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    .login-page {
      height: 100%;
      background: url('images/Login.jpg') no-repeat center center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .auth-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      max-width: 360px;
      width: 100%;
      padding: 40px;
      backdrop-filter: blur(6px);
    }

    .right-panel {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-header img {
      height: 100px;
      margin: 0 auto 16px auto;
      display: block;
    }

    .title-text {
      text-align: center;
      font-size: 20px;
      font-weight: 700;
      color: #2b354f;
      text-transform: uppercase;
      margin-bottom: 24px;
    }

    input {
      width: 100%;
      padding: 12px 14px;
      margin-top: 16px;
      border: 1px solid #dce3ee;
      border-radius: 8px;
      font-size: 15px;
      background-color: #f9fafb;
    }

    .login100-form-btn {
      width: 100%;
      margin-top: 24px;
      padding: 12px;
      background-color: #C06252; /* màu chủ đạo */
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }

    form input,
    form button {
      width: 100%;
      max-width: 280px;
      box-sizing: border-box;
    }

    .alert-danger {
      background-color: #fee2e2;
      color: #b91c1c;
      padding: 12px;
      margin-top: 20px;
      border-radius: 8px;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="login-page">
  <div class="auth-container">
    <div class="right-panel">
      <div class="login-header">
        <img src="{{asset('images/login.png')}}" alt="Logo" />
        <div class="title-text">LỊCH HỌP ĐIỆN TỬ</div>
      </div>

      <form action="" method="POST">
        @csrf
        <input type="email" name="mail" placeholder="Email đăng nhập" required />
        <input type="password" name="pass" placeholder="Mật khẩu" required />
        <button class="login100-form-btn" type="submit">Đăng nhập</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
