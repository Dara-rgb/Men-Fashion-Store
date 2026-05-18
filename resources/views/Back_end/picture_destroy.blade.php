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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src=" {{ asset('../js_back_end/clothe.js') }}"></script>

</head>
    <script>
        // JavaScript to dynamically update the image when a caption is selected
        function updateImage() {
            const postId = document.getElementById('post-select').value;
            const imageElement = document.getElementById('post-image');
            const post = @json($post); // Pass PHP data to JavaScript

            const selectedPost = post.find(post => post.id == postId);
            if (selectedPost) {
                imageElement.src = `/storage/${selectedPost.image}`;
                imageElement.alt = selectedPost.caption;
            } else {
                imageElement.src = '';
                imageElement.alt = 'No image available';
            }
        }
        function contactImage() {
            const contactId = document.getElementById('contact-select').value;
            const imageElement = document.getElementById('contact-image');
            const contact = @json($contact); // Pass PHP data to JavaScript

            const selectedContact = contact.find(contact => contact.id == contactId);
            if (selectedContact) {
                imageElement.src = `/storage/${selectedContact.image_contact}`;
                imageElement.alt = selectedContact.link_payment;
            } else {
                imageElement.src = '';
                imageElement.alt = 'No image available';
            }
        }
    </script>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
            តើអ្នកពិតជាចង់លុបរូបភាពមែនទេ?
            </div>
            <div class="card-body">
                <form action="{{ route('Back_end.picture_delete', $pictures->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">រូបភាព</label>
                        <input type="file" name="image_picture[]" class="form-control input_search" id="exampleInputEmail1" aria-describedby="emailHelp" multiple>
                        @php
                                $images = json_decode($pictures->image_picture);
                        @endphp
                        @foreach($images as $image)
                            <img class="mt-2" src="{{ asset('storage/' . $image) }}" alt="" height="150" width="150">
                        @endforeach
                    </div>
                    
                    
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ការបង្ហោះ</label>
                        <!--<input type="text" name="clothe_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->

                        
                        <select name="post_id" class="form-control input_search" id="post-select" onchange="updateImage()">
                            
                            @foreach ($post as $st)
                                <option name="post_id" value="{{ $st->id }}">{{ $st->caption }}</option>
                            @endforeach
                        </select>
                            
                            <img class="mt-2" src="{{ asset('storage/' . $pictures->post->image) }}" alt="" height="150" width="150">
                        
                            
                        

                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">តំណរភ្ជាប់ទូទាត់ប្រាក់</label>
                        <!--<input type="text" name="clothe_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->

                        <select name="contact_id" class="form-control input_search" id="contact-select" onchange="contactImage()">
                            
                            @foreach ($contact as $st)
                                <option name="contact_id" value="{{ $st->id }}">{{ $st->name_contact }}</option>
                                
                            @endforeach
                        </select>
                            
                            <img class="mt-2" src="{{ asset('storage/' . $pictures->contact->image_contact) }}" alt="" height="150" width="150">
                        
                            

                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">ទំហំ</label>
                        <!--<input type="text" name="clothe_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">-->

                        <select name="size_id" class="form-control input_search" >
                            
                            @foreach ($sizes as $st)
                                <option name="size_id" value="{{ $st->id }}">{{ $st->text_size }}</option>
                                
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
</html>