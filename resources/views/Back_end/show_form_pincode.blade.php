<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pincode - Men Fashion Store</title>
    <link rel="icon" href="{{ asset('img_back_end/Men_Fashion_Store.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('../css_back_end/clothe.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src=" {{ asset('../js_back_end/clothe.js') }}"></script>
    <style>
        body { background: #f4f4f4; font-family: 'Hanuman', serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 35px; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); width: 380px;  position: relative; }
        
        .store-name { text-align: center; margin-bottom: 5px; }
        .store-name h1 { font-size: 17.5px; color: #323232; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .store-name p { font-size: 12px; color: #ff0000; margin-bottom: 20px; font-weight: bold; }
        
        h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid rgb(50,50,50); padding-bottom: 10px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; font-size: 14px; color: rgb(50,50,50); font-weight: 500; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; outline: none; transition: 0.3s; font-size: 15px; }
        input:focus { border-color: #ff0000; box-shadow: 0 0 5px rgba(50,50,50,0.1); }
        input::placeholder{color:rgb(50, 50, 50); opacity:0.5;}
        
        .btn { width: 100%; padding: 13px; background: #323232; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; margin-top: 10px; font-size: 16px; text-transform: uppercase; }
        .btn:hover { background: #ff0000; box-shadow: 0 5px 15px rgba(255,0,0,0.2); }
        
        .error-msg { color: red; font-size: 13px; margin-bottom: 15px; text-align: center; background: #fff5f5; padding: 10px; border-radius: 4px; border: 1px solid #ffebeb; }
        
        /* កែពណ៌ពេល Browser បំពេញឱ្យអូតូ (Autofill) */
        
        .form-group .fa-eye{color:rgb(50,50,50);}
        .four_corner{border:1px solid rgb(50,50,50)}
        .four_corner:-webkit-autofill,
        .four_corner:-webkit-autofill:focus,
        .four_corner:-webkit-autofill:hover,
        .four_corner:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;  /* keep black background */
            -webkit-text-fill-color: rgb(50, 50, 50) !important;               /* change autofilled text color */
                                        /* optional: white border on focus */
            outline: 3px solid white;
            caret-color: rgb(50,50,50);                                      /* optional: caret color */
            border: 1px solid red;
        }
        .dark-mode  .store-name h1 { font-size: 17.5px; color: white; margin: 0; text-transform: uppercase; letter-spacing: 1px; }{}
        .dark-mode .box { background: rgb(50,50,50); padding: 35px; border-radius: 12px; box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1); width: 380px;  position: relative; }
        .dark-mode h2 { text-align: center; color: white; margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid white; padding-bottom: 10px; }
        .dark-mode label { display: block; margin-bottom: 8px; font-size: 14px; color: white; font-weight: 500; }
        .dark-mode input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; outline: none; transition: 0.3s; font-size: 15px; background-color:rgb(50,50,50); color:white}
        .dark-mode input:focus { border-color: #ff0000; box-shadow: 0 0 5px rgba(255,255,255,0.1); }
        .dark-mode input::placeholder{color:white; opacity:0.5;}
        .dark-mode  .btn { width: 100%; padding: 13px; background: white; color: rgb(50,50,50); border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; margin-top: 10px; font-size: 16px; text-transform: uppercase; }
        .dark-mode .btn:hover { background: #ff0000; box-shadow: 0 5px 15px rgba(255,0,0,0.2); color: white;}

        .dark-mode .form-group .fa-eye{color:white;}
        .dark-mode .four_corner{border:1px solid white}
        .dark-mode .four_corner:-webkit-autofill,
        .dark-mode .four_corner:-webkit-autofill:focus,
        .dark-mode .four_corner:-webkit-autofill:hover,
        .dark-mode .four_corner:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgb(50,50,50) inset !important;  /* keep black background */
            -webkit-text-fill-color: white !important;               /* change autofilled text color */
                                        /* optional: white border on focus */
            outline: 3px solid rgb(50,50,50);
            caret-color: white;                                      /* optional: caret color */
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="store-name">
            <img class="rounded-circle logo_shadow" 
             src="{{ asset('img_back_end/Men_Fashion_Store.png') }}" 
             alt="Logo" width="80" height="80" 
             style="margin-bottom: 15px;">
            <h1>Men Fashion Store</h1>
            <p>STORE MANAGEMENT</p>
        </div>

        <h2>បញ្ជាក់ PinCode</h2>

        <!-- បង្ហាញ Error -->
        @if ($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('Back_end.verify_pincode') }}" method="POST">
            @csrf
            
            <!-- ១. ប្រអប់ឈ្មោះ -->
            

            <!-- ២. ប្រអប់លេខទូរស័ព្ទ -->
            <div class="form-group">
                <label><i class="fab fa-telegram-plane"></i> PinCode</label>
                <input class="four_corner" type="text" name="otp" required placeholder="បញ្ចូលលេខកូដ6ខ្ទង់" value="{{ old('phone_number') }}">
            </div>

            <!-- ៣. ប្រអប់ពាក្យសម្ងាត់ -->
            

            <button type="submit" class="btn">បញ្ជាក់</button>
        </form>
        <button id="back-back" class="btn btn-dark d-flex justify-content-center" style="margin-top:5px; " onclick="history.back()">ត្រឡប់ក្រោយ</button>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePasswordLogin');
        const password = document.querySelector('#password_login');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // ប្តូររូបតំណាងភ្នែក
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
            
            // ប្តូរពណ៌ពេលបើកមើល
            const isDark = document.body.classList.contains('dark-mode');
            this.style.color = type === 'text' ? '#ff0000' : (isDark ? 'white' : 'rgb(50,50,50)');
        });
    </script>
</body>
</html>