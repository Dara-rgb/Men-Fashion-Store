<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men Fashion Store</title>
	<link rel="icon" href="{{ asset('img_back_end/Men_Fashion_Store.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('../css_front_end/clothe.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src=" {{ asset('../js_front_end/clothe.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>
<body>
    <div class="navbar navbar-expand-lg navbar-light bg_secondary container-fluid sticky-top shadow-sm">
		<img style="margin-top:-15px;" class="rounded-circle logo_shadow"  src="{{ asset('img_back_end/Men_Fashion_Store.png') }}" alt="" width=80 height=80>
        <h6 class="navbar-brand brand-title  mt-2" href="#">Men fashion store</h6>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars custom-toggler-icon"></i>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            
            <form class="form-inline my-2 my-lg-0 ml-auto mr-0" action="{{ route('Front_end.search') }}" method="GET">
                <input class="form-control mr-sm-2 input_search" type="search" placeholder="ស្វែងរក" aria-label="Search" name="query" value="{{ request('query') }}">
                <button class="btn btn-outline-light my-2 my-sm-0 button-search mr-1" type="submit">ស្វែងរក</button>
				<button type="button" id="view-selected" class="btn my-2 my-sm-0 button-search show_img"  disabled>
					<i class="fas fa-images"></i> <span class="img_img">មើលរូបភាព</span> <span>(</span><span id="selected-count">0</span><span>)</span>
				</button>
            </form>
            <button class=" ml-2 rounded-circle btn-circle-new sun-new" onclick="myFunction()" id="darkTheme" name="darkTheme"><i class="fas fa-sun "></i></button>
			<button class=" ml-2 rounded-circle btn-circle-new moon-new" onclick="myFunction()" id="darkTheme" name="darkTheme"><i class="fas fa-moon"></i></button>
        </div>
    </div>
    
    @foreach ($announcements as $announcement)
		<marquee class="pt-1 announcement" behavior="scroll" direction="left" scrollamount="15" onmouseover="this.stop();" onmouseout="this.start();">
					{{$announcement->content}}
		</marquee>
	@endforeach
    
	
	<div class="container-fluid Margin_top_clothe">
		<div class="container p-1 ">
						
									<div class="row ">
										<div class="col-12 p-1">
											<p class="tag ml-0">{{$category_fabrics->text_fabrics}}</p>
											<a class="continue" onclick="history.back()" >ត្រឡប់ក្រោយ</a>
										</div>
									</div>
									
									
									<div class="row mb-4 " dir="ltr">
											@foreach ($post as $st)
												<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mt-0 p-1 card_skip ">
                                                    <a href="{{route('Front_end.picture',['id' => $st->id])}}">
                                                        <div class="post position-relative">
															<input type="checkbox" class="post-checkbox" value="{{ $st->id }}"  style="position: absolute; top: 10px; left: 10px; z-index: 10; width: 20px; height: 20px;">
																<figure>
																		<img src="https://ychsunvttdsjtwonmqpy.supabase.co/storage/v1/object/public/products/{{ basename($st->image) }}"  class="img-fluid card-img-top" alt="...">																																																							
																		
																		<div class="right-right">
																																						
																			<p class="price">{{$st->price}}$</p>
																		</div>
																</figure>
																<div class="card-body " dir="ltr">
																		<div class="type">
																			<h6>{{$st->brand}}</h6>
																			<p class="float-right">{{$st->category_clothe->text_clothes}}</p>
																		</div>
																		<div  class="card-text">
																			<p>{{$st->caption}}</p>
																		</div>
																		<div class="card-model">
																			<h6>{{$st->category_fabric->text_fabrics}}</h6>
																			<span  class="float-right ml-0">{{$st->view}}<i class="fas fa-eye"></i></span>
																		</div>
																</div>
																<div class="card-footer">
																		<small class="text-muted"><p>{{$st->created_at}}</p></small>
																		
																</div>
														</div>
                                                    </a>
												</div>
											@endforeach
									</div>
									
						
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
$(document).ready(function() {
    // ១. ប្រកាស Variable ឱ្យស្គាល់ Element នីមួយៗ
    const viewBtn = $('#view-selected');
    const countSpan = $('#selected-count');
    const checkboxes = $('.post-checkbox');

    // ២. ចាប់ព្រឹត្តិការណ៍ពេល Checkbox មានការប្រែប្រួល (Tick ឬ ដក Tick)
    // ចាប់ព្រឹត្តិការណ៍ពេល Checkbox មានការប្រែប្រួល
    checkboxes.on('change', function() {
        const selectedCount = $('.post-checkbox:checked').length;
        countSpan.text(selectedCount); // បង្ហាញចំនួនលេខ

        if (selectedCount > 0) {
            // ប្រសិនបើមានការជ្រើសរើស៖ អនុញ្ញាតឱ្យចុច
            viewBtn.prop('disabled', false);
            viewBtn.addClass('blue_primary').removeClass('gray_secondary'); 
        } else {
            // ប្រសិនបើគ្មានការជ្រើសរើស៖ មិនឱ្យចុច
            viewBtn.prop('disabled', true);
            viewBtn.addClass('gray_secondary').removeClass('blue_primary');
        }
    });

    // ៣. ការពារការលោតទៅកាន់ Link ពេលចុចលើ Checkbox (ទប់ស្កាត់ Bubbling)
    checkboxes.on('click', function(e) {
        e.stopPropagation(); 
    });

    // ៤. កូដសម្រាប់បញ្ជូនទៅកាន់ URL ពេលចុចប៊ូតុង "មើលរូបភាពដែលបានជ្រើសរើស"
    viewBtn.on('click', function() {
        const selectedIds = $('.post-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (selectedIds.length > 0) {
            let url = "{{ route('Front_end.picture', ['id' => 'id_here']) }}";
            url = url.replace('id_here', selectedIds.join(','));
            window.location.href = url;
        }
    });
});
</script>
</html>

