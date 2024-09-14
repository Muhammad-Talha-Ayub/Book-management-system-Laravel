<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Team;
// use phpseclib\Crypt\RSA; // Assuming this is your Author model
// use App\Helpers\RSAHelper;
use File;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $searchTerm =request()->get('s');
        $teams = Team::orWhere('fullname', 'LIKE' , "%$searchTerm%" )-> latest()->paginate(15);
     //latest means that data inserted in last will be shown at first
        return view('admin.team.index') ->with(compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.team.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
        'fullname' =>'required',
        'designation'=>'required',
        'email'=>'required',
        'team_img'=>'required|mimes:png,jpg,jpeg,gif|max:2048',
        'facebook_id'=>'required',
        'twitter_id'=>'required',
        'pinterest_id'=>'required'
        ]);
         $fileName =null;

        if(request()->hasFile('team_img'))
        {
            $file=request()->file('team_img');
            $fileName = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/',$fileName);
        }
        Team::create([
         'fullname' => request()->get('fullname'),
         'designation' => request()->get('designation'),
         'telephone' => request()->get('telephone'),
         'mobile' => request()->get('mobile'),
         'email' => request()->get('email'),
         'facebook_id' => request()->get('facebook_id'),
         'twitter_id' => request()->get('twitter_id'),
         'youtube_id' => request()->get('youtube_id'),
         'profile' => request()->get('description'),
         'pinterest_id' => request()->get('pinterest_id'),
         'team_img' => $fileName,
         'status'=> 'DEACTIVE'
        ]);
        // $encryptedFullName = RSAHelper::encryptData($request->input('title'));
        // $encryptedDesignation = RSAHelper::encryptData($request->input('designation'));

        // Author::create([
        //     'fullname' => $encryptedFullName,
        //     'designation' => $encryptedDesignation,
        // ]);
        $notification=[
            'message'=>'Record Inserted Sucsessfully',
            'alert-type'=>'success'

        ];
        return redirect()->to('/admin/team')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $team = Team::findOrFail($id);

        // // Decrypt data before passing it to the view
        // $decryptedFullName = RSAHelper::decryptData($team->fullname);
        // $decryptedDesignation = RSAHelper::decryptData($team->designation);

        // return view('team.show', [
        //     'team' => $team,
        //     'decryptedFullName' => $decryptedFullName,
        //     'decryptedDesignation' => $decryptedDesignation,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         
       $team= Team::find($id);
        return view('admin.team.edit')->with(compact(
            'team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team=Team::find($id); 
         $fileName =null;
          $currentImage = $team->team_img;
        if(request()->hasFile('team_img'))
        {
            $file=request()->file('team_img');
            $fileName = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/',$fileName);
        }
        $team->update([
         'fullname' => request()->get('fullname'),
         'designation' => request()->get('designation'),
         'telephone' => request()->get('telephone'),
         'mobile' => request()->get('mobile'),
         'email' => request()->get('email'),
         'facebook_id' => request()->get('facebook_id'),
         'twitter_id' => request()->get('twitter_id'),
         'pinterest_id' => request()->get('pinterest_id'),
         'profile' => request()->get('description'),
         'team_img' => ($fileName) ? $fileName : $currentImage,
     ]);
         if ($fileName) 
            File::delete('./uploads/' . $currentImage);
        $notification=[
            'message'=>'Record Updated Sucsessfully',
            'alert-type'=>'success'

        ];
        return redirect()->to('admin/team')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
         if ($request->ajax())
         {
        $team = Team::find($id);
          // if only id then we will use find otherwise we will use where
        $currentImage =$team->team_img;
         $team->delete();
        // if this $media->delete(); does not work we can user $media->delete($media);$book->delete($book); 
         // delete record
         File::delete('./uploads/' . $currentImage);
          $notification = [
            'message' => 'Record Deleted Successfully!',
            'alert-type' => 'success',
        ];
         // return redirect()->back()->with($notification);
         return 'true';
    }

             }
                public function status(Request $request,$id)
         {
             sleep(1);
            if ($request->ajax()) 
            {
            $team = Team::find($id);
            // match id by id and store it in Team variable
            $newStatus = ($team->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
            $team->update(['status'=>$newStatus]);
             // update status and store it in newStatu every field in table is secure so to update we need to take permission first
                     // goto app > Team.php
            return $newStatus;         
            // return redirect()->back();
            // return to index page
        }
    }
      
      public function status_active(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Team::where('id', $value)->update(['status' => 'ACTIVE']);
            }
            $record = Team::find($request->statusAll);
            return $record;
        }
    }

    public function status_deactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Team::where('id', $value)->update(['status' => 'DEACTIVE']);
            }
            $record = Team::find($request->statusAll);
            return $record;
        }
    }

    public function delete_all(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Team::where('id', $value)->delete();
            }
            $record = Team::find($request->statusAll);
            return $record;
        }
    }

}