<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Contact;
use App\Models\size;
use App\Models\Picture;
use App\Models\Information_customer;

class PictureController extends Controller
{
    public function picture(){
        $pictures = Picture::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.picture', compact('pictures','admins'));
    }
    public function picture_create(Request $request){
        $post = Post::orderBy('id', 'DESC')->get();
        $contact = Contact::orderBy('id', 'ASC')->get();
        $sizes = size::orderBy('id', 'ASC')->get();
   
        return view('Back_end.picture_create', compact('post','contact','sizes'));
    }

    public function picture_store(Request $request)
    {
        $request->validate([
            'image_picture.*' => 'required|image|max:51200',
            'post_id' => 'required|integer|exists:posts,id',
            'contact_id' => 'required|integer|exists:contacts,id',
            'size_id' => 'required|integer|exists:sizes,id',
        ]);

        $post_id = $request->input('post_id');
        $contact_id = $request->input('contact_id');
        $size_id = $request->input('size_id');

        // Handle image uploads
        $imagePaths = [];
        foreach ($request->file('image_picture') as $image) {
            // Store image and add to the array
            $imagePaths[] = $image->store('images', 'public');
        }

        // Save the data to the database, including post_id and contact_id
        foreach ($imagePaths as $imagePath) {
            Picture::create([
                'image_picture' => json_encode([$imagePath]), // Store each image individually
                'post_id' => $post_id,
                'contact_id' => $contact_id,
                'size_id' => $size_id,
            ]);
        }
        return redirect()->route('Back_end.picture')->with('success', 'បញ្ចូលរូបភាពបានជោគជ័យ');
    }
    public function picture_edit($id,$Id,$ID,$sid)
    {
        
        $post = Post::orderByRaw('id = ? DESC', [$Id])->get();
        $contact = Contact::orderByRaw('id = ? DESC', [$ID])->get();
        $sizes = size::orderByRaw('id = ? DESC', [$sid])->get();
        $pictures = Picture::find($id);

        return view('Back_end.picture_edit', compact('pictures','post','contact','sizes'));
    }

    public function picture_update(Request $request, $id)
    {
        $pictures = Picture::find($id);

        // Check if new files are uploaded
        if ($request->hasFile('image_picture')) {
            $paths = [];
            foreach ($request->file('image_picture') as $file) {
                $paths[] = $file->store('images', 'public'); // Save each file and store its path
            }
            $pictures->image_picture = json_encode($paths); // Save paths as JSON
        }
    
        $pictures->post_id = $request->input('post_id');
        $pictures->contact_id = $request->input('contact_id');
        $pictures->size_id = $request->input('size_id');
            
        $pictures->save();
        return redirect()->route('Back_end.picture')->with('success', 'កែប្រែរូបភាពបានជោគជ័យ');
    }
    public function picture_destroy($id,$Id,$ID,$sid)
    {
        $post = Post::orderByRaw('id = ? DESC', [$Id])->get();
        $contact = Contact::orderByRaw('id = ? DESC', [$ID])->get();
        $sizes = size::orderByRaw('id = ? DESC', [$sid])->get();
        $pictures = Picture::find($id);

        return view('Back_end.picture_destroy', compact('pictures','post','contact','sizes'));
    }
    public function picture_delete($id){
        $pictures = Picture::findOrfail($id);
        
        $pictures->information_customers()->delete();
        $pictures->delete();
        return redirect()->route('Back_end.picture')->with('success', 'លុបរូបភាពបានជោគជ័យ');
    }
    public function picture_alldestroy()
    {
        return view('Back_end.picture_alldestroy');
    }
    public function picture_alldelete(){
        
        Picture::all()->each(function ($picture) {
            $picture->information_customers()->delete();
        });
        Picture::query()->delete();
        return redirect()->route('Back_end.picture')->with('success', 'លុបរូបភាពទាំងអស់បានជោគជ័យ');
    }
    public function Information_customerID_picture($id){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $pictures = Picture::find($id);
        $information_customers  = Information_customer::orderBy('id', 'DESC')->where('picture_id',$id)->get();
        return view('Back_end.Information_customerID_picture', compact('admins','pictures','information_customers'));
    }

    public function Information_customerID_edit_picture($id,$ID){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $pictures = Picture::find($ID);
        $information_customers  = Information_customer::find($id);
        return view('Back_end.Information_customerID_edit_picture', compact('admins','pictures','information_customers'));
    }

    public function Information_customerID_update_picture(Request $request, $id)
    {
        $information_customers = Information_customer::find($id);

        $information_customers->name_customer = $request->input('name_customer');
        $information_customers->phone_customer = $request->input('phone_customer');
        $information_customers->name_account_bank_customer = $request->input('name_account_bank_customer');
        $information_customers->number_account_bank_customer = $request->input('number_account_bank_customer');
        $information_customers->address_customer = $request->input('address_customer');
        $information_customers->picture_id = $request->input('picture_id');
            
        $information_customers->save();
        return redirect()->route('Back_end.Information_customerID_picture',['id' => $request->input('picture_id')])->with('success', 'កែប្រែព័ត៌មានអតិថិជនបានជោគជ័យ');

    }

    public function Information_customerID_destroy_picture($id,$ID){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $pictures = Picture::find($ID);
        $information_customers  = Information_customer::find($id);
        return view('Back_end.Information_customerID_destroy_picture', compact('admins','pictures','information_customers'));
    }

    public function Information_customerID_delete_picture($id){
        $information_customers = Information_customer::findOrfail($id);
        $information_customers->delete();
        return redirect()->route('Back_end.Information_customerID_picture',['id' => $information_customers->picture_id])->with('success', 'លុបព័ត៌មានអតិថិជនបានជោគជ័យ');
    }

    public function Information_customerID_alldestroy_picture($id)
    {
        $pictures = Picture::find($id);
        $information_customers  = Information_customer::orderBy('id', 'DESC')->where('picture_id',$id)->get();
        return view('Back_end.Information_customerID_alldestroy_picture',compact('pictures','information_customers'));
    }

    public function Information_customerID_alldelete_picture($picture_id){
        // Find all related category_clothe records
        $information_customers = Information_customer::where('picture_id', $picture_id)->get();
    
        // Check if any records exist
        if ($information_customers->isEmpty()) {
            return redirect()->back()->with('error', 'មិនមានព័ត៌មានអតិថិជនដែលត្រូវលុប');
        }
        foreach ($information_customers as $information_customer) {
            $information_customer->delete();
        }
        return redirect()->route('Back_end.Information_customerID_picture', ['id' => $picture_id])->with('success', 'លុបព័ត៌មានអតិថិជនទាំងអស់បានជោគជ័យ');
    }

    public function search_picture(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = Picture::where('image_picture', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_picture', compact("results","query",'admins'));

    }

}
