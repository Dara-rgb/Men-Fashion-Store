<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Contact;
use App\Models\size;
use App\Models\Picture;

class ContactController extends Controller
{
    public function contact(){
        $contact = Contact::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $contacts = Contact::with('pictures.information_customers.picture.post')->get();
        $contactTotals = [];

        foreach ($contacts as $contac) {
            $total = 0;

            foreach ($contac->pictures as $picture) {
                foreach ($picture->information_customers as $info) {
                    $price = $info->picture?->post?->price ?? 0;
                    $total += $price * $info->number_items;
                }
            }

            $contactTotals[$contac->id] = $total;
        }
        return view('Back_end.contact', compact('contact','admins', 'contactTotals'));
    }
    public function contact_create(){
   
        return view('Back_end.contact_create');
    }

    public function contact_store(Request $request){
        $request->validate([
            'name_contact'=>'required',
            'phone_contact'=>'required',
            'image_contact' => 'required|image|max:51200',
            'link_payment'=>'required',
            'telegram_id'=>'required',
        ]);
        if ($request->hasFile('image_contact')) {
            $path = $request->file('image_contact')->store('images', 'public');
        } else {
            return back()->with('error', 'Image is required.');
        }
        Contact::create([
            
            'name_contact' => $request->input('name_contact'),
            'phone_contact' => $request->input('phone_contact'),
            'image_contact' => $path,
            'link_payment' => $request->input('link_payment'),
            'telegram_id' => $request->input('telegram_id'),
            
        ]);

        return redirect()->route('Back_end.contact')->with('success', 'បញ្ចូលទំនាក់ទំនងបានជោគជ័យ');
    }
    public function contact_edit($id)
    {
        
        $contact = Contact::find($id);

        return view('Back_end.contact_edit', compact('contact'));
    }

    public function contact_update(Request $request, $id)
    {
        $contact = Contact::find($id);


        // Check if a new file is uploaded
        if ($request->hasFile('image_contact')) {
            $path = $request->file('image_contact')->store('images', 'public'); // Save the file in the 'images' directory within 'storage/app/public'
        } else {
            $path = $contact->image_contact; // Keep the existing image if no new file is uploaded
        }

        $contact->name_contact = $request->input('name_contact');
        $contact->phone_contact = $request->input('phone_contact');
        $contact->image_contact = $path;
        $contact->link_payment = $request->input('link_payment');
        $contact->telegram_id = $request->input('telegram_id');
        
        $contact->save();
        return redirect()->route('Back_end.contact')->with('success', 'កែប្រែទំនាក់ទំនងបានជោគជ័យ');
    }
    public function contact_destroy($id)
    {
        
        $contact = Contact::find($id);

        return view('Back_end.contact_destroy', compact('contact'));
    }
    public function contact_delete($id){
        $contact = Contact::findOrfail($id);
        foreach($contact->pictures as $picture){
            $picture->information_customers()->delete();
        }
        $contact->pictures()->delete();
        $contact->delete();
        return redirect()->route('Back_end.contact')->with('success', 'លុបទំនាក់ទំនងបានជោគជ័យ');
    }

    public function contact_alldestroy()
    {
        return view('Back_end.contact_alldestroy');
    }
    public function contact_alldelete(){
        Contact::all()->each(function ($contact) {
            foreach($contact->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $contact->pictures()->delete();
        });
        Contact::query()->delete();
        return redirect()->route('Back_end.contact')->with('success', 'លុបទំនាក់ទំនងទាំងអស់បានជោគជ័យ');
    }

    public function pictureID_contact($id)
    {
        $contact = Contact::find($id);
        $pictures  = Picture::orderBy('id', 'DESC')->where('contact_id',$id)->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.pictureID_contact', compact('pictures','contact','admins'));
    }
    public function pictureID_contact_create($id){
        $contact = Contact::find($id);
        $post = Post::orderBy('id', 'DESC')->get();
        $sizes = size::orderBy('id', 'ASC')->get();
        return view('Back_end.pictureID_contact_create', compact('post','contact','sizes'));
    }
    public function pictureID_contact_store(Request $request)
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
        return redirect()->route('Back_end.pictureID_contact',['id' => $request->input('contact_id')])->with('success', 'បញ្ចូលរូបភាពបានជោគជ័យ');
    }
    public function pictureID_contact_edit($id,$Id,$ID,$sid)
    {
        
        $post = Post::orderByRaw('id = ? DESC', [$Id])->get();
        $contact = Contact::find($ID);
        $sizes = size::orderByRaw('id = ? DESC', [$sid])->get();
        $pictures = Picture::find($id);

        return view('Back_end.pictureID_contact_edit', compact('pictures','post','contact','sizes'));
    }
    public function pictureID_contact_update(Request $request, $id)
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
        return redirect()->route('Back_end.pictureID_contact',['id' => $request->input('contact_id')])->with('success', 'កែប្រែរូបភាពបានជោគជ័យ');
    }
    public function  pictureID_contact_destroy($id,$Id,$ID,$sid)
    {
        $post = Post::orderByRaw('id = ? DESC', [$Id])->get();
        $contact = Contact::find($ID);
        $sizes = size::orderByRaw('id = ? DESC', [$sid])->get();
        $pictures = Picture::find($id);

        return view('Back_end.pictureID_contact_destroy', compact('pictures','post','contact','sizes'));
    }
    public function pictureID_contact_delete($id){
        $pictures = Picture::findOrfail($id);

        $picture->information_customers()->delete();
        $pictures->delete();
        return redirect()->route('Back_end.pictureID_contact',['id' => $pictures->contact_id])->with('success', 'លុបរូបភាពបានជោគជ័យ');
    }
    public function pictureID_contact_alldestroy($id)
    {
        $contact = Contact::orderByRaw('id = ? DESC', [$id])->get();
        $post = Post::orderBy('id', 'DESC')->get();
        $sizes = size::orderBy('id', 'DESC')->get();
        $pictures  = Picture::orderBy('id', 'DESC')->where('contact_id',$id)->get();

        return view('Back_end.pictureID_contact_alldestroy', compact('pictures','contact','post','sizes'));
    }
    public function pictureID_contact_alldelete($contact_id){
        // Find all related category_clothe records
        $pictures = Picture::where('contact_id', $contact_id)->get();
    
        // Check if any records exist
        if ($pictures->isEmpty()) {
            return redirect()->back()->with('error', 'មិនមានរូបភាពដែលត្រូវលុប');
        }
        foreach ($pictures as $picture) {
            $picture->information_customers()->delete();
            $picture->delete();
        }
        return redirect()->route('Back_end.pictureID_contact', ['id' => $contact_id])->with('success', 'លុបរូបភាពទាំងអស់បានជោគជ័យ');
    }
    public function search_contact(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = Contact::where('name_contact', 'like', '%' . $query . '%')->orwhere( 'phone_contact', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_contact', compact("results","query",'admins'));

    }
}
