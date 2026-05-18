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
    <script src=" {{ asset('../js_front_end/clothe.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>
    .warning:hover{
        background-color: rgba(255, 0, 0, 0);
    }
    .dark-mode .warning:hover{
        background-color: rgba(255, 0, 0, 0);
    }
    .bg_condition{
        background-color: white;
        border: 1px solid black !important;
    }
    .dark-mode .bg_condition{
        background-color: rgb(50,50,50);
        border: 1px solid white !important;
    }
    .condition{
        color: #D97706 !important;
    }
    .dark-mode .condition{
        color: #fff700 !important;
    }
</style>
<body>
    <div class="container mt-5">
        <form action="{{ route('Front_end.qr_code') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="card mb-3">
                <div class="card-header">ទំនិញដែលអ្នកបានរើស</div>
                <div class="card-body">
                    {{-- Loop តែលើទំនិញទេ --}}
                    @foreach($pictures as $item)
                        <div class="mb-4 border-bottom pb-2">
                            <label class="text-primary font-weight-bold">តម្លៃទំនិញ: {{ $item->post->price }}$</label><br>
                            <label class="text-primary font-weight-bold">ទំហំ: {{ $item->size->text_size }}</label>
                            
                            {{-- បញ្ជូន ID ទៅ Controller ជា Array --}}
                            <input type="hidden" name="picture_ids[]" value="{{ $item->id }}">
                            
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    {{-- បង្ហាញរូបភាព និងពណ៌ (បើមាន) --}}
                                    <img src="{{ asset('storage/' . json_decode($item->image_picture)[0]) }}" width="80" class="rounded">
                                </div>
                                <div class="col-md-6">
                                    <label>បញ្ចូលចំនួនសម្រាប់ទំនិញនេះៈ</label>
                                    {{-- ចាប់យកចំនួនតាម ID នីមួយៗ --}}
                                    <input type="number" name="items[{{ $item->id }}][qty]" class="form-control" value="1" min="1">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ផ្នែកបំពេញព័ត៌មានអតិថិជន (នៅក្រៅ Loop - សរសេរតែម្តងគត់) --}}
            <div class="card mb-2">
                <div class="card-header">ព័ត៌មានអ្នកទិញ</div>
                <div class="card-body">
                    <div class="mb-2">
                        <label>ឈ្មោះ</label>
                        <input type="text" name="name_customer" class="form-control ifm_csm" placeholder="បញ្ចូលឈ្មោះ" required>
                    </div>
                    <div class="mb-2">
                        <label>លេខទូរស័ព្ទ</label>
                        <input type="text" name="phone_customer" class="form-control ifm_csm" placeholder="បញ្ចូលលេខទូរស័ព្ទ" required>
                    </div>
                    <div class="mb-2">
                        <label>ឈ្មោះគណនីធនាគារ</label>
                        <input type="text" name="name_account_bank_customer" class="form-control ifm_csm" placeholder="បញ្ចូលឈ្មោះគណនីធនាគារ" required>
                    </div>
                    <div class="mb-2">
                        <label>លេខគណនីធនាគារ</label>
                        <input type="text" name="number_account_bank_customer" class="form-control ifm_csm" placeholder="បញ្ចូលលេខគណនីធនាគារ" required>
                    </div>
                    <div class="mb-2">
                        <label>អាស័យដ្ឋានបច្ចុប្បន្ន</label>
                        <input type="text" name="address_customer" class="form-control ifm_csm" placeholder="សូមសរសេរអាស័យដ្ឋានលំអិត រួមទាំងអ្វីផ្សេងៗបន្ថែមបាន" required>
                    </div>
                    <div class="mt-4 p-3 border rounded bg_condition">
                        <label class="font-weight-bold mb-2 condition">
                            <i class="fas fa-exclamation-triangle"></i> លក្ខខណ្ឌមួយចំនួនមុនពេលសម្រេចចិត្តចុចទិញ៖
                        </label>
                        <div style="font-size: 0.87rem; line-height: 1.6;  max-height: 250px; overflow-y: auto; padding-right: 10px; letter-spacing: 0.35px;" class="condition">
                            <ol class="pl-3">
                                <li class="mb-1 warning"><strong>ការត្រួតពិនិត្យព័ត៌មាន៖</strong> សូមមេត្តាពិនិត្យព័ត៌មានទំនិញ និងបញ្ចូលព័ត៌មានទំនាក់ទំនង (អាសយដ្ឋាន/លេខទូរស័ព្ទ) ឱ្យបានត្រឹមត្រូវបំផុត មុនពេលចុចបញ្ជាក់ការទិញ។</li>
                                <li class="mb-1 warning"><strong>គោលការណ៍មិនបង្វិលប្រាក់៖</strong> រាល់ការបង់ប្រាក់ដែលបានសម្រេចជោគជ័យ ហាងមិនមានគោលការណ៍បង្វិលប្រាក់វិញឡើយ ក្នុងករណីមានការផ្លាស់ប្តូរចិត្តពីខាងអតិថិជន។</li>
                                <li class="mb-1 warning"><strong>ករណីដាច់ស្តុក៖</strong> ប្រសិនបើទំនិញដែលអ្នកបានកុម្ម៉ង់អស់ពីស្តុក យើងខ្ញុំនឹងធ្វើការផ្ទេរប្រាក់បង្វិលជូនអ្នកវិញភ្លាមៗ ១០០%។</li>
                                <li class="mb-1 warning"><strong>ករណីខ្វះខាតទំនិញ៖</strong> ក្នុងករណីទំនិញមានមិនគ្រប់ចំនួន ហាងនឹងផ្ទេរប្រាក់បង្វិលជូនវិញទៅតាមតម្លៃ និងចំនួនទំនិញដែលខ្វះខាតជាក់ស្តែង។</li>
                                <li class="mb-1 warning"><strong>ការបង់ប្រាក់មិនគ្រប់ចំនួន៖</strong> រាល់ការបង់ប្រាក់ដែលមិនគ្រប់តាមចំនួនសរុប នឹងត្រូវចាត់ទុកថាជាមោឃៈ។ ទឹកប្រាក់ដែលបានបង់មិនគ្រប់នោះ មិនអាចដកវិញបានទេ ហើយទំនិញក៏មិនត្រូវបានបញ្ចេញជូនដែរ។</li>
                                <li class="mb-1 warning"><strong>លក្ខខណ្ឌបង់ប្រាក់ឡើងវិញ៖</strong> ករណីបង់ប្រាក់ខ្វះ អតិថិជនត្រូវធ្វើការបង់ប្រាក់ម្ដងទៀតឱ្យគ្រប់ចំនួនសរុបទាំងអស់។ ប្រព័ន្ធមិនអាចទទួលយកការបង់ប្រាក់បន្ថែមដើម្បីបង្គ្រប់ចំនួនទឹកប្រាក់ដែលខ្វះក្នុងប្រតិបត្តិការចាស់បានឡើយ។</li>
                            </ol>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="agree_terms" required>
                            <label class="form-check-label" for="agree_terms" style="font-size: 0.9rem; cursor: pointer;">
                                ខ្ញុំបានអាន និងយល់ព្រមលើលក្ខខណ្ឌខាងលើ
                            </label>
                        </div>
                    </div>
                    <button id="btn-submit" type="submit" class="btn btn-primary btn-block mt-3" disabled>យល់ព្រមទិញទាំងអស់</button>
                    <button id="back-back" class="btn new_back" style="margin-top:16.25px; margin-left:0px;" onclick="history.back()">ត្រឡប់ក្រោយ</button>
                </div>
            </div>
        </form>
    </div>
    <script>
    $(document).ready(function() {
        // ចាប់យក Event នៅពេល Checkbox ផ្លាស់ប្តូរ (Tick ឬ Uncheck)
        $('#agree_terms').on('change', function() {
            if ($(this).is(':checked')) {
                // បើ Tick ឱ្យដក disabled ចេញ (ចុចបាន)
                $('#btn-submit').prop('disabled', false);
            } else {
                // បើដក Tick វិញ ឱ្យដាក់ disabled វិញ (ចុចមិនកើត)
                $('#btn-submit').prop('disabled', true);
            }
        });
    });
    </script>
</body>
</html>
