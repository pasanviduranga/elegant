<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use DB;
use App\Mail\InviteMail;
use Illuminate\Support\Facades\Mail;

class FriendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['update']]);
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    
    /**
     * Load friend list by login user
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $friends = DB::table('friends')->where(['status'=>1,'user_id'=>auth()->user()->id])->paginate(5);
        return view('friend.list', compact('friends'));
    }

    /**
     * Search list of friends
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request){

        if($request->ajax()){
            
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $friends = DB::table('friends')->where('status',"=",'1')->where('name', 'like', '%'.$query.'%')->paginate(5);
            return view('friend.pagination_data', compact('friends'))->render();            
        }
            
    }

    /**
     * Delete friend
     * 
     * 
     */
    public function destroy(Friend $friend){
        $friend->delete($friend);

        return redirect('/friends');
    }

    /**
     * load invite friend form
     */
    public function invite(){
        return view('friend.invite');
    }

    /**
     * save friend and send invitation mail to friend
     */
    public function store(){
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $friend = auth()->user()->friends()->create($data);
        
        $name = auth()->user()->firstname.' '.auth()->user()->lastname;
        $url = url('friends/accept/'.$friend->id);

        Mail::to(request('email'))->send(new InviteMail($name,$url));

        return redirect('/friends/invite')->with('success', "Your invitation successfully send.");
    }

    /**
     * update friend status, when friend accept the invitation
     */
    public function update(Friend $friend){
        $accept = DB::table('friends')->where(['id' => $friend->id, 'status' => 0])->update(['status' => 1]);
        if($accept){
            $status = 'success';
            $message = 'Your invitation successfully accepted.';
        }else{
            $status = 'error';
            $message = 'Already accepted.';
        }
        return redirect('/login')->with($status, $message);
    }
}
