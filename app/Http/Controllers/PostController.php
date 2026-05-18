<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Clothe;
use App\Models\Category_clothe;
use App\Models\Category_fabric;
use App\Models\Post;
use App\Models\Contact;
use App\Models\size;
use App\Models\Picture;

class PostController extends Controller
{
    public function post(){
        $post = Post::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.post', compact('post','admins'));
    }
    public function post_create(Request $request){
        $category_clothes = Category_clothe::orderBy('id', 'ASC')->get();
        $category_fabrics = Category_fabric::orderBy('id', 'ASC')->get();
   
        return view('Back_end.post_create', compact('category_clothes','category_fabrics'));
    }

    public function post_store(Request $request){
        $request->validate([
            'caption'=>'required',
            'image' => 'required|image|max:51200',
            'price'=>'required',
            'brand'=>'required',
            'category_clothe_id'=>'required|integer|exists:category_clothes,id',
            'category_fabric_id'=>'required|integer|exists:category_fabrics,id',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        } else {
            return back()->with('error', 'Image is required.');
        }
        Post::create([
            'caption' => $request->input('caption'),
            'image' => $path,
            'price' => $request->input('price'),
            'brand' => $request->input('brand'),
            'category_clothe_id' => $request->input('category_clothe_id'),
            'category_fabric_id' => $request->input('category_fabric_id'),
            'view' => 0, // add this line
        ]);

        return redirect()->route('Back_end.post')->with('success', 'បញ្ចូលការបង្ហោះបានជោគជ័យ');
    }
    public function post_edit($id,$Id,$ID)
    {
        
        $category_clothes = Category_clothe::orderByRaw('id = ? DESC', [$Id])->get();
        $category_fabrics = Category_fabric::orderByRaw('id = ? DESC', [$ID])->get();
        $post = Post::find($id);

        return view('Back_end.post_edit', compact('post','category_clothes','category_fabrics'));
    }

    public function post_update(Request $request, $id)
    {
        $post = Post::find($id);


        // Check if a new file is uploaded
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); // Save the file in the 'images' directory within 'storage/app/public'
        } else {
            $path = $post->image; // Keep the existing image if no new file is uploaded
        }

        $post->caption = $request->input('caption');
        $post->image = $path;
        $post->price = $request->input('price');
        $post->brand = $request->input('brand');
        $post->category_clothe_id = $request->input('category_clothe_id');
        $post->category_fabric_id = $request->input('category_fabric_id');
            
        $post->save();
        return redirect()->route('Back_end.post')->with('success', 'កែប្រែការបង្ហោះបានជោគជ័យ');
    }
    public function post_destroy($id,$Id,$ID)
    {
        $category_clothes = Category_clothe::orderByRaw('id = ? DESC', [$Id])->get();
        $category_fabrics = Category_fabric::orderByRaw('id = ? DESC', [$ID])->get();
        $post = Post::find($id);

        return view('Back_end.post_destroy', compact('post','category_clothes','category_fabrics'));
    }
    public function post_delete($id){
        $post = Post::findOrfail($id);
        foreach($post->pictures as $picture){
            $picture->information_customers()->delete();
        }
        $post->pictures()->delete();
        $post->delete();
        return redirect()->route('Back_end.post')->with('success', 'លុបការបង្ហោះបានជោគជ័យ');
    }

    public function post_alldestroy()
    {
        return view('Back_end.post_alldestroy');
    }
    public function post_alldelete(){
        Post::all()->each(function ($post) {
            foreach($post->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $post->pictures()->delete();
        });
        Post::query()->delete();
        return redirect()->route('Back_end.post')->with('success', 'លុបការបង្ហោះទាំងអស់បានជោគជ័យ');
    }

    public function pictureID_post($id)
    {
        $post = Post::find($id);
        $pictures  = Picture::orderBy('id', 'DESC')->where('post_id',$id)->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.pictureID_post', compact('pictures','post','admins'));
    }
    public function pictureID_post_create($id){
        $post = Post::find($id);
        $contact = Contact::orderBy('id', 'ASC')->get();
        $sizes = size::orderBy('id', 'ASC')->get();
        return view('Back_end.pictureID_post_create', compact('post','contact','sizes'));
    }
    public function pictureID_post_store(Request $request)
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
        return redirect()->route('Back_end.pictureID_post',['id' => $request->input('post_id')])->with('success', 'បញ្ចូលរូបភាពបានជោគជ័យ');
    }
    public function pictureID_post_edit($id,$Id,$ID,$sid)
    {
        
        $post = Post::find($Id);
        $contact = Contact::orderByRaw('id = ? DESC', [$ID])->get();
        $sizes = size::orderByRaw('id = ? DESC', [$sid])->get();
        $pictures = Picture::find($id);

        return view('Back_end.pictureID_post_edit', compact('pictures','post','contact','sizes'));
    }
    public function pictureID_post_update(Request $request, $id)
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
        return redirect()->route('Back_end.pictureID_post',['id' => $request->input('post_id')])->with('success', 'កែប្រែរូបភាពបានជោគជ័យ');
    }
    public function  pictureID_post_destroy($id,$Id,$ID,$sid)
    {
        $post = Post::find($Id);
        $contact = Contact::orderByRaw('id = ? DESC', [$ID])->get();
        $sizes = size::orderByRaw('id = ? DESC', [$sid])->get();
        $pictures = Picture::find($id);

        return view('Back_end.pictureID_post_destroy', compact('pictures','post','contact','sizes'));
    }
    public function pictureID_post_delete($id){
        $pictures = Picture::findOrfail($id);
        
        $picture->information_customers()->delete();
        $pictures->delete();
        return redirect()->route('Back_end.pictureID_post',['id' => $pictures->post_id])->with('success', 'លុបរូបភាពបានជោគជ័យ');
    }
    public function pictureID_post_alldestroy($id)
    {
        $post = Post::orderByRaw('id = ? DESC', [$id])->get();
        $contact = Contact::orderBy('id', 'DESC')->get();
        $sizes = size::orderBy('id', 'DESC')->get();
        $pictures  = Picture::orderBy('id', 'DESC')->where('post_id',$id)->get();

        return view('Back_end.pictureID_post_alldestroy', compact('pictures','contact','post','sizes'));
    }
    public function pictureID_post_alldelete($post_id){
        // Find all related category_clothe records
        $pictures = Picture::where('post_id', $post_id)->get();
    
        // Check if any records exist
        if ($pictures->isEmpty()) {
            return redirect()->back()->with('error', 'មិនមានរូបភាពដែលត្រូវលុប');
        }
        foreach ($pictures as $picture) {
            $picture->information_customers()->delete();
            $picture->delete();
        }
        return redirect()->route('Back_end.pictureID_post', ['id' => $post_id])->with('success', 'លុបរូបភាពទាំងអស់បានជោគជ័យ');
    }
    public function search_post(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = Post::where('caption', 'like', '%' . $query . '%')->orwhere( 'price', 'like', '%' . $query . '%')->orwhere( 'brand', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_post', compact("results","query",'admins'));

    }
}
