<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use KHQR\Models\Individual;
use KHQR\Models\IndividualInfo;
use App\Services\KHQRService;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Models\Clothe;
use App\Models\Category_clothe;
use App\Models\Category_fabric;
use App\Models\Post;
use App\Models\Contact;
use App\Models\size;
use App\Models\Picture;
use App\Models\Information_customer;
use App\Models\Announcement;


class AdminController extends Controller
{
    public function admin(){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();

        return view('Back_end.index', compact('admins'));
    }
    public function admin_create(){
        return view('Back_end.index_create');
    }
    public function admin_store(Request $request){
        $request->validate([
            'name_admin'=>'required',
            'picture_admin'=>'required|image|max:51200',
            'phone_number_admin' => 'required',
            'cover_admin'=>'required|image|max:51200',
            'address_admin' => 'required',
            'link_map_admin' => 'required',
        ]);
        if ($request->hasFile('picture_admin')) {
            $path_admin = $request->file('picture_admin')->store('images', 'public');
        } else {
            return back()->with('error', 'Image is required.');
        }
        if ($request->hasFile('cover_admin')) {
            $path = $request->file('cover_admin')->store('images', 'public');
        } else {
            return back()->with('error', 'Image is required.');
        }
        Admin::create([
            
            'name_admin' => $request->input('name_admin'),
            'picture_admin' => $path_admin,
            'phone_number_admin' => $request->input('phone_number_admin'),
            'cover_admin' => $path,
            'address_admin' => $request->input('address_admin'),
            'link_map_admin' => $request->input('link_map_admin'),
            
        ]);

        return redirect()->route('Back_end.index')->with('success', 'បញ្ជាក់អត្តសញ្ញាណអ្នកគ្រប់គ្រងបានជោគជ័យ');
    }
    public function admin_edit($id)
    {
        
        $admins = Admin::find($id);

        return view('Back_end.index_edit', compact('admins'));
    }
    public function admin_update(Request $request, $id)
    {
        $admins = Admin::find($id);


        // Check if a new file is uploaded
        if ($request->hasFile('picture_admin')) {
            $path_admin = $request->file('picture_admin')->store('images', 'public'); // Save the file in the 'images' directory within 'storage/app/public'
        } else {
            $path_admin = $admins->picture_admin; // Keep the existing image if no new file is uploaded
        }
        if ($request->hasFile('cover_admin')) {
            $path = $request->file('cover_admin')->store('images', 'public'); // Save the file in the 'images' directory within 'storage/app/public'
        } else {
            $path = $admins->cover_admin; // Keep the existing image if no new file is uploaded
        }

        $admins->name_admin = $request->input('name_admin');
        $admins->picture_admin = $path_admin;
        $admins->phone_number_admin = $request->input('phone_number_admin');
        $admins->cover_admin = $path;
        $admins->address_admin = $request->input('address_admin');
        $admins->link_map_admin = $request->input('link_map_admin');

        $admins->save();
        return redirect()->route('Back_end.index')->with('success', 'កែប្រែអត្តសញ្ញាណអ្នកគ្រប់គ្រងបានជោគជ័យ');
    }
    public function admin_destroy($id)
    {
        
        $admins = Admin::find($id);

        return view('Back_end.index_destroy', compact('admins'));
    }
    public function admin_delete($id){
        $admins = Admin::findOrfail($id);
        $admins->delete();
        return redirect()->route('Back_end.index')->with('success', 'លុបអត្តសញ្ញាណអ្នកគ្រប់គ្រងបានជោគជ័យ');
    }
    public function admin_alldestroy()
    {
        return view('Back_end.index_alldestroy');
    }
    public function admin_alldelete(){
        
        Admin::query()->delete();
        return redirect()->route('Back_end.index')->with('success', 'លុបអត្តសញ្ញាណអ្នកគ្រប់គ្រងទាំងអស់បានជោគជ័យ');
    }
    public function search(Request $request){
    $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
    $keyword = $request->input('query'); // Your search term
    $results = [];

    // Search clothes table
    $results['clothes'] = Clothe::where('text', 'like', "%{$keyword}%")->get();
    

    // Search category_clothes table
    $results['category_clothes'] = Category_clothe::where('text_clothes', 'like', "%{$keyword}%")->get();
    

    // Search category_fabrics table
    $results['category_fabrics'] = Category_fabric::where('text_fabrics', 'like', "%{$keyword}%")->get();
    

    // Search posts table
    $results['posts'] = Post::where('caption', 'like', "%{$keyword}%")->orwhere( 'price', 'like', "%{$keyword}%")->orwhere( 'brand', 'like', "%{$keyword}%")->get();
    

    // Search contacts table
    $results['contacts'] = Contact::where('name_contact', 'like', "%{$keyword}%")->orwhere( 'phone_contact', 'like', "%{$keyword}%")->get();
    

    // Search sizes table
    $results['sizes'] = size::where('text_size', 'like', "%{$keyword}%")->get();
    

    // Search pictures table
    $results['pictures'] = Picture::where('image_picture', 'like',  "%{$keyword}%")->get();

    // Search information_customers table
    $results['information_customers'] = Information_customer::where('name_customer', 'like', "%{$keyword}%")->orwhere( 'phone_customer', 'like', "%{$keyword}%")->orwhere( 'name_account_bank_customer', 'like', "%{$keyword}%")->orwhere( 'number_account_bank_customer', 'like', "%{$keyword}%")->orwhere( 'address_customer', 'like', "%{$keyword}%")->orwhere( 'created_at', 'like', "%{$keyword}%")->get();
    

    return view('Back_end.search', compact('results', 'keyword', 'admins'));
    }

