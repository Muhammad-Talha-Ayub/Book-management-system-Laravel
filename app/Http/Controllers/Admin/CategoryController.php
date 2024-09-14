<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
// use phpseclib\Crypt\RSA; // Assuming this is your Author model
// use App\Helpers\RSAHelper;
use File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $searchTerm = request()->get('s');
      $categorys = Category::orWhere('title', 'LIKE' , "%$searchTerm%" )-> latest()->paginate(15);
     //latest means that data inserted in last will be shown at first
        return view('admin.category.index')->with (compact('categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
        'slug'=>'required'
        ]);
         Category::create([
         'title' => request()->get('title'),
         'slug' => request()->get('slug'),
         'description' => request()->get('description'),
         'status'=> 'DEACTIVE'
     ]);
     // $encryptedTitle = RSAHelper::encryptData($request->input('title'));
  
     //      Category::create([
     //          'title' => $encryptedTitle,
     //      ]);
        $notification=['message'=>'Record Inserted Successfully!',
        'alert-type'=>'success'];
         return redirect()->to('/admin/category')->with($notification);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $category = Category::findOrFail($id);

        // // Decrypt data before passing it to the view
        // $decryptedTitle = RSAHelper::decryptData($category->title);

        // return view('category.show', [
        //     'category' => $category,
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
        
       $category= Category::find($id);
        return view('admin.category.edit')->with(compact(
            'category'));
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
         $category= Category::find($id);
          $category->update([
         'title' => request()->get('title'),
         'slug' => request()->get('slug'),
         'description' => request()->get('description'),
     ]);
          $notification=[
            'message'=>'Record Updated Sucsessfully',
            'alert-type'=>'success'

        ];
        return redirect()->to('admin/category')->with($notification);
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
        $category = Category::find($id);
          // if only id then we will use find otherwise we will use where
         $category->delete(); 
        // if this $media->delete(); does not work we can user $media->delete($media);$book->delete($book); 
         // delete record
         $notification = [
            'message' => 'Record Deleted Successfully!',
            'alert-type' => 'success',
        ]; 
         // return redirect()->back()->with($notification);
         return 'true';
    }
      } 
         // destroy method closed

         public function status(Request $request,$id)
         {
             sleep(1);
            if ($request->ajax()) 
            {
            $category=Category::find($id);
            // match id by id and store it in Category variable
            $newStatus = ($category->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
            $category->update(['status'=>$newStatus]);
             // update status and store it in newStatu every field in table is secure so to update we need to take permission first
                     // goto app > Category.php
                     
            return $newStatus;
            
        }

         }
           public function status_active(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Category::where('id', $value)->update(['status' => 'ACTIVE']);
            }
            $record = Category::find($request->statusAll);
            return $record;
        }
    }

    public function status_deactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Category::where('id', $value)->update(['status' => 'DEACTIVE']);
            }
            $record = Category::find($request->statusAll);
            return $record;
        }
    }

    public function delete_all(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Category::where('id', $value)->delete();
            }
            $record = Category::find($request->statusAll);
            return $record;
        }
    }

}
