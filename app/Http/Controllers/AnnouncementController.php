<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function announcement(){
        $announcements = Announcement::orderBy('id', 'DESC')->limit(1)->get();
        $admins = Admin::orderBy('id', 'DESC')->limit(1)->get();
        return view('Back_end.announcement', compact('announcements','admins'));
    }

    public function announcement_create(Request $request){
        
        return view('Back_end.announcement_create');
    }

    public function announcement_store(Request $request){
        $request->validate([
        'content' => 'required',
        ]);

        Announcement::create([
            'content'   => $request->input('content'),
            // បើមាន Tick នោះ $request->is_active នឹងមានតម្លៃ (true) បើអត់ទេ គឺ false
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('Back_end.announcement')->with('success', 'អក្សររត់បញ្ចូលបានជោគជ័យ');
    }

    public function announcement_edit($id)
    {
        $announcements = Announcement::findOrFail($id);
        return view('Back_end.announcement_edit', compact('announcements'));
    }

    public function announcement_update(Request $request, $id)
    {
        $announcements = Announcement::findOrFail($id);
        $announcements->content = $request->input('content');
        $announcements->is_active = $request->has('is_active');
            
        $announcements->save();
        return redirect()->route('Back_end.announcement')->with('success', 'អក្សររត់កែប្រែបានជោគជ័យ');
    }
    
    public function announcement_destroy($id)
    {
        $announcements = Announcement::findOrFail($id);
        return view('Back_end.announcement_destroy', compact('announcements'));
    }

    public function announcement_delete($id){
        $announcements = Announcement::findOrfail($id);
        
        $announcements->delete();
        return redirect()->route('Back_end.announcement')->with('success', 'អក្សររត់លុបបានជោគជ័យ');
    }

    public function announcement_alldestroy()
    {
        return view('Back_end.announcement_alldestroy');
    }

    public function announcement_alldelete(){
        
        Announcement::query()->delete();
        return redirect()->route('Back_end.announcement')->with('success', 'លុបអក្សររត់ទាំងអស់បានជោគជ័យ');
    }

    public function toggleStatus($id)
    {
        $item = Announcement::findOrFail($id);
        // ប្តូរតម្លៃ៖ បើ ១ ទៅ ០, បើ ០ ទៅ ១
        $item->is_active = !$item->is_active;
        $item->save();

        return redirect()->back()->with('success', 'ស្ថានភាពអក្សររត់ត្រូវបានផ្លាស់ប្តូរ!');
    }
    //{{ route('Back_end.announcement_toggle', $st->id) }}
}
