<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file -->
    <style>
       /* Background overlay */
        #otpModal {
            display: none; /* hidden by default */
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        /* Popup box */
        #otpModalContent {
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            width: 100%;
            max-width: 350px;
            text-align: center;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.2);
            animation: fadeInScale 0.3s ease-in-out;
        }
        
        /* Title */
        #otpModalContent h4 {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        
        /* Input */
        #otpModalContent input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            outline: none;
            transition: 0.2s;
        }
        
        #otpModalContent input[type="text"]:focus {
            border-color: #007BFF;
            box-shadow: 0px 0px 5px rgba(0,123,255,0.3);
        }
        
        /* Button */
        #otpModalContent button {
            width: 100%;
            padding: 12px;
            background: #007BFF;
            border: none;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        #otpModalContent button:hover {
            background: #0056b3;
        }
        
        /* Error message */
        #otpError {
            color: red;
            margin-top: 10px;
            font-size: 13px;
        }
        
        /* Popup animation */
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('assets_rise/img/logo/logo.png') }}" alt="Logo" height="100" style="display: block; margin: 0 auto;">
        <h2>Admin Login</h2>
        <p>Please fill in your credentials to login.</p>
       <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control">
                @error('username')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>

   <!-- OTP Modal -->
    <!--<div id="otpModal">-->
    <!--    <div id="otpModalContent">-->
    <!--        <h4>Enter OTP</h4>-->
    <!--        <input type="text" id="otpInput" placeholder="Enter OTP" autocomplete="off">-->
    <!--        <input type="hidden" id="adminId">-->
    <!--        <button id="verifyOtpBtn">Verify OTP</button>-->
    <!--        <p id="otpError" style="color:red;"></p>-->
    <!--    </div>-->
    <!--</div>-->

    </div>

    <style>
        /* Reset basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Body and page background */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        /* Login container */
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        /* Heading */
        .login-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        /* Submit button */
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;

        }
    </style>


<script>
//     document.getElementById('loginForm').addEventListener('submit', function(e){
//         e.preventDefault();
//         let formData = new FormData(this);
    
//         fetch(this.action, { method: 'POST', body: formData })
//         .then(res => res.json())
//         .then(res => {
//             if(res.status === 200 && res.admin_id){
//                 // Open OTP popup
//                 const modal = document.getElementById('otpModal');
//                 modal.style.display = 'flex'; // <-- fixed here
//                 document.getElementById('adminId').value = res.admin_id;
//             } else if(res.status === 200){
//                 // Non super-admin: redirect
//                 window.location.href = "{{ route('admin.dashboard') }}";
//             } else {
//                 alert(res.message || 'Login failed');
//             }
//         })
//         .catch(err => console.error(err));
//     });
    
//     document.getElementById('verifyOtpBtn').addEventListener('click', function(){
//         let otp = document.getElementById('otpInput').value.trim();
//         let adminId = document.getElementById('adminId').value;
    
//         fetch("/admin/verify-otp", {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                 'Content-Type': 'application/json',
//                 'Accept': 'application/json'
//             },
//             body: JSON.stringify({ otp: otp, admin_id: adminId }),
//             credentials: 'same-origin' // important to persist session cookie
//         })
//         .then(res => res.json())
//         .then(res => {
//             if (res.status === 200) {
//                 // ✅ use backend redirect
//                 window.location.href = res.redirect;
//             } else {
//                 document.getElementById('otpError').innerText = res.message;
//             }
//         })
//         .catch(err => console.error('OTP verify error:', err));
//     });





</script>

</body>

</html>