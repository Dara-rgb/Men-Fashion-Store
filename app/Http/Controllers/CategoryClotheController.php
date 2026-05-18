<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Clothe;
use App\Models\Category_clothe;
use App\Models\Category_fabric;
use App\Models\Post;

class CategoryClotheController extends Controller
{
    public function category_clothe(){
        $category_clothes = Category_clothe::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.category_clothe', compact('category_clothes','admins'));
    }
    public function category_clothe_create(){
        $clothes = Clothe::orderBy('id', 'ASC')->get();

        return view('Back_end.category_clothe_create', compact('clothes'));
    }

    public function category_clothe_store(Request $request){
        $request->validate([
            'text_clothes'=>'required',
            'clothe_id'=>'required|integer|exists:clothes,id',
        ]);

        Category_clothe::create([
            'text_clothes' => $request->input('text_clothes'),
            'clothe_id' => $request->input('clothe_id'),
        ]);

        return redirect()->route('Back_end.category_clothe')->with('success', 'ប្រភេទសម្លៀកបំពាក់បញ្ចូលបានជោគជ័យ');
    }
    public function category_clothe_edit($id,$ID)
    {
        
        $clothes = Clothe::orderByRaw('id = ? DESC', [$ID])->get();
        $category_clothes = Category_clothe::find($id);

        return view('Back_end.category_clothe_edit', compact('clothes','category_clothes'));
    }

    public function category_clothe_update(Request $request, $id)
    {
        $category_clothes = Category_clothe::find($id);
        $category_clothes->text_clothes = $request->input('text_clothes');
        $category_clothes->clothe_id = $request->input('clothe_id');
            
        $category_clothes->save();
        return redirect()->route('Back_end.category_clothe')->with('success', 'ប្រភេទសម្លៀកបំពាក់កែប្រែបានជោគជ័យ');
    }
    public function category_clothe_destroy($id,$ID)
    {
        $clothes = Clothe::orderByRaw('id = ? DESC', [$ID])->get();
        $category_clothes = Category_clothe::find($id);
        return view('Back_end.category_clothe_destroy', compact('clothes','category_clothes'));
    }
    public function category_clothe_delete($id){
        $category_clothes = Category_clothe::findOrfail($id);
        foreach ($category_clothes->posts as $post) {
            foreach($post->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $post->pictures()->delete();
        }
        $category_clothes->posts()->delete();
        $category_clothes->delete();
        return redirect()->route('Back_end.category_clothe')->with('success', 'ប្រភេទសម្លៀកបំពាក់លុបបានជោគជ័យ');
    }
    public function category_clothe_alldestroy()
    {
        return view('Back_end.category_clothe_alldestroy');
    }
    public function category_clothe_alldelete(){
        Category_clothe::all()->each(function ($category_clothes) {
            foreach ($category_clothes->posts as $post) {
                foreach($post->pictures as $picture){
                    $picture->information_customers()->delete();
                }
                $post->pictures()->delete();
            }
            $category_clothes->posts()->delete();
        });
        Category_clothe::query()->delete();
        return redirect()->route('Back_end.category_clothe')->with('success', 'ប្រភេទសម្លៀកបំពាក់លុបទាំងអស់បានជោគជ័យ');
    }

    public function postID_category_clothe($id)
    {
        $category_clothes = Category_clothe::find($id);
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $post  = Post::orderBy('id', 'DESC')->where('category_clothe_id',$id)->get();
        return view('Back_end.postID_category_clothe', compact('post','category_clothes','admins'));
    }
    public function postID_category_clothe_create($id){
        $category_clothes = Category_clothe::find($id);
        $category_fabrics = Category_fabric::orderBy('id', 'DESC')->get();

        return view('Back_end.postID_category_clothe_create', compact('category_clothes','category_fabrics'));
    }
    public function postID_category_clothe_store(Request $request){
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

        return redirect()->route('Back_end.postID_category_clothe',['id' => $request->input('category_clothe_id')])->with('success', 'បញ្ចូលការបង្ហោះបានជោគជ័យ');
    }
    public function postID_category_clothe_edit($id,$Id,$ID)
    {
        
        $category_clothes = Category_clothe::find($Id);
        $category_fabrics = Category_fabric::orderByRaw('id = ? DESC', [$ID])->get();
        $post = Post::find($id);

        return view('Back_end.postID_category_clothe_edit', compact('post','category_clothes','category_fabrics'));
    }
    public function postID_category_clothe_update(Request $request, $id)
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
        return redirect()->route('Back_end.postID_category_clothe',['id' => $request->input('category_clothe_id')])->with('success', 'កែប្រែការបង្ហោះបានជោគជ័យ');
    }
    public function postID_category_clothe_destroy($id,$Id,$ID)
    {
        $category_clothes = Category_clothe::find($Id);
        $category_fabrics = Category_fabric::orderByRaw('id = ? DESC', [$ID])->get();
        $post = Post::find($id);

        return view('Back_end.postID_category_clothe_destroy', compact('post','category_clothes','category_fabrics'));
    }
    public function postID_category_clothe_delete($id){
        $post = Post::findOrfail($id);
        foreach($post->pictures as $picture){
            $picture->information_customers()->delete();
        }
        $post->pictures()->delete();
        $post->delete();
        return redirect()->route('Back_end.postID_category_clothe',['id' => $post->category_clothe_id])->with('success', 'លុបការបង្ហោះបានជោគជ័យ');
    }
    public function postID_category_clothe_alldestroy($id)
    {
        $category_clothes = Category_clothe::orderByRaw('id = ? DESC', [$id])->get();
        $category_fabrics = Category_fabric::orderBy('id', 'DESC')->get();
        $post  = Post::orderBy('id', 'DESC')->where('category_clothe_id',$id)->get();

        return view('Back_end.postID_category_clothe_alldestroy', compact('post','category_clothes','category_fabrics'));
    }
    public function postID_category_clothe_alldelete($category_clothe_id)
    {
        // Find all related category_clothe records
        $post = Post::where('category_clothe_id', $category_clothe_id)->get();
    
        // Check if any records exist
        if ($post->isEmpty()) {
            return redirect()->back()->with('error', 'មិនមានការបង្ហោះដែលត្រូវលុប');
        }
    
        foreach ($post as $pos) {   
            foreach($pos->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $pos->pictures()->delete();
            $pos->delete();
        }

    
        // Redirect after deletion
        return redirect()->route('Back_end.postID_category_clothe', ['id' => $category_clothe_id])->with('success', 'ការបង្ហោះត្រូវបានលុបទាំងអស់ដោយជោគជ័យ');
    }
    public function search_category_clothe(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = Category_clothe::where('text_clothes', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_category_clothe', compact("results","query",'admins'));

}
}
