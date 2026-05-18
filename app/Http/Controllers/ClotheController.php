<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Clothe;
use App\Models\Category_clothe;

class ClotheController extends Controller
{
    public function clothe(){
        $clothes = Clothe::orderBy('id', 'DESC')->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.clothe', compact('clothes','admins'));
    }

    public function clothe_create(){
        return view('Back_end.clothe_create');
    }

    public function clothe_store(Request $request){
        $request->validate([
            'text'=>'required',
        ]);

        Clothe::create([
            'text' => $request->input('text'),
        ]);

        return redirect()->route('Back_end.clothe')->with('success', 'សម្លៀកបំពាក់បញ្ចូលបានជោគជ័យ');
    }

    public function clothe_edit($id)
    {
        $clothes = Clothe::find($id);
        return view('Back_end.clothe_edit', compact('clothes'));
    }

    public function clothe_update(Request $request, $id)
    {
        $clothes = Clothe::find($id);
        $clothes->text = $request->input('text');
            
        $clothes->save();
        return redirect()->route('Back_end.clothe')->with('success', 'សម្លៀកបំពាក់កែប្រែបានជោគជ័យ');
    }

    public function clothe_destroy($id)
    {
        $clothes = Clothe::find($id);
        return view('Back_end.clothe_destroy', compact('clothes'));
    }
    public function clothe_delete($id){
        $clothes = Clothe::findOrfail($id);
        
        foreach ($clothes->category_clothes as $category_clothe) {
        
            foreach ($category_clothe->posts as $post) {

                foreach($post->pictures as $picture){
                    $picture->information_customers()->delete();
                }
                $post->pictures()->delete(); // Delete pictures
            }
            $category_clothe->posts()->delete(); // Delete posts
        }
        /*foreach ($clothes->category_clothes as $category_clothe) {
            $category_clothe->posts()->delete();
            foreach ($category_clothe->posts as $post) {
                $post->pictures()->delete();
            }
        }*/
        $clothes->category_clothes()->delete();
        $clothes->delete();
        return redirect()->route('Back_end.clothe')->with('success', 'សម្លៀកបំពាក់លុបបានជោគជ័យ');
    }
    public function clothe_alldestroy()
    {
        return view('Back_end.clothe_alldestroy');
    }
    public function clothe_alldelete(){
        Clothe::all()->each(function ($clothes) {
            foreach ($clothes->category_clothes as $category_clothe) {
                foreach ($category_clothe->posts as $post) {
                    foreach($post->pictures as $picture){
                        $picture->information_customers()->delete();
                    }
                    $post->pictures()->delete(); // Delete pictures
                }
                $category_clothe->posts()->delete(); // Delete posts
            }
            $clothes->category_clothes()->delete(); // Delete category_clothes
        });

        Clothe::query()->delete();
        return redirect()->route('Back_end.clothe')->with('success', 'សម្លៀកបំពាក់លុបទាំងអស់បានជោគជ័យ');
    }
    public function category_clotheID($id)
    {
        $clothes = Clothe::find($id);
        $category_clothes  = Category_clothe::orderBy('id', 'DESC')->where('clothe_id',$id)->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.category_clotheID', compact('category_clothes','clothes','admins'));
    }
    public function category_clotheID_create($id){
        $clothes = Clothe::find($id);
        return view('Back_end.category_clotheID_create', compact('clothes'));
    }
    public function category_clotheID_store(Request $request){
        $request->validate([
            'text_clothes'=>'required',
            'clothe_id'=>'required|integer|exists:clothes,id',
        ]);

        Category_clothe::create([
            'text_clothes' => $request->input('text_clothes'),
            'clothe_id' => $request->input('clothe_id'),
        ]);

        return redirect()->route('Back_end.category_clotheID',['id' => $request->input('clothe_id')])->with('success', 'ប្រភេទសម្លៀកបំពាក់បញ្ចូលបានជោគជ័យ');
    }
    public function category_clotheID_edit($id,$ID)
    {
        
        $clothes = Clothe::find($ID);
        $category_clothes = Category_clothe::find($id);

        return view('Back_end.category_clotheID_edit', compact('clothes','category_clothes'));
    }
    public function category_clotheID_update(Request $request, $id)
    {
        $category_clothes = Category_clothe::find($id);
        $category_clothes->text_clothes = $request->input('text_clothes');
        $category_clothes->clothe_id = $request->input('clothe_id');
            
        $category_clothes->save();
        return redirect()->route('Back_end.category_clotheID',['id' => $request->input('clothe_id')])->with('success', 'ប្រភេទសម្លៀកបំពាក់កែប្រែបានជោគជ័យ');
    }
    public function category_clotheID_destroy($id,$ID)
    {
        $clothes = Clothe::find($ID);
        $category_clothes = Category_clothe::find($id);
        return view('Back_end.category_clotheID_destroy', compact('clothes','category_clothes'));
    }
    public function category_clotheID_delete($id){
        $category_clothes = Category_clothe::findOrfail($id);
        foreach ($category_clothes->posts as $post) {
            foreach($post->pictures as $picture){
                $picture->information_customers()->delete();
            }
            $post->pictures()->delete();
        }
        $category_clothes->posts()->delete();
        $category_clothes->delete();
        return redirect()->route('Back_end.category_clotheID',['id' => $category_clothes->clothe_id])->with('success', 'ប្រភេទសម្លៀកបំពាក់លុបបានជោគជ័យ');
    }
    public function category_clotheID_alldestroy($id){
        $clothes = Clothe::orderByRaw('id = ? DESC', [$id])->get();
        $category_clothes  = Category_clothe::orderBy('id', 'DESC')->where('clothe_id',$id)->get();
        return view('Back_end.category_clotheID_alldestroy', compact('clothes','category_clothes'));
    }
    public function category_clotheID_alldelete($clothe_id)
    {
        // Find all related category_clothe records
        $category_clothes = Category_clothe::where('clothe_id', $clothe_id)->get();
    
        // Check if any records exist
        if ($category_clothes->isEmpty()) {
            return redirect()->back()->with('error', 'មិនមានប្រភេទសម្លៀកបំពាក់ដែលត្រូវលុប');
        }
    
        // Loop through each category_clothe record
        foreach ($category_clothes as $category_clothe) {
            // Ensure posts relationship exists
            
                // Delete pictures related to each post
                foreach ($category_clothe->posts as $post) {
                    
                    foreach($post->pictures as $picture){
                        $picture->information_customers()->delete();
                    }
                    $post->pictures()->delete();
                }
                // Delete the posts
                $category_clothe->posts()->delete();
            
    
            // Delete the category_clothe entry
            $category_clothe->delete();
        }
    
        // Redirect after deletion
        return redirect()->route('Back_end.category_clotheID', ['id' => $clothe_id])
                         ->with('success', 'ប្រភេទសម្លៀកបំពាក់ត្រូវបានលុបទាំងអស់ដោយជោគជ័យ');
    }
    public function search_clothe(Request $request){
            $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
            $query = $request->input('query');
            $results = Clothe::where('text', 'like', '%' . $query . '%')->get();
    
            return view('Back_end.search_clothe', compact("results","query",'admins'));
    
    }
    
}
