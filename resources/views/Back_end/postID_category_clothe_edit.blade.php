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
            តើអ្នកពិតជាចង់កែប្រែការបង្ហោះមែនទេ?
            </div>
            <div class="card-body">
                <form action="{{ route('Back_end.postID_category_clothe_update' , $post->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ខ្លឹមសារ</label>
                        <input value="{{$post->caption}}" type="text" name="caption" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">រូបភាព</label>
                        <input value="{{ asset('storage/' . $post->image) }}" type="file" name="image" class="form-control mb-2 input_search" id="exampleInputEmail1" aria-describedby="emailHelp" onchange="previewImage(event)">
                        <p class="mt-3">រូបចាស់</p>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="" height="150" width="150">
                        <p style="float:right; margin-top:-40px;">រូបថ្មី</p>
                        <img style="float:right; margin-top:-1.5px; margin-right:-10px;"  id="preview" src="#" alt="" height="150" width="150">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">តម្លៃ</label>
                        <input value="{{$post->price}}"  type="number" step="0.01"  placeholder="$.$$" name="price" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ម៉ាក</label>
                        <input value="{{$post->brand}}" type="text" name="brand" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ប្រភេទសម្លៀកបំពាក់</label>
                        <!--<input type="text" name="clothe_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->

                        
                            <select class="form-control input_search" name="category_clothe_id" id="exampleInputEmail1" aria-describedby="emailHelp">
                            
                                
                                    <option name="category_clothe_id" value="{{$category_clothes->id}}">{{$category_clothes->text_clothes}}</option>
                                
                            
                            </select>
                        

                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ប្រភេទសាច់ក្រណាត់</label>
                        <!--<input type="text" name="clothe_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->

                        <select class="form-control input_search" name="category_fabric_id" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @foreach ($category_fabrics as $st)
                            <option name="category_fabric_id" value="{{$st->id}}">{{$st->text_fabrics}}</option>
                        @endforeach
                        </select>

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
    </script>
</html>