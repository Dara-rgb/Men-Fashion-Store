<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Category_clothe;
use App\Models\Category_fabric;
use App\Models\Post;

class CategoryFabricController extends Controller
{
    public function category_fabric(){
        $category_fabrics = Category_fabric::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.category_fabric', compact('category_fabrics','admins'));
    }
    public function category_fabric_create(){
        $category_fabrics = Category_fabric::orderBy('id', 'DESC')->get();

        return view('Back_end.category_fabric_create', compact('category_fabrics'));
    }

    public function category_fabric_store(Request $request){
        $request->validate([
            'text_fabrics'=>'required',
        ]);

        Category_fabric::create([
            'text_fabrics' => $request->input('text_fabrics'),
        ]);

        return redirect()->route('Back_end.category_fabric')->with('success', 'ប្រភេទសាច់ក្រណាត់បញ្ចូលបានជោគជ័យ');
    }
    public function category_fabric_edit($id)
    {
        
        $category_fabrics = Category_fabric::find($id);

        return view('Back_end.category_fabric_edit', compact('category_fabrics'));
    }

    public function category_fabric_update(Request $request, $id)
    {
        $category_fabrics = Category_fabric::find($id);
        $category_fabrics->text_fabrics = $request->input('text_fabrics');
            
        $category_fabrics->save();
        return redirect()->route('Back_end.category_fabric')->with('success', 'ប្រភេទសាច់ក្រណាត់កែប្រែបានជោគជ័យ');
    }
    public function category_fabric_destroy($id)
    {
        
        $category_fabrics = Category_fabric::find($id);
        return view('Back_end.category_fabric_destroy', compact('category_fabrics'));
    }
    public function category_fabric_delete($id){
        $category_fabrics = Category_fabric::findOrfail($id);
        foreach ($category_fabrics->posts as $post) {
            foreach($post->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $post->pictures()->delete();
        }
        $category_fabrics->posts()->delete();
        $category_fabrics->delete();
        return redirect()->route('Back_end.category_fabric')->with('success', 'ប្រភេទសាច់ក្រណាត់លុបបានជោគជ័យ');
    }
    public function category_fabric_alldestroy()
    {
        return view('Back_end.category_fabric_alldestroy');
    }
    public function category_fabric_alldelete(){
        Category_fabric::all()->each(function ($category_fabrics) {
            foreach ($category_fabrics->posts as $post) {
                foreach($post->pictures as $picture){
                    $picture->information_customers()->delete();
                }
                $post->pictures()->delete();
            }
            $category_fabrics->posts()->delete();
        });
        Category_fabric::query()->delete();
        return redirect()->route('Back_end.category_fabric')->with('success', 'ប្រភេទសាច់ក្រណាត់លុបទាំងអស់បានជោគជ័យ');
    }

    public function postID_category_fabric($id)
    {
        $category_fabrics = Category_fabric::find($id);
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $post  = Post::orderBy('id', 'DESC')->where('category_fabric_id',$id)->get();
        return view('Back_end.postID_category_fabric', compact('post','category_fabrics','admins'));
    }
    public function postID_category_fabric_create($id){
        $category_fabrics = Category_fabric::find($id);
        $category_clothes = Category_clothe::orderBy('id', 'DESC')->get();
        
        return view('Back_end.postID_category_fabric_create', compact('category_clothes','category_fabrics'));
    }
    public function postID_category_fabric_store(Request $request){
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

        return redirect()->route('Back_end.postID_category_fabric',['id' => $request->input('category_fabric_id')])->with('success', 'បញ្ចូលការបង្ហោះបានជោគជ័យ');
    }
    public function postID_category_fabric_edit($id,$Id,$ID)
    {
        
        $category_clothes = Category_clothe::orderByRaw('id = ? DESC', [$Id])->get();
        $category_fabrics = Category_fabric::find($ID);
        $post = Post::find($id);

        return view('Back_end.postID_category_fabric_edit', compact('post','category_clothes','category_fabrics'));
    }
    public function postID_category_fabric_update(Request $request, $id)
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
        return redirect()->route('Back_end.postID_category_fabric',['id' => $request->input('category_fabric_id')])->with('success', 'កែប្រែការបង្ហោះបានជោគជ័យ');
    }
    public function  postID_category_fabric_destroy($id,$Id,$ID)
    {
        $category_clothes = Category_clothe::orderByRaw('id = ? DESC', [$Id])->get();
        $category_fabrics = Category_fabric::find($ID);
        $post = Post::find($id);

        return view('Back_end.postID_category_fabric_destroy', compact('post','category_clothes','category_fabrics'));
    }
    public function postID_category_fabric_delete($id){
        $post = Post::findOrfail($id);
        foreach($post->pictures as $picture){
            $picture->information_customers()->delete();
        }
        $post->pictures()->delete();
        $post->delete();
        return redirect()->route('Back_end.postID_category_fabric',['id' => $post->category_fabric_id])->with('success', 'លុបការបង្ហោះបានជោគជ័យ');
    }
    public function postID_category_fabric_alldestroy($id)
    {
        $category_fabrics = Category_fabric::orderByRaw('id = ? DESC', [$id])->get();
        $category_clothes = Category_clothe::orderBy('id', 'DESC')->get();
        $post  = Post::orderBy('id', 'DESC')->where('category_fabric_id',$id)->get();

        return view('Back_end.postID_category_fabric_alldestroy', compact('post','category_clothes','category_fabrics'));
    }
    public function postID_category_fabric_alldelete($category_fabric_id)
    {
        // Find all related category_clothe records
        $post = Post::where('category_fabric_id', $category_fabric_id)->get();
    
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
        return redirect()->route('Back_end.postID_category_fabric', ['id' => $category_fabric_id])->with('success', 'ការបង្ហោះត្រូវបានលុបទាំងអស់ដោយជោគជ័យ');
    }
    public function search_category_fabric(Request $request){
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        $query = $request->input('query');
        $results = Category_fabric::where('text_fabrics', 'like', '%' . $query . '%')->get();

        return view('Back_end.search_category_fabric', compact("results","query",'admins'));

}
}