    public function admin_front_end(){
        $announcements = Announcement::where('is_active', 1)
                                 ->orderBy('id', 'DESC')
                                 ->limit(1)
                                 ->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $clothes = Clothe::orderBy('id', 'DESC')->limit(3)->get();
        $post = Post::orderBy('id', 'DESC')->get();
        return view('Front_end.index', compact('clothes','post','admins','announcements'));
    }
    public function admin_all_front_end(){
        $announcements = Announcement::where('is_active', 1)
                                 ->orderBy('id', 'DESC')
                                 ->limit(1)
                                 ->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $clothes = Clothe::orderBy('id', 'DESC')->get();
        $post = Post::orderBy('id', 'DESC')->get();
        return view('Front_end.index_all', compact('clothes','post','admins','announcements'));
    }
    public function clothe_front_end($id){
        $announcements = Announcement::where('is_active', 1)
                                 ->orderBy('id', 'DESC')
                                 ->limit(1)
                                 ->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $clothes = Clothe::findOrFail($id);
        $category_clothes = Category_clothe::orderBy('id', 'ASC')->where('clothe_id',$id)->get();
        $post = Post::orderBy('id', 'DESC')->whereIn('category_clothe_id', $category_clothes->pluck('id'))->get();
        return view('Front_end.clothe', compact('category_clothes','post','clothes','admins','announcements'));
    }
    public function category_clothe_front_end($id){
        $announcements = Announcement::where('is_active', 1)
                                 ->orderBy('id', 'DESC')
                                 ->limit(1)
                                 ->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $category_clothes = Category_clothe::findOrFail($id);
        $category_fabrics = Category_fabric::orderBy('id', 'DESC')->get();
        $post = Post::orderBy('id', 'DESC')->where('category_clothe_id',$id)->get();
        return view('Front_end.category_clothe', compact('category_clothes','post','category_fabrics','admins','announcements'));
    }
    public function category_fabric_front_end($ID,$id){
        $announcements = Announcement::where('is_active', 1)
                                 ->orderBy('id', 'DESC')
                                 ->limit(1)
                                 ->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $category_clothes = Category_clothe::findOrFail($ID);
        $category_fabrics = Category_fabric::findOrFail($id);
        $post = Post::orderBy('id', 'DESC')->where('category_clothe_id',$ID)->where('category_fabric_id',$id)->get();
        return view('Front_end.category_fabric', compact('post','category_fabrics','admins','announcements'));
    }
    public function search_front_end(Request $request){
        $announcements = Announcement::where('is_active', 1)
                                 ->orderBy('id', 'DESC')
                                 ->limit(1)
                                 ->get();
        $query = $request->input('query');
        $results = Post::where('caption', 'like', '%' . $query . '%')->orwhere( 'price', 'like', '%' . $query . '%')->orwhere( 'brand', 'like', '%' . $query . '%')->orWhereHas('category_clothe', function ($q) use ($query) {$q->where('text_clothes', 'like', '%' . $query . '%');})->orWhereHas('category_fabric', function ($q) use ($query) {$q->where('text_fabrics', 'like', '%' . $query . '%');})->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Front_end.search', compact("results","query",'admins','announcements'));

    }
    public function picture_front_end($id){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $ids = explode(',', $id);

        // ត្រូវប្រើ get() ដើម្បីបានជាបញ្ជី (Collection)
        $post = Post::whereIn('id', $ids)->get(); 

        // បង្កើន view សម្រាប់គ្រប់ post ដែលបានជ្រើសរើស
        foreach($post as $p){
            $p->increment('view');
        }

        $pictures = Picture::whereIn('post_id', $ids)->orderBy('id', 'DESC')->get();

        // បញ្ជូន $posts ទៅ view
        return view('Front_end.picture', compact('pictures','post','admins'));
    }
    public function customer_identity_front_end($id){

        $pictures = Picture::findOrFail($id);

        return view('Front_end.customer_identity', compact('pictures'));
    }
    // 1. Handle Form Submission & Show QR
    /*public function checkout(Request $request)
    {
        $request->validate([
            'picture_id' => 'required|exists:pictures,id',
            'number_items' => 'required|integer|min:1',
        ]);

        $picture = Picture::with('post')->find($request->picture_id);
        if (!$picture) {
            return back()->with('error', 'Product not found');
        }

        $totalAmount = (float) ($picture->post->price * $request->number_items);

        $bakong = new BakongKHQR(env('BAKONG_TOKEN'));

        $info = new IndividualInfo(
            bakongAccountID: env('BAKONG_MERCHANT_ID'),
            merchantName: 'PICHDARA HENG',
            merchantCity: 'Phnom Penh',
            currency: 840, // USD
            amount: $totalAmount
        );

        $qr = $bakong->generateIndividual($info);

        if (!isset($qr->status) || $qr->status['code'] !== 0) {
            return back()->with('error', 'Bakong QR generation failed');
        }

        return view('Front_end.qr_code', [
            'qrString' => $qr->data['qr'],
            'md5' => $qr->data['md5'],
        ]);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
        ]);

        $bakong = new BakongKHQR(env('BAKONG_TOKEN'));
        $response = $bakong->checkTransactionByMD5($request->md5);

        return response()->json($response);
    }*/

