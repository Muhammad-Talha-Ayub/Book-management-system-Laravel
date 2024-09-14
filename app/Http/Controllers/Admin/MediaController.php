<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Media;
// use phpseclib\Crypt\RSA; // Assuming this is your Author model
// use App\Helpers\RSAHelper;
use File;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchTerm = request()->get('s');
     $medias = Media::orWhere('title', 'LIKE' , "%$searchTerm%" )-> latest()->paginate(15);
     //latest means that data inserted in last will be shown at first
        return view('admin.media.index')->with (compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.media.create');

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
        'title' =>'required',
        'slug' =>'required',
        'media_type'=>'required | not_in:none',
        'media_img'=>'required|mimes:png,jpg,jpeg,gif|max:2048'
        ]);
          $fileName =null;
        if(request()->hasFile('media_img'))
        {
            $file=request()->file('media_img');
            $fileName = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/',$fileName);
        }
        Media::create([
            'title' => request()->get('title'),
            'slug' => request()->get('slug'),
            'media_type' => request()->get('media_type'),
            'media_img' => $fileName,
            'description' => request()->get('description'),
            'status'=> 'DEACTIVE'
           ]);
           // $encryptedTitle = RSAHelper::encryptData($request->input('title'));
  
           // Media::create([
           //     'title' => $encryptedTitle,
           // ]);
        $notification=[
            'message'=>'Record Inserted Sucsessfully',
            'alert-type'=>'success'

        ];
        return redirect()->to('/admin/media')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $media = Media::findOrFail($id);

        // // Decrypt data before passing it to the view
        // $decryptedTitle = RSAHelper::decryptData($media->title);

        // return view('media.show', [
        //     'media' => $media,
        //     'decryptedTitle' => $decryptedTitle,
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
        
        $media= Media::find($id);
        return view('admin.media.edit')->with(compact(
            'media'));
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
         $media= Media::find($id);
          $currentImage = $media->media_img;
          $fileName =null;
        if(request()->hasFile('media_img'))
        {
            $file=request()->file('media_img');
            $fileName = md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/',$fileName);
        }
         $media->update([
         'title' => request()->get('title'),
         'slug' => request()->get('slug'),
         'media_type' => request()->get('media_type'),
         'media_img' => ($fileName) ? $fileName : $currentImage,
         'description' => request()->get('description'),
     ]);
          if ($fileName) 
            File::delete('./uploads/' . $currentImage);
     $notification=[
            'message'=>'Record Updated Sucsessfully',
            'alert-type'=>'success'

        ];   
        return redirect()->to('admin/media')->with($notification);
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
       $media = Media::find($id);
          // if only id then we will use find otherwise we will use where
       $currentImage =$media->media_img;
         $media->delete($media); 
         File::delete('./uploads/' . $currentImage);
         // if this $media->delete(); does not work we can user $media->delete($media);
         // delete record
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
            $media=Media::find($id);
            // match id by id and store it in Media variable
            $newStatus = ($media->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
            $media->update(['status'=>$newStatus]);
             // update status and store it in newStatu every field in table is secure so to update we need to take permission first
                     // goto app > Media.php
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
                Media::where('id', $value)->update(['status' => 'ACTIVE']);
            }
            $record = Media::find($request->statusAll);
            return $record;
        }
    }

    public function status_deactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Media::where('id', $value)->update(['status' => 'DEACTIVE']);
            }
            $record = Media::find($request->statusAll);
            return $record;
        }
    }

    public function delete_all(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Media::where('id', $value)->delete();
            }
            $record = Media::find($request->statusAll);
            return $record;
        }
    }

}
