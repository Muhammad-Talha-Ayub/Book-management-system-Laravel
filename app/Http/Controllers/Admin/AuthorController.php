<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Author;
// use phpseclib\Crypt\RSA; // Assuming this is your Author model
// use App\Helpers\RSAHelper;
use File;
// Calling to remove the following error
//Class 'App\Http\Controllers\Admin\Author' not found


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      
         public function index()
      { 
     $searchTerm = request()->get('s');
     $authors = Author::orWhere('title', 'LIKE' , "%$searchTerm%" )-> latest()->paginate(15);
     //latest means that data inserted in last will be shown at first
        return view('admin.author.index')->with (compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        // Validation (include *)
        $this->validate(request(),[
        'title' =>'required',
        'slug'=>'required',
        'designation'=>'required',
        'dob'=>'required',
        'email'=>'required',
        'country'=>'required | not_in:none',
        'author_img'=>'required|mimes:png,jpg,jpeg,gif|max:2048'
        ]);
        // md5 means string to hash converter 
        $fileName =null;
        if(request()->hasFile('author_img'))
        {
            $file=request()->file('author_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/',$fileName);
        }
         // insert into query(inserting record)
        
        Author::create([
            
         'title' => request()->get('title'),
         'slug' => request()->get('slug'),
         'designation' => request()->get('designation'),
         'dob' => request()->get('dob'),
         'country' => request()->get('country'),
         'email' => request()->get('email'),
         'phone' => request()->get('phone'),
         'description' => request()->get('description'),
         'author_feature' => request()->get('author_feature'),
         'facebook_id' => request()->get('facebook_id'),
         'twitter_id' => request()->get('twitter_id'),
         'youtube_id' => request()->get('youtube_id'),
         'pinterest_id' => request()->get('pinterest_id'),
         'author_img' => $fileName,
         'status'=> 'DEACTIVE'
     ]);
        
        // $encryptedTitle = RSAHelper::encryptData($request->input('title'));
        // $encryptedDescription = RSAHelper::encryptData($request->input('description'));
        // $encryptedDesignation = RSAHelper::encryptData($request->input('designation'));
        // $encryptedPhone = RSAHelper::encryptData($request->input('phone'));

        // Author::create([
        //     'title' => $encryptedTitle,
        //     'description' => $encryptedDescription,
        //     'designation' => $encryptedDesignation,
        //     'phone' => $encryptedPhone,
        // ]);
        $notification=['message'=>'Record Inserted Successfully!',
        'alert-type'=>'success'];

         return redirect()->to('/admin/author')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $author = Author::findOrFail($id);

        // $decryptedTitle = RSAHelper::decryptData($author->title);
        // $decryptedDescription = RSAHelper::decryptData($author->description);
        // $decryptedDesignation = RSAHelper::decryptData($author->designation);
        // $decryptedPhone = RSAHelper::decryptData($author->phone);

        // return view('author.show', [
        //     'author' => $author,
        //     'decryptedTitle' => $decryptedTitle,
        //     'decryptedDescription' => $decryptedDescription,
        //     'decryptedDesignation' => $decryptedDesignation,
        //     'decryptedPhone' => $decryptedPhone,
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
        $author= Author::find($id);
        return view('admin.author.edit')->with(compact(
            'author'));
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
        $author= Author::find($id);
        $currentImage = $author->author_img;
         $fileName =null;
        if(request()->hasFile('author_img'))
        {
            $file=request()->file('author_img');
            $fileName = md5($file->getClientOriginalName()) . time() ."." . $file->getClientOriginalExtension();
            $file->move('./uploads/', $fileName);
        }
        $author->update([
         'title' => request()->get('title'),
         'slug' => request()->get('slug'),
         'designation' => request()->get('designation'),
         'dob' => request()->get('dob'),
         'country' => request()->get('country'),
         'email' => request()->get('email'),
         'phone' => request()->get('phone'),
         'description' => request()->get('description'),
         'author_feature' => request()->get('author_feature'),
         'facebook_id' => request()->get('facebook_id'),
         'twitter_id' => request()->get('twitter_id'),
         'youtube_id' => request()->get('youtube_id'),
         'pinterest_id' => request()->get('pinterest_id'),
         'author_img' => ($fileName) ? $fileName : $currentImage,
     ]);
        if($fileName)
            File::delete('./uploads/' . $currentImage);
        $notification = [
            'message' => 'Record Updated Successfully!',
            'alert-type' => 'success',
        ];
       // Check if the request is AJAX and return a JSON response
       if ($request->ajax()) {
        return response()->json([
            'status' => true,
            'redirect_url' => '/admin/author', // Adjust the URL as needed
        ]);
    }
    // return redirect()->to('/admin/author');
        return redirect()->to('/admin/author')->with($notification);
        
    }
      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) { 
          $author = Author::find($id);
          $currentImage = $author->author_img;
          $author->delete();
          File::delete('./uploads/' . $currentImage);
          $notification = [
                'message' => 'Record Deleted Successfully!',
                'alert-type' => 'success',
            ];
            // return redirect()->back()->with($notification);
            return 'true';
            }
        }

     public function status(Request $request, $id)
     {
         sleep(1);
         if ($request->ajax())

         {
             $author = Author::find($id);
             $newStatus = ($author->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
             $author->update([
                 'status' => $newStatus
             ]);
                     // update status and store it in newStatus every field in table is secure so to update we need to take permission first
                     // goto app > Author.php
                     
                      return $newStatus;
                       // return redirect()->back();

                    }
    }
    public function status_active(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Author::where('id', $value)->update(['status' => 'ACTIVE']);
            }
            $record = Author::find($request->statusAll);
            return $record;
        }
    }

    public function status_deactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Author::where('id', $value)->update(['status' => 'DEACTIVE']);
            }
            $record = Author::find($request->statusAll);
            return $record;
        }
    }

    public function delete_all(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Author::where('id', $value)->delete();
            }
            $record = Author::find($request->statusAll);
            return $record;
        }
    }
}