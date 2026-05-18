<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Contact;
use App\Models\size;
use App\Models\Picture;


class SizeController extends Controller
{
    public function size(){
        $sizes = size::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.size', compact('sizes','admins'));
    }
    public function size_create(){
        return view('Back_end.size_create');
    }
    public function size_store(Request $request){
        $request->validate([
            'text_size'=>'required',
        ]);

        size::create([
            'text_size' => $request->input('text_size'),
        ]);

        return redirect()->route('Back_end.size')->with('success', 'ទំហំបញ្ចូលបានជោគជ័យ');
    }
    public function size_edit($id)
    {
        $sizes = size::find($id);
        return view('Back_end.size_edit', compact('sizes'));
    }
    public function size_update(Request $request, $id)
    {
        $sizes = size::find($id);
        $sizes->text_size = $request->input('text_size');
            
        $sizes->save();
        return redirect()->route('Back_end.size')->with('success', 'ទំហំកែប្រែបានជោគជ័យ');
    }
    public function size_destroy($id)
    {
        
        $sizes = size::find($id);

        return view('Back_end.size_destroy', compact('sizes'));
    }
    public function size_delete($id){
        $sizes = size::findOrfail($id);
        foreach($sizes->pictures as $picture){
            $picture->information_customers()->delete();
        }
        $sizes->pictures()->delete();
        $sizes->delete();
        return redirect()->route('Back_end.size')->with('success', 'លុបទំហំបានជោគជ័យ');
    }
    public function size_alldestroy()
    {
        return view('Back_end.size_alldestroy');
    }
    public function size_alldelete(){
        size::all()->each(function ($sizes) {
            foreach($sizes->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $sizes->pictures()->delete();
        });
        size::query()->delete();
        return redirect()->route('Back_end.size')->with('success', 'លុបទំហំទាំងអស់បានជោគជ័យ');
    }
    public function pictureID_size($id)
    {
        $sizes = size::find($id);
        $pictures  = Picture::orderBy('id', 'DESC')->where('size_id',$id)->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.pictureID_size', compact('pictures','sizes','admins'));
    }
    public function pictureID_size_create($id){
        $sizes = size::find($id);
        $post = Post::orderBy('id', 'DESC')->get();
        $contact = Contact::orderBy('id', 'ASC')->get();
        return view('Back_end.pictureID_size_create', compact('post','contact','sizes'));
    }
    public function pictureID_size_store(Request $request)
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
        return redirect()->route('Back_end.pictureID_size',['id' => $request->input('size_id')])->with('success', 'បញ្ចូលរូបភាពបានជោគជ័យ');
    }
    public function pictureID_size_edit($id,$Id,$ID,$sid)
    {
        $post = Post::orderByRaw('id = ? DESC', [$Id])->get();
        $contact = Contact::orderByRaw('id = ? DESC', [$ID])->get();
        $sizes = size::find($sid);
        $pictures = Picture::find($id);

        return view('Back_end.pictureID_size_edit', compact('pictures','post','contact','sizes'));
    }
    public function pictureID_size_update(Request $request, $id)
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
        return redirect()->route('Back_end.pictureID_size',['id' => $request->input('size_id')])->with('success', 'កែប្រែរូបភាពបានជោគជ័យ');
    }
    public function  pictureID_size_destroy($id,$Id,$ID,$sid)
    {
        $post = Post::orderByRaw('id = ? DESC', [$Id])->get();
        $contact = Contact::orderByRaw('id = ? DESC', [$ID])->get();
        $sizes = size::find($sid);
        $pictures = Picture::find($id);

        return view('Back_end.pictureID_size_destroy', compact('pictures','post','contact','sizes'));
    }
    public function pictureID_size_delete($id){
        $pictures = Picture::findOrfail($id);
        $picture->information_customers()->delete();
        $pictures->delete();
        return redirect()->route('Back_end.pictureID_size',['id' => $pictures->size_id])->with('success', 'លុបរូបភាពបានជោគជ័យ');
    }
    public function pictureID_size_alldestroy($id)
    {
        $sizes = size::orderByRaw('id = ? DESC', [$id])->get();
        $post = Post::orderBy('id', 'DESC')->get();
        $contact = Contact::orderBy('id', 'DESC')->get();
        $pictures  = Picture::orderBy('id', 'DESC')->where('size_id',$id)->get();

        return view('Back_end.pictureID_size_alldestroy', compact('pictures','sizes','contact','post'));
    }
    public function pictureID_size_alldelete($size_id){
        // Find all related category_clothe records
        $pictures = Picture::where('size_id', $size_id)->get();
    
        // Check if any records exist
        if ($pictures->isEmpty()) {
            return redirect()->back()->with('error', 'មិនមានរូបភាពដែលត្រូវលុប');
        }
        foreach ($pictures as $picture) {
            $picture->information_customers()->delete();
            $picture->delete();
        }
        return redirect()->route('Back_end.pictureID_size', ['id' => $size_id])->with('success', 'លុបរូបភាពទាំងអស់បានជោគជ័យ');
    }
    public function search_size(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = size::where('text_size', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_size', compact("results","query",'admins'));

    }
}
