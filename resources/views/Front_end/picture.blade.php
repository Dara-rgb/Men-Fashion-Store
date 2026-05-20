<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men Fashion store</title>
    <link rel="icon" href="{{ asset('img_back_end/Men_Fashion_Store.png') }}">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('../css_front_end/picture.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src=" {{ asset('../js_front_end/clothe.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>

<body>


<div class="container-fluid sticky-top bg_header_picture mt-5">
		<div class="container   p-1">
									<div class="row">
										<div class="col-12 p-1 margine_top">
                                            
                                            <button onclick="submitMyForm()" type="submit" class="btn tags ml-0 float-left" style="font-family: 'Preahvihear', sans-serif; ">
                                                <i class="fas fa-shopping-cart"></i> ចុចទិញ
                                            </button>
											<a  style="margin-top:15px;" class="back" onclick="history.back()" >ត្រឡប់ក្រោយ</a>
                                            
										</div>
									</div>
		</div>
</div>
<div class="container-fluid ">
    <div class="container p-1 mt-5 ">
						
                        
						<div class="row mb-3">
                            @foreach($post as $pos)
                                <div class="col-12 mb-3 p-1">
                                    <div class="card_caption">
                                        
                                        <div class="card-body bg_gray" dir="ltr">
												<div class="type">
													<h6>{{$pos->brand}}</h6>
													<p class="float-right ">{{$pos->category_clothe->text_clothes}}</p>
												</div>
												<div  class="card-text">
													<p>{{$pos->caption}}</p>
												</div>
												<div class="card-model">
													<h6>{{$pos->category_fabric->text_fabrics}}</h6>
													<span  class="float-right ml-0">{{$pos->view}}<i class="fas fa-eye"></i></span>
												</div>
										</div>
                                        <div class="card-footer">
												<small class="text-muted"><p>{{$pos->created_at}}</p></small>
										</div>
                                        
                                    </div>
                                </div>
                                <div class="col-12 p-1">
                                    <div class="post_img">
                                        <figure>
												<img src="{{ asset('storage/' . $pos->image) }}"  class="img-fluid card-img-top" alt="...">																																																							
										</figure>
                                        
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form id="purchase-form" action="{{ route('Front_end.customer_identity_multiple') }}" method="POST">
                        @csrf
                            <div class="row ">
                                @foreach ($pictures as $st)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mt-0 p-1">
                                        <div class="card ">
                                            <div style="position: absolute; top: 10px; left: 10px; z-index: 10;">
                                                <input type="checkbox" name="selected_items[]" value="{{ $st->id }}" style="transform: scale(1.5);">
                                            </div>
                                            <figure>
                                                @php
                                                    
                                                    preg_match_all('/[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)/i', $st->image_picture, $matches);
                                                    
                                                    
                                                    $images = isset($matches[0]) ? $matches[0] : [];
                                                @endphp
                                                
                                                @if(is_array($images) && count($images) > 0)
                                                    @foreach($images as $image)
                                                        @php
                                                            $supabaseUrl = "https://ychsunvttdsjtwonmqpy.supabase.co/storage/v1/object/public/products/" . $image;
                                                        @endphp
                                                        <img loading="lazy" src="{{ $supabaseUrl }}"  class="img-fluid card-img-top" alt="..." onclick="showImage('{{ asset('storage/' . $image) }}')" style="cursor: pointer;">
                                                        <div id="imageModal">
                                                            <span onclick="closeImage()">&times;</span>
                                                            <img id="modalImg">
                                                        </div>
                                                        <div class="right-right">
                                                                                                                                                                
                                                            <p class="price">{{$st->post->price}}$</p>
                                                        </div>
                                                    @endforeach																																																						
                                                 @else
                                                        {{-- បើផលិតផលនោះគ្មានរូបភាពច្រើនសន្លឹកទេ គឺឱ្យវាបង្ហាញរូបភាពជំនួស ឬទុកទទេ --}}
                                                        <p class="text-muted">No multiple images available</p>
                                                @endif                       
                                                    
                                            </figure>
                                            <div class="card-body card_margine_bottom" dir="ltr">
                                                    <div class="type mt-3">
                                                        <h6>{{$st->size->text_size}}</h6>
                                                    </div>
                                                    
                                            </div>
                                            <div class="card-footer">
                                                    <small class="text-muted"><p>{{$st->created_at}}</p></small>
                                                    <div class="float-right buy_skip">
                                                        <a href="{{route('Front_end.customer_identity',['id' => $st->id])}}"><p class="buy"></p></a>
                                                    </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
						
    </div>
</div>

<div class="container-fluid in_footer py-4">
		<div class="row align-items-center">
			<!-- ផ្នែកទីតាំង -->
			<div class="col-md-4 footer-item">
				@foreach ($admins as $admin)
					<div class="d-flex align-items-center justify-content-center mb-2">
						<div class="icon-box mr-3">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<div class="text-left">
							<span class="d-block label-footer">ទីតាំង</span>
							<a class="text-decoration-none" href="{{$admin->link_map_admin}}"><span class="value-footer">{{$admin->address_admin}}</span></a>
						</div>
					</div>
				@endforeach
			</div>

			<!-- ផ្នែក Logo កណ្តាល -->
			<div class="col-md-4 text-center mb-4 mb-md-0">
				<div class="footer-logo-wrapper">
					<img src="{{ asset('img_back_end/Men_Fashion_Store.png') }}" alt="Logo" class="footer-logo logo_shadow">
				</div>
			</div>

			<!-- ផ្នែកលេខទូរស័ព្ទ -->
			<div class="col-md-4 footer-item">
				@foreach ($admins as $admin)
					<div class="d-flex align-items-center justify-content-center mb-2">
						<div class="icon-box mr-3">
							<i class="fas fa-phone-alt"></i>
						</div>
						<div class="text-left">
							<span class="d-block label-footer">ទំនាក់ទំនង</span>
							<span class="value-footer">{{$admin->phone_number_admin}}</span>
						</div>
					</div>
				@endforeach
			</div>
		</div>
</div>
				

</body>
<script>
function showImage(src) {
    document.getElementById("modalImg").src = src;
    document.getElementById("imageModal").style.display = "block";
}

function closeImage() {
    document.getElementById("imageModal").style.display = "none";
}

function submitMyForm() {
    // ឆែកមើលថា តើមានបាន Check លើទំនិញខ្លះហើយឬនៅ?
    var checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
    
    if (checkboxes.length > 0) {
        document.getElementById('purchase-form').submit();
    } else {
        alert("សូមជ្រើសរើសទំនិញយ៉ាងតិចមួយ មុននឹងចុចទិញ!");
    }
}
</script>
</html>