<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use App\Helpers\ABAHelper;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Picture;
use App\Models\Information_customer;

class InformationCustomerController extends Controller
{
    public function Information_customer(){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $information_customers = Information_customer::orderBy('id','DESC')->get();
        return view('Back_end.Information_customer', compact('admins','information_customers'));
    }

    /*public function Information_customer_store(Request $request)
{
    $request->validate([
        'name_customer' => 'required',
        'phone_customer' => 'required',
        'name_account_bank_customer' => 'required',
        'number_account_bank_customer' => 'required',
        'address_customer' => 'required',
        'picture_id' => 'required|exists:pictures,id'
    ]);

    $picture = Picture::with('post', 'contact')->find($request->picture_id);

    // Build payment link (your bank info)
    $paymentUrl = $picture->contact->link_payment; // For example, ABA transfer page

    // Optionally pass some info via query string
    $paymentUrl .= "?picture_id={$picture->id}&name=" . urlencode($request->name_customer);

    // Redirect customer to your bank page
    return redirect($paymentUrl);
}
public function paymentWebhook(Request $request)
{
    Log::info('ABA webhook:', $request->all());

    if ($request->input('status') !== 'success') {
        return response()->json(['message' => 'Payment not completed'], 200);
    }

    Information_customer::create([
        'picture_id' => $request->input('picture_id'),
        'name_customer' => $request->input('name'),
        'phone' => $request->input('phone'),
        'name_account_bank_customer' => $request->input('bank_name'),
        'number_account_bank_customer' => $request->input('bank_number'),
        'address_customer' => $request->input('address'),
        'status' => 'paid'
    ]);

    return response()->json(['message' => 'OK'], 200);
}

    public function Information_customer_store(Request $request)
{
    $request->validate([
        'name_customer' => 'required',
        'phone_customer' => 'required',
        'name_account_bank_customer' => 'required',
        'number_account_bank_customer' => 'required',
        'address_customer' => 'required',
        'picture_id' => 'required|exists:pictures,id'
    ]);

    $picture = Picture::with('post', 'contact')->find($request->picture_id);

    // Prepare ABA payload
    $data = [
        "merchant_id" => env('ABA_MERCHANT_ID'),
        "order_id" => 'INV_' . time(),
        "amount" => $picture->post->price,
        "currency" => "USD", // or "KHR" depending on your setup
        "return_url" => route('aba.webhook'),  // ABA will call this after payment
        "items" => [
            [
                "name" => "Picture #{$picture->id}",
                "price" => $picture->post->price,
                "quantity" => 1
            ]
        ],
        // optional: store customer info to send back via webhook
        "customer" => [
            "name" => $request->name_customer,
            "phone" => $request->phone_customer,
            "bank_name" => $request->name_account_bank_customer,
            "bank_number" => $request->number_account_bank_customer,
            "address" => $request->address_customer,
        ]
    ];

    // Sign payload
    $signature = ABAHelper::signPayload($data);

    // Call ABA API to get checkout URL
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'ABA-SIGNATURE' => $signature,
        'ABA-API-KEY' => env('ABA_API_KEY'),
    ])->post(env('ABA_CHECKOUT_URL'), $data);

    if ($response->successful()) {
        return redirect($response['url']); // redirect customer to ABA checkout
    } else {
        return back()->withErrors(['message' => 'Failed to initiate payment']);
    }
}*/