    public function customerIdentityMultiple(Request $request) {
        $ids = $request->input('selected_items');

        if (!$ids) {
            return back()->with('error', 'សូមជ្រើសរើសទំនិញយ៉ាងតិចមួយ!');
        }

        // ទាញយកទំនិញទាំងអស់តាម IDs ដែលបានរើស
        $pictures = Picture::whereIn('id', $ids)->with(['post', 'size', 'contact'])->get();

        return view('Front_end.customer_identity', compact('pictures'));
    }

    public function checkout(Request $request)
    {
        // 1️ Validate (VERY IMPORTANT)
        $request->validate([
            'name_customer' => 'required',
            'phone_customer' => 'required',
            'name_account_bank_customer' => 'required',
            'number_account_bank_customer' => 'required',
            'address_customer' => 'required',
            'picture_ids' => 'required|array', // ទទួល [3, 4]
            'items' => 'required|array',       // ទទួលចំនួនតាម ID
        ]);

        $pictureIds = $request->picture_ids;
        $pictures = Picture::whereIn('id', $pictureIds)->with('post')->get();
        
        $totalAmount = 0;
        $allOrdersForSession = [];

        foreach ($pictures as $pic) {
            // ចាប់យកចំនួន (qty) ដែលអតិថិជនបំពេញតាម ID នីមួយៗ
            $qty = $request->items[$pic->id]['qty'] ?? 1;
            $price = (float) $pic->post->price;
            $totalAmount += ($price * $qty);

            // រៀបចំទិន្នន័យឱ្យត្រូវតាម Column ក្នុង phpMyAdmin របស់បងបេះបិទ
            $allOrdersForSession[] = [
                'picture_id'                   => $pic->id, 
                'number_items'                 => $qty,
                'name_customer'                => $request->name_customer,
                'phone_customer'               => $request->phone_customer,
                'name_account_bank_customer'   => $request->name_account_bank_customer,
                'number_account_bank_customer' => $request->number_account_bank_customer,
                'address_customer'             => $request->address_customer,
            ];
        }

        // 4️ Create Bakong KHQR instance
        $bakong = new BakongKHQR(env('BAKONG_TOKEN'));

        // 5️ Create IndividualInfo OBJECT (THIS FIXES YOUR ERROR)
        $info = new IndividualInfo(
            bakongAccountID: env('MERCHANT_BAKONG_ID'),
            merchantName: env('MERCHANT_NAME'),
            merchantCity: env('MERCHANT_CITY'),
            currency: '840',
            mobileNumber: '85516579434',
            storeLabel: 'Men Fashion Store',
            terminalLabel: 'Online-Checkout'
        );

        // 4️. បន្ថែម Amount ដែលគណនាបាន (Format ជា String មានក្បៀស ២ ខ្ទង់)
        // នេះជាចំណុចដែលធ្វើឱ្យលោតលុយអូតូ
        // ៣. បន្ថែម Amount (Format ជា String មានក្បៀស ២ ខ្ទង់)

        // 6️⃣ Generate KHQR
        $qrCode = $bakong->generateIndividual($info);

        $md5 = $qrCode->data['md5'];

        session()->put('pending_'.$md5, [
        'customer' => $allOrdersForSession,
        'amount'   => $totalAmount,
        ]);

        // 7️ Show QR (NO DB SAVE)
        return view('Front_end.qr_code', [
            'pictures'      => $pictures,
            'qrString'     => $qrCode->data['qr'],  // កែត្រង់នេះ
            'md5'          => $md5, // កែត្រង់នេះ
            'customer'     => $allOrdersForSession,
            'amount'       => $totalAmount,
        ]);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
        ]);

        try {
            $bakong = new BakongKHQR(env('BAKONG_TOKEN'));
            $result = $bakong->checkTransactionByMD5($request->md5);

            // ✅ ១. ពិនិត្យថាមានទិន្នន័យពី Bakong មែនឬអត់
            if (isset($result['responseCode']) && $result['responseCode'] === 0 && !empty($result['data'])) {

                $receivedAmount = (float) $result['data']['amount'];
                $pending = session('pending_'.$request->md5);

                if ($pending) {
                    $requiredAmount = (float) $pending['amount'];

                    // 🛠 កែសម្រួលត្រង់នេះ៖ ប្រើ round ត្រឹម ២ ខ្ទង់ ដើម្បីបង្កត់លេខឱ្យស្មើគ្នាពិតប្រាកដ
                    if (round($receivedAmount, 2) < round($requiredAmount, 2)) {
                        $missingAmount = $requiredAmount - $receivedAmount;
                        return response()->json([
                            'status' => 'INSUFFICIENT',
                            'received' => $receivedAmount,
                            'required' => $requiredAmount,
                            'missing'  => $missingAmount,
                            'message' => 'ចំនួនលុយមិនគ្រប់ទេ!'
                        ]);
                    }
                }

                $customerData = null;
                $itemsData = [];

                // ✅ ២. ពិនិត្យការរក្សាទុកទិន្នន័យ (Prevent Duplicate)
                if (!session()->has('paid_'.$request->md5)) {
                    if ($pending) {
                        $cc = $pending['customer'];
                        $customerData = $cc[0]; 

                        foreach ($cc as $c) {
                            Information_customer::create([
                                'name_customer'                => $c['name_customer'],
                                'phone_customer'               => $c['phone_customer'],
                                'name_account_bank_customer'   => $c['name_account_bank_customer'],
                                'number_account_bank_customer' => $c['number_account_bank_customer'],
                                'address_customer'             => $c['address_customer'],
                                'number_items'                 => $c['number_items'], 
                                'picture_id'                   => $c['picture_id'],
                            ]);
                            
                            $pic = \App\Models\Picture::with('post', 'size')->find($c['picture_id']);
                            if($pic) {
                                $itemsData[] = [
                                    'image' => json_decode($pic->image_picture)[0],
                                    'text_clothes' => $pic->post->category_clothe->text_clothes,
                                    'size' => $pic->size->text_size,
                                    'qty' => $c['number_items'],
                                    'price' => $pic->post->price
                                ];
                            }
                        }

                        session()->put('paid_'.$request->md5, true);
                        // ⚠️ កុំអាល forget ភ្លាមៗអី ទុកឱ្យ JS ទាញ SUCCESS រួចសិនចាំលុប ឬទុកវាចោលក្នុង Session មួយរយៈសិន
                        // session()->forget('pending_'.$request->md5); 
                    }
                }

                return response()->json([
                    'status' => 'SUCCESS',
                    'amount' => $receivedAmount, // ប្រើលុយដែលទទួលបានពិតប្រាកដ
                    'currency' => $result['data']['currency'],
                    'customer' => $customerData,
                    'items' => $itemsData
                ]);
            }

            return response()->json(['status' => 'WAITING']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
