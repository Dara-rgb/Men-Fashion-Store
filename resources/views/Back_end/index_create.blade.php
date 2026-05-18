<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men Fashion Store</title>
    <link rel="icon" href="{{ asset('img_back_end/Men_Fashion_Store.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('../css_back_end/clothe.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src=" {{ asset('../js_back_end/clothe.js') }}"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
            តើអ្នកគ្រប់គ្រងគេហទំព័រនេះជានរណា?
            </div>
            <div class="card-body">
                <form action="{{ route('Back_end.index_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ឈ្មោះអ្នកគ្រប់គ្រង</label>
                        <input type="text" name="name_admin" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">រូបភាពអ្នកគ្រប់គ្រង</label>
                        <input type="file" name="picture_admin" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp" onchange="previewImage(event)">
                        <img class="mt-2" id="preview" src="#" alt="" height="150" width="150">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">លេខទូរស័ព្ទអ្នកគ្រប់គ្រង</label>
                        <input type="text" name="phone_number_admin" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">គម្របរូបភាពអ្នកគ្រប់គ្រង</label>
                        <input type="file" name="cover_admin" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp" onchange="previewImageCover(event)">
                        <img class="mt-2" id="previewcover" src="#" alt="" height="150" width="150">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">អាស័យដ្ឋានអ្នកគ្រប់គ្រង</label>
                        <input type="text" name="address_admin" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">តំណរភ្ជាប់អាស័យដ្ឋាន</label>
                        <input type="text" name="link_map_admin" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                
                    <button id="ok-ok" type="submit" class="btn btn-primary">យល់ព្រម</button>
                </form>
                <button id="back-back" class="btn btn-dark" style="margin-top:-65px; margin-left:90px;" onclick="history.back()">ត្រឡប់ក្រោយ</button>
            </div>
        </div>
    </div>
</body>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.style.display = 'none';
            }
        }
        function previewImageCover(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewcover');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.style.display = 'none';
            }
        }
    </script>
</html>