    /*public function Information_customer_store(Request $request)
{
    $request->validate([
        'name_customer' => 'required',
        'phone_customer' => 'required',
        'name_account_bank_customer' => 'required',
        'number_account_bank_customer' => 'required',
        'address_customer' => 'required',
        'picture_id' => 'required|exists:pictures,id'
    ]);

    $picture = Picture::with('post', 'contact')->find($request->picture_id);

    // Build payment URL
    $paymentUrl =
        $picture->contact->link_payment .
        $picture->post->price .
        "&picture_id=" . $picture->id .
        "&name=" . urlencode($request->name_customer) .
        "&phone=" . urlencode($request->phone_customer) .
        "&bank_name=" . urlencode($request->name_account_bank_customer) .
        "&bank_number=" . urlencode($request->number_account_bank_customer) .
        "&address=" . urlencode($request->address_customer) .
        "&callback_url=" . urlencode(route('aba.webhook'));

    return redirect($paymentUrl);
}
public function paymentWebhook(Request $request)
{
    Log::info('ABA webhook:', $request->all());
    

    // ABA status
    $status = $request->input('status'); // must be "success"

    if ($status !== 'success') {
        return response()->json(['message' => 'Payment not completed'], 200);
    }

    // Get form data from ABA webhook
    $picture_id = $request->input('picture_id');
    $name       = $request->input('name');
    $phone      = $request->input('phone');
    $bank_name  = $request->input('bank_name');
    $bank_number = $request->input('bank_number');
    $address     = $request->input('address');

    // Save to database ONLY AFTER payment success
    Information_customer::create([
        'picture_id' => $picture_id,
        'name_customer' => $name,
        'phone_customer' => $phone,
        'name_account_bank_customer' => $bank_name,
        'number_account_bank_customer' => $bank_number,
        'address_customer' => $address,
        'status' => 'paid'
    ]);

    return response()->json(['message' => 'OK'], 200);
}*/

    /*public function Information_customer_store(Request $request)
{
    $request->validate([
        'name_customer' => 'required',
        'phone_customer' => 'required',
        'name_account_bank_customer' => 'required',
        'number_account_bank_customer' => 'required',
        'address_customer' => 'required',
        'picture_id' => 'required|exists:pictures,id'
    ]);

    // Create pending order
    $order = Information_customer::create([
        'name_customer' => $request->name_customer,
        'phone_customer' => $request->phone_customer,
        'name_account_bank_customer' => $request->name_account_bank_customer,
        'number_account_bank_customer' => $request->number_account_bank_customer,
        'address_customer' => $request->address_customer,
        'picture_id' => $request->picture_id,
        'status' => 'pending'
    ]);

    $picture = Picture::with('post', 'contact')->find($request->picture_id);

    $paymentUrl =
        $picture->contact->link_payment .
        $picture->post->price .
        "&order_id=" . $order->id .        // <--- IMPORTANT
        "&callback_url=" . urlencode(route('aba.webhook')); 

    return redirect($paymentUrl);
}
public function paymentWebhook(Request $request)
{
    Log::info('ABA webhook:', $request->all());

    $orderId = $request->input('order_id');
    $status  = $request->input('status'); // e.g., "success"

    $order = Information_customer::find($orderId);

    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    if ($status === 'success') {
        $order->status = 'paid';
        $order->save();
    }

    return response()->json(['message' => 'OK'], 200);
}*/

    /*public function Information_customer_store(Request $request){
        $request->validate([
        'name_customer' => 'required',
        'phone_customer' => 'required',
        'name_account_bank_customer' => 'required',
        'number_account_bank_customer' => 'required',
        'address_customer' => 'required',
        'picture_id' => 'required|exists:pictures,id'
    ]);

    $picture = Picture::with('post', 'contact')->find($request->picture_id);

    // Generate payment URL with customer data
    $paymentUrl = $picture->contact->link_payment
    . $picture->post->price
    . "&picture_id=" . $picture->id
    . "&name=" . urlencode($request->name_customer)
    . "&phone=" . urlencode($request->phone_customer)
    . "&bank_name=" . urlencode($request->name_account_bank_customer)
    . "&bank_number=" . urlencode($request->number_account_bank_customer)
    . "&address=" . urlencode($request->address_customer)
    . "&callback_url=" . urlencode(route('aba.webhook', [], true)); // full absolute URL

    return redirect($paymentUrl);


    }

    public function paymentWebhook(Request $request)
    {
    Log::info('ABA webhook called', $request->all());

    // Get the fields sent by ABA
    $picture_id   = $request->input('picture_id') ?? $request->input('picture_id');
    $name         = $request->input('name') ?? $request->input('name_customer');
    $phone        = $request->input('phone') ?? $request->input('phone_customer');
    $bank_name    = $request->input('bank_name') ?? $request->input('name_account_bank_customer');
    $bank_number  = $request->input('bank_number') ?? $request->input('number_account_bank_customer');
    $address      = $request->input('address') ?? $request->input('address_customer');

    // Always save to database
    Information_customer::create([
        'name_customer' => $name,
        'phone_customer' => $phone,
        'name_account_bank_customer' => $bank_name,
        'number_account_bank_customer' => $bank_number,
        'address_customer' => $address,
        'picture_id' => $picture_id,
    ]);

    Log::info('Information_customer saved automatically');

    return response()->json(['message' => 'OK'], 200);
    }*/
    public function Information_customer_store(Request $request){
        $request->validate([
            'name_customer'=>'required',
            'phone_customer' => 'required',
            'name_account_bank_customer'=>'required',
            'number_account_bank_customer'=>'required',
            'address_customer'=>'required',
            'number_items'=>'required',
            'picture_id' => 'required|integer|exists:pictures,id',
        ]);

        Information_customer::create([
            'name_customer' => $request->input('name_customer'),
            'phone_customer' => $request->input('phone_customer'),
            'name_account_bank_customer' => $request->input('name_account_bank_customer'),
            'number_account_bank_customer' => $request->input('number_account_bank_customer'),
            'address_customer' => $request->input('address_customer'),
            'number_items' => $request->input('number_items'),
            'picture_id' => $request->input('picture_id'),
        ]);

        //return redirect()->route('Back_end.Information_customer')->with('success', 'បញ្ចូលព័ត៌មានអតិថិជនបានជោគជ័យ');
        //return redirect()->route('{{ $pictures->contact->link_payment }}',['id' => $request->input('picture->contact_id')])->with('success', 'បញ្ចូលរូបភាពបានជោគជ័យ');
            // 1. Find the picture
        $picture = Picture::where('id', $request->picture_id)
        ->with('contact')
        ->with('post')
        ->first();

        
        return redirect($picture->contact->link_payment . ($picture->post->price * $request->number_items))->with('success', 'បញ្ចូលព័ត៌មានអតិថិជនបានជោគជ័យ');
        
        
    
    }
    public function Information_customer_edit($id,$ID)
    {
        
        $information_customers  = Information_customer::find($id);
        $pictures = Picture::find($ID);

        return view('Back_end.Information_customer_edit', compact('pictures','information_customers'));
    }
    public function Information_customer_update(Request $request, $id)
    {
        $information_customers  = Information_customer::find($id);


        $information_customers->name_customer = $request->input('name_customer');
        $information_customers->phone_customer = $request->input('phone_customer');
        $information_customers->name_account_bank_customer = $request->input('name_account_bank_customer');
        $information_customers->number_account_bank_customer = $request->input('number_account_bank_customer');
        $information_customers->address_customer = $request->input('address_customer');
        $information_customers->picture_id = $request->input('picture_id');
            
        $information_customers->save();
        return redirect()->route('Back_end.Information_customer')->with('success', 'កែប្រែព័ត៌មានអតិថិជនបានជោគជ័យ');
    }
    public function Information_customerr_destroy($id,$ID)
    {
        
        $information_customers  = Information_customer::find($id);
        $pictures = Picture::find($ID);

        return view('Back_end.Information_customerr_destroy', compact('pictures','information_customers'));
    }
    public function Information_customerr_delete($id){
        $information_customers = Information_customer::findOrfail($id);
        $information_customers->delete();
        return redirect()->route('Back_end.Information_customer')->with('success', 'លុបព័ត៌មានអតិថិជនបានជោគជ័យ');
    }
    public function Information_customerr_alldestroy()
    {
        return view('Back_end.Information_customerr_alldestroy');
    }
    public function Information_customerr_alldelete(){
        
        Information_customer::query()->delete();
        return redirect()->route('Back_end.Information_customer')->with('success', 'លុបព័ត៌មានអតិថិជនទាំងអស់បានជោគជ័យ');
    }
    public function search_Information_customer(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = Information_customer::where('name_customer', 'like', '%' . $query . '%')->orwhere( 'phone_customer', 'like', '%' . $query . '%')->orwhere( 'name_account_bank_customer', 'like', '%' . $query . '%')->orwhere( 'number_account_bank_customer', 'like', '%' . $query . '%')->orwhere( 'address_customer', 'like', '%' . $query . '%')->orwhere( 'created_at', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_Information_customer', compact("results","query",'admins'));

    }
    public function sendToTelegram($id)
    {
        // ១. ទាញទិន្នន័យអតិថិជន និង Relationship ទាំងអស់
        $customer = Information_customer::with(['picture.post', 'picture.size', 'picture.contact'])->findOrFail($id);

        // ២. ទាញយក telegram_id ពី Table contact តាមរយៈ picture
        $telegram_id = $customer->picture->contact->telegram_id;

        // ពិនិត្យមើលថាតើមានលេខ ID ឬអត់
        if (!$telegram_id) {
            return back()->with('error', 'អ្នកលក់នេះមិនទាន់មានលេខ Telegram ID ក្នុងប្រព័ន្ធឡើយ!');
        }

        // ៣. រៀបចំសារជាទម្រង់ HTML
        $text = "<B>📦 មានការបញ្ជាទិញថ្មី!</B>\n"
              . "------------------------------\n"
              . "👤 <b>អតិថិជន:</b> " . $customer->name_customer . "\n"
              . "📞 <b>លេខទូរស័ព្ទ:</b> " . $customer->phone_customer . "\n"
              . "💳 <b>ឈ្មោះគណនីអតិថិជន:</b> " . $customer->name_account_bank_customer . "\n"
              . "🆔 <b>លេខគណនីអតិថិជន:</b> <code>" . $customer->number_account_bank_customer . "</code>\n"
              . "👕 <b>ទំនិញ:</b> " . $customer->picture->post->category_clothe->text_clothes . "\n"
              . "📏 <b>ទំហំ:</b> " . $customer->picture->size->text_size . "\n"
              . "🔢 <b>ចំនួន:</b> " . $customer->number_items . "\n"
              . "💰 <b>តម្លៃសរុប:</b> " . number_format($customer->picture->post->price * $customer->number_items, 2) ."$". "\n"
              . "📍 <b>អាស័យដ្ឋាន:</b> " . $customer->address_customer . "\n"
              . "------------------------------\n"
              . "⏰ <b>ម៉ោងបញ្ជាទិញ:</b> " . $customer->created_at;

              //ទាញយករូបភាពពី JSON Array
        $images = json_decode($customer->picture->image_picture);
        

        
        
            try {
                // ៤. បញ្ជាទៅ Telegram API ឱ្យផ្ញើសារ
                if (!empty($images)) {
                // កំណត់ផ្លូវរូបភាពទី ១
                $imagePath = storage_path('app/public/' . $images[0]);

                // ៥. បញ្ជាទៅ Telegram API ឱ្យផ្ញើរូបភាពជាមួយអត្ថបទ (sendPhoto)
                Telegram::sendPhoto([
                    'chat_id'    => $telegram_id,
                    'photo'      => InputFile::create($imagePath),
                    'caption'    => $text,      // អត្ថបទព័ត៌មាននឹងនៅពីក្រោមរូបភាព
                    'parse_mode' => 'HTML',
                ]);
                $customer->update(['is_sent' => true]);

                return back()->with('success', 'ព័ត៌មានអតិថិជនត្រូវបានផ្ញើទៅ Telegram រួចរាល់!');
                } else {
                    return back()->with('error', 'រកមិនឃើញរូបភាពសម្រាប់ផ្ញើឡើយ!');
                }
            }   catch (\Exception $e) {
                return back()->with('error', 'ការផ្ញើមានបញ្ហា: ' . $e->getMessage());
            }
         
        
    }
}
