<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Men Fashion Store</title>
    <link rel="icon" href="{{ asset('img_back_end/Men_Fashion_Store.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="{{ asset('../css_front_end/clothe.css') }}">
    <link rel="stylesheet" href="{{ asset('../css_front_end/qr_code.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">
    <script src=" {{ asset('../js_front_end/clothe.js') }}"></script>


    <style>
        .qr-container { margin-top: 50px; padding: 30px; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .bakong-logo { max-width: 150px; margin-bottom: 20px; }
        #status-alert { font-weight: bold; }
    </style>
</head>
<body class=" text-center">
@extends('layouts.app')

@section('title', 'Bakong Payment')
@section('content')
    <div class="container d-flex justify-content-center mb-3">
        <div class="col-md-6 qr-container bg_qr_code">
            <img src="{{ asset('img_back_end/icon.webp') }}" class="bakong-logo" alt="KHQR" width=50 height=50>
            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 12.5px; margin-top:-15px; font-weight: bold;">BAKONG KHQR</p>
            <h3 class="mb-4">ស្កេនដើម្បីបង់ប្រាក់</h3>
            <div class="mb-4 p-3 border rounded d-inline-block">
                {{-- កូដបង្កើត QR Code --}}
                {!! QrCode::size(250)->margin(2)->errorCorrection('H')->generate($qrString) !!}
            </div>
            <h5 style="margin-top:-20px; font-family: Time New Roman;">PICHDARA HENG</h5>
            <h5 style="font-family: Time New Roman;">{{ number_format($amount, 2) }}$</h5>

            <div id="status-alert" class="alert alert-info alert_for_darkmode" style="margin-top:20px;">
                រងចាំសម្រាប់ការបង់ប្រាក់ <i class="fas fa-spinner fa-spin" style="font-size: 15px;"></i>
            </div>
            
            <p class="small  checking">កំពុងឆែករៀងរាល់៤វិនាទី។ កុំបិទគេហទំព័រនេះ។</p>
            <p class="small text-warning">មុននឹងស្កេន! តើអ្នកបានអានលក្ខខណ្ឌហើយរឺនៅ?</p>
            <div class="d-flex justify-content-end">
                <a class="text_color_cancel_buy btn  btn-danger text-decoration-none mr-1" href="{{ route('Front_end.index') }}">បដិសេធការបញ្ចារទិញ</a>
                <button id="back-back" class="btn btn-dark mx-end" style="" onclick="history.back()">ត្រឡប់ក្រោយ</button>
            </div>
        </div>
    </div>
    <div class="container-fluid mx-auto">
        <div class="modal fade mx-auto " id="paymentSuccessModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content d-flex justify-content-center" id="receipt-content">

                <div class="modal-header bg-success text-white border_under">
                    <h5 class="modal-title">បង់ប្រាក់បានជោគជ័យ 🎉</h5>
                </div>

                
                    <div class="modal-body text-left bg_recipt_darkmode">
                        {{-- រូបភាព Logo ហាងនៅចំកណ្ដាល --}}
                        <img class="rounded-circle d-block mx-auto mb-3" src="{{ asset('img_back_end/Men_Fashion_Store.png') }}" alt="Logo" width="80" height="80" style="margin-top:-15px;">
                        <h3 class="text-center">Men Fashion Store</h3>
                        
                        <h4 class="text-center">សូមរក្សាទុកវិក័យប័ត្រនេះ</h4>
                        <p class="text-center small paymented">ដើម្បីបញ្ជាក់ថាអ្នកបានបង់ប្រាក់រួចរាល់</p>

                        <hr>

                        <h5 class="mb-3">📦 ព័ត៌មានទំនិញ</h5>
                        <div id="display-items">
                            @foreach($pictures as $item)
                                <div class="row mb-3 align-items-center border-bottom pb-2">
                                    <div class="col-4">
                                        @php $images = json_decode($item->image_picture); @endphp
                                        <img src="{{ asset('storage/'.$images[0]) }}" class="img-fluid rounded border">
                                    </div>
                                    <div class="col-8">
                                        <h6 class="mb-1" style="font-weight: bold;">{{ $item->post->category_clothe->text_clothes }}</h6>
                                        <p class="mb-0 small">
                                            @php 
                                                // ទាញយក record ចុងក្រោយពី table information_customers សម្រាប់ picture មួយនេះ
                                                $info = $item->information_customers->last(); 
                                                $qty = $info ? $info->number_items : 0;
                                                $price = $item->post->price ?? 0;
                                            @endphp
                                            
                                            ចំនួន៖ {{ $qty }} <br> 
                                            ទំហំ៖ {{ $item->size->text_size ?? 'N/A' }} <br>
                                            តម្លៃ៖ {{ number_format($price * $qty, 2) }} $
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="alert alert-secondary text-right bg_total_price">
                            <strong>តម្លៃសរុបទាំងអស់៖ <span id="display-total">{{ number_format($amount, 2) }}</span> $</strong>
                        </div>

                        <hr>

                        <h5 class="mb-3">👤 ព័ត៌មានអតិថិជន</h5>
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item px-0 bg_list">ឈ្មោះ: <strong id="res-name">{{ $customer['name_customer'] ?? 'កំពុងទាញទិន្នន័យ...' }}</strong></li>
                            <li class="list-group-item px-0 bg_list">លេខទូរស័ព្ទ: <strong id="res-phone">{{ $customer['phone_customer'] ?? '---' }}</strong></li>
                            <li class="list-group-item px-0 bg_list">ឈ្មោះគណនីធនាគារ: <strong id="res-bank-name">{{ $customer['name_account_bank_customer'] ?? '---' }}</strong></li>
                            <li class="list-group-item px-0 bg_list">លេខគណនីធនាគារ: <strong id="res-bank-num">{{ $customer['number_account_bank_customer'] ?? '---' }}</strong></li>
                            <li class="list-group-item px-0 bg_list">អាស័យដ្ឋាន: <strong id="res-address">{{ $customer['address_customer'] ?? '---' }}</strong></li>
                        </ul>

                        <div class="mt-3 p-2 bg_seller rounded">
                            {{-- ប្រើ unique ដើម្បីឱ្យវាទាញយកតែអ្នកលក់ដែលមិនស្ទួន ID គ្នាមកបង្ហាញ --}}
                            @foreach($pictures->unique('contact_id') as $picture)
                                <p class="mb-1 small">
                                    អ្នកលក់៖ {{ $picture->contact->name_contact }} ({{ $picture->contact->phone_contact }})
                                </p>
                            @endforeach
                        </div>
                    </div>

                    {{-- រក្សាទុក Footer របស់បងនៅដដែល --}}
                    <div class="modal-footer bg_footer">
                        <button class="btn btn-primary" onclick="saveReceiptImage()">
                            រក្សាទុកវិក័យប័ត្រ
                        </button>
                        @php
                            // ស្រង់យក post_id ពី collection នៃរូបភាពដែលបាន checkout (យកតែ unique id ការពារការជាន់គ្នា)
                            // បើ pictures មានរូបភាពមកពី post id 1 និង 2 វានឹងចេញ "1,2"
                            $all_post_ids = $pictures->pluck('post_id')->unique()->implode(',');
                        @endphp

                        @if($all_post_ids)
                        <a href="{{ route('Front_end.picture', ['id' => $all_post_ids]) }}" class="btn btn-success btn_another_colors">
                            បន្តការជ្រើសរើសពណ៍ផ្សេងៗ
                        </a>
                        @endif

                        <a href="{{route('Front_end.index')}}" class="btn btn_another_items">
                            មើលទំនិញផ្សេងៗ
                        </a>
                    </div>
                

                </div>
            </div>
        </div>
    </div>
    <script>
       // បង្កើត Variable ដើម្បីទប់ស្កាត់ការបាញ់ Request ជាន់គ្នា
        let isRequestPending = false;

        const checkPaymentStatus = setInterval(() => {
            if (isRequestPending) return; // បើ Request មុនមិនទាន់ចប់ មិនទាន់បាញ់ថ្មីទេ

            isRequestPending = true;

            fetch("{{ route('payment.verify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    md5: "{{ $md5 }}",
                    customerData: @json($customer)
                })
            })
            .then(res => res.json())
            .then(data => {
            isRequestPending = false;
            console.log("Response from Server:", data);

            // === ករណីបង់ប្រាក់ជោគជ័យ ===
            if (data.status === 'SUCCESS') {
                clearInterval(checkPaymentStatus); 

                // លាក់ Alert ពណ៌លឿង (INSUFFICIENT) ចេញភ្លាមៗ
                $('#status-alert')
                    .show() 
                    .removeClass('alert-info alert_for_darkmode')
                    .addClass('alert-info alert_for_darkmode')
                    .html('✅ បង់ប្រាក់បានជោគជ័យ! សូមពិនិត្យវិក័យប័ត្រខាងក្រោម។');

                // ១. បំពេញព័ត៌មានអតិថិជនថ្មីចូលក្នុង Modal
                if (data.customer) {
                    $('#res-name').text(data.customer.name_customer);
                    $('#res-phone').text(data.customer.phone_customer);
                    $('#res-bank-name').text(data.customer.name_account_bank_customer);
                    $('#res-bank-num').text(data.customer.number_account_bank_customer);
                    $('#res-address').text(data.customer.address_customer);
                }

                // ២. បំពេញបញ្ជីទំនិញថ្មីចូលក្នុង Modal
                if (data.items && data.items.length > 0) {
                    let itemsHtml = '';
                    data.items.forEach(item => {
                        itemsHtml += `
                            <div class="row mb-3 align-items-center border-bottom pb-2">
                                <div class="col-4">
                                    <img src="${window.location.origin}/storage/${item.image}" class="img-fluid rounded border">
                                </div>
                                <div class="col-8">
                                    <h6 class="mb-1" style="font-weight: bold;">${item.text_clothes}</h6>
                                    <p class="mb-0 small">
                                        ចំនួន៖ ${item.qty} <br> 
                                        ទំហំ៖ ${item.size} <br>
                                        តម្លៃ៖ ${(parseFloat(item.price) * item.qty).toFixed(2)} $
                                    </p>
                                </div>
                            </div>`;
                    });
                    $('#display-items').html(itemsHtml);
                    $('#display-total').text(parseFloat(data.amount).toFixed(2));
                }

                // បង្ហាញ Modal ជោគជ័យ
                $('#paymentSuccessModal').modal('show');
                return; // បញ្ចប់ត្រឹមនេះ
            }

            // === ករណីបាញ់លុយមិនគ្រប់ ===
            else if (data.status === 'INSUFFICIENT') {
                var receivedFormatted = parseFloat(data.received).toFixed(2);
                var missingFormatted  = parseFloat(data.missing).toFixed(2);

                // បង្ហាញ Alert ពណ៌លឿង
                $('#status-alert')
                    .show() // ត្រូវប្រាកដថាវាបង្ហាញឡើងវិញ
                    .removeClass('alert-info alert-success')
                    .addClass('alert-warning')
                    .html('⚠️ ការទូទាត់មិនជោគជ័យ! ចំនួនទឹកប្រាក់ដែលទទួលបានគឺ ' + receivedFormatted + '$ (មិនគ្រប់ចំនួន)។ យោងតាមលក្ខខណ្ឌទី5 ប្រាក់ដែលបង់មិនគ្រប់មិនអាចបង្វិលវិញបានទេ។ សូមមេត្តាទូទាត់ម្ដងទៀតឱ្យត្រឹមត្រូវតាមចំនួនសរុប។');
            }
        })
        .catch(error => {
            isRequestPending = false;
            console.error("Network problem:", error);
        });

    }, 4000); // ឆែករៀងរាល់ ៤ វិនាទីម្តង

        /* ================= SAVE MODAL AS IMAGE ================= */
        function saveReceiptImage() {
            const target = document.getElementById('receipt-content');

            html2canvas(target, {
                scale: 2,
                useCORS: true
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'payment-receipt.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
@endsection
</body>
</html>