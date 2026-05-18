<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men Fashion Store</title>
    <link rel="icon" href="{{ asset('img_back_end/Men_Fashion_Store.png') }}">    
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
</head>
<body>
    <div class="container-fluid bg_secondary w-25 position-fixed  sidebar-menu ">
        <div class="row mt-3 sticky-top bg_brandname " style="padding-bottom:18.5px;">
            <div class="col-12 ">
                <img class="rounded-circle logo_shadow"  src="{{ asset('img_back_end/Men_Fashion_Store.png') }}" alt="" width=80 height=80>
                <div class=" header_left ">
                    <h5>Men</h5>
                    <h6>Fashion Store</h6>
                </div>
            </div>
        </div>
        <ul class="list-unstyled text-center w-100 mt-1 ">
            
            <form class="form-inline mb-5 mt-4 sticky-top bg_search" action="{{ route('Back_end.search_clothe') }}" method="GET" style="top:95px;">
                 <input class="form-control mr-sm-2 mx-auto input_search" type="search" name="query" placeholder="ស្វែងរក" aria-label="Search" value="{{ request('query') }}">
                 <button class="btn btn-outline-light my-2 my-sm-0 mx-auto button-search" type="submit">ស្វែងរក</button>
            </form>
                
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.clothe')}}">សម្លៀកបំពាក់</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.category_clothe')}}">ប្រភេទសម្លៀកបំពាក់</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.category_fabric')}}">ប្រភេទសាច់ក្រណាត់</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.post')}}">ការបង្ហោះ</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.contact')}}">ទំនាក់ទំនង</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.size')}}">ទំហំ</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.picture')}}">រូបភាព</a></li>
            <li><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.Information_customer')}}">ព័ត៍មានអតិថិជន</a></li>
            <li class="type_bg_data"><a class="type_text_data text-decoration-none d-block py-3 " href="{{route('Back_end.announcement')}}">អក្សររត់</a></li>
            
        </ul>
    </div>
        <div class="container-fluid w-75 mr-0 ">

            <div class="row mb-2 sticky-top bg-data ">
                <div class="col-12">
                    <h2 class="mt-2 mb-3 dark">បញ្ជីអក្សររត់</h2>
                    <button class=" ml-2 btn-circle rounded-circle float-right" onclick="myFunction()" id="darkTheme" name="darkTheme"><i class="fas fa-sun "></i></button>
                    <button class=" ml-2 btn-circle rounded-circle float-right moon" onclick="myFunction()" id="darkTheme" name="darkTheme"><i class="fas fa-moon"></i></button>
                    @foreach ($admins as $st)
                        <a href="{{route('Back_end.index')}}"><img class=" ml-2 btn-circle-img rounded-circle float-right mr-5" src="{{ asset('storage/' . $st->picture_admin) }}" alt=""></a>    
                    @endforeach
                    <a class=" ml-2 btn-circle-img rounded-circle float-right mr-5 logout text-decoration-none" href="{{ route('Back_end.show_form_security') }}"> <i class="fas fa-user-lock"></i> </a>
                    <a href="{{route('Back_end.announcement_create')}}" class="text-decoration-none "><button class="btn btn-info text-btn" >បញ្ចូល</button> </a>
                    <a href="{{route('Back_end.announcement_alldestroy')}}" class="text-decoration-none "><button class="btn btn-warning text-btn" >លុបទាំងអស់</button> </a>
                </div>
            </div>
            <div class="row mt-1">
                @if (session('success'))

                    <div class="col-12 pl-0">
                        <div class="alert  alert-dismissible fade show pl-3" role="alert">
                            {{session()->get('success')}}
                        </div>
                    </div>
                @endif
            </div>
            
            <table class="table table-bordered mt-1 " >
                <thead class="sticky-top table-bg-color" style="top: 99.30px;">
                    <tr>
                        <th class="table-color-thead-r text-center" scope="col">លេខរៀង</th>
                        <th class="table-color-thead-r text-center" scope="col">អក្សររត់</th>
                        <th class="table-color-thead-r text-center" scope="col">បិត/បើក</th>
                        <th scope="col" colspan="2" class=" text-center table-color-thead-l">ប៊ូតុង</th>
                    </tr>
                </thead>
                <tbody>
                    <p hidden>{{$id = 1;}}</p>
                    @foreach ($announcements as $st)


                        <tr class="table-text-color">
                            <th class="table-color text-center" scope="row">{{$id++}}</th>
                            <td class="table-color text-center"> <a class="text-dark text-decoration-none" >{{$st->content}}</a> </td>
                            <td class="text-center table-color">
                                <form action="{{ route('Back_end.announcement_toggle', $st->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if($st->is_active)
                                        <button type="submit" class="btn btn-sm btn-primary" style="width: 80px;">កំពុងបើក</button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-secondary" style="width: 80px;">បានបិទ</button>
                                    @endif
                                </form>
                            </td>
                            <td class="text-center table-color" >
                                <a href="{{route('Back_end.announcement_edit',$st->id)}}"><button class="btn btn-sm btn-success  ">កែប្រែ</button></a>
                            </td>
                            <td class="text-center table-color" >
                                <a href="{{route('Back_end.announcement_destroy',$st->id)}}"><button class="btn btn-sm btn-danger  ">លុប</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>
</html>