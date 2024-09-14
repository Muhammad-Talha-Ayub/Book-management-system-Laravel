<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
// use phpseclib\Crypt\RSA; // Assuming this is your Author model
// use App\Helpers\RSAHelper;
use File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $searchTerm = request()->get('s');
     $books = Book::orWhere('title', 'LIKE' , "%$searchTerm%" )-> latest()->paginate(15);
     //latest-> data inserted in last will be shown at first
        return view('admin.book.index')->with (compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.book.create');

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
        'slug'=>'required',
        'category_id'=>'required | not_in:0',
        'author_id'=>'required | not_in:0',
        'availability'=>'required',
        'price'=>'required',
        'rating'=>'required',
        'country_of_publisher'=>'required',
        'description'=>'required'
        ]);
        $fileName = null;
        if (request()->hasFile('book_img')) 
        {
            $file = request()->file('book_img');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move('./uploads/', $fileName);
        }
        $fileName2=null;
         if (request()->hasFile('book_upload')) 
        {
            $file2 = request()->file('book_upload');
            $fileName2 = md5($file2->getClientOriginalName()) . time() . "." . $file2->getClientOriginalExtension();
            $file2->move('./uploads/', $fileName2);
        }
        // inserting data
        Book::create([
            'category_id'=>request()->get('category_id'),
         'author_id'=>request()->get('author_id'),
            'title'=>request()->get('title'),    
        'slug'=>request()->get('slug'),
        'availability'=>request()->get('availability'),
        'price'=>request()->get('price'),
        'rating'=>request()->get('rating'),
        'publisher'=>request()->get('publisher'),
        'country_of_publisher'=>request()->get('country_of_publisher'),
        'isbn'=>request()->get('isbn'),
        'isbn-10'=>request()->get('isbn-10'),
        'audience'=>request()->get('audience'),
        'format'=>request()->get('foramt'),
        'language'=>request()->get('language'),
        'total_pages'=>request()->get('total_pages'),
        'downloaded'=>request()->get('downloaded'),
        'edition_number'=>request()->get('edition_number'),
        'recommended'=>request()->get('recommended'),
        'description'=>request()->get('description'),
        'book_img'=>$fileName,
        'book_upload'=>$fileName2,
        'status'=>'DEACTIVE'
          ]);
          // $encryptedTitle = RSAHelper::encryptData($request->input('title'));
  
          // Book::create([
          //     'title' => $encryptedTitle,
          // ]);
        $notification=[
            'message'=>'Record Inserted Sucsessfully',
            'alert-type'=>'success'

        ];
        return redirect()->to('/admin/book')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $book = Book::findOrFail($id);

        // // Decrypt data before passing it to the view
        // $decryptedTitle = RSAHelper::decryptData($book->title);

        // return view('book.show', [
        //     'book' => $book,
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
         
      $book= Book::find($id);
        return view('admin.book.edit')->with(compact(
            'book'));
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
        $book= Book::find($id);
        $currentImage = $book->book_img;
        $currentUpload = $book->book_upload;

        $fileName = null;
            if (request()->hasFile('book_img')) 
            {
                $file = request()->file('book_img');
                $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/', $fileName);
            }
            $fileName2 = null;
            if (request()->hasFile('book_upload')) 
            {
                $file2 = request()->file('book_upload');
                $fileName2 = md5($file2->getClientOriginalName()) . time() . "." . $file2->getClientOriginalExtension();
                $file2->move('./uploads/', $fileName2);
            }

        $book->update([
         'category_id' => request()->get('category_id'),
         'author_id' => request()->get('author_id'),
         'title' => request()->get('title'),
         'slug' => request()->get('slug'),
         'availability' => request()->get('availability'),
         'price' => request()->get('price'),
         'rating' => request()->get('rating'),
         'publisher' => request()->get('publisher'),
         'country_of_publisher' => request()->get('country_of_publisher'),
         'isbn' => request()->get('isbn'),
         'isbn-10' => request()->get('isbn-10'),
         'audience' => request()->get('audience'),
         'format' => request()->get('format'),
         'language' => request()->get('language'),
         'total_pages' => request()->get('total_pages'),
         'downloaded' => request()->get('downloaded'),
         'edition_number' => request()->get('edition_number'),
         'recommended' => request()->get('recommended'),
         'description' => request()->get('description'),
         'book_img' => ($fileName) ? $fileName : $currentImage,
         'book_upload' => ($fileName2) ? $fileName2 : $currentUpload,
     ]);
         if ($fileName) 
            File::delete('./uploads/' . $currentImage);
        if ($fileName2) 
            File::delete('./uploads/' . $currentUpload);
        $notification=[
            'message'=>'Record Updated Sucsessfully',
            'alert-type'=>'success'

        ];
        return redirect()->to('admin/book')->with($notification);
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
        $book = Book::find($id);
        // if only id then we will use find otherwise we will use where
        $currentImage =$book->book_img;
        $currentUpload =$book->book_upload;
        $book->delete();  
         // delete record
        File::delete('./uploads/' . $currentImage);
        File::delete('./uploads/' . $currentUpload);
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
            $book=Book::find($id);
            // match id by id and store it in Book variable
            $newStatus = ($book->status == 'DEACTIVE') ? 'ACTIVE' : 'DEACTIVE';
            $book->update(['status'=>$newStatus]);
             // update status and store it in newStatus every field in table is secure so to update we need to take permission first
                     // goto app > Book.php
                     // protected $fillable = ['title', 'slug', 'designation', 'dob'];
                     // if we are making big website then there is an alternative to it
                     //  protected $guarded = [ 'id', 'created_at', 'updated_at' ];
                     //  means every other file can be used to update ,delete etc except file mentioned in guarded  
            return $newStatus;
           
    }
}
  public function status_active(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Book::where('id', $value)->update(['status' => 'ACTIVE']);
            }
            $record = Book::find($request->statusAll);
            return $record;
        }
    }

    public function status_deactive(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Book::where('id', $value)->update(['status' => 'DEACTIVE']);
            }
            $record = Book::find($request->statusAll);
            return $record;
        }
    }

    public function delete_all(Request $request)
    {
        if ($request->ajax()) 
        {
            foreach ($request->statusAll as $value) {
                Book::where('id', $value)->delete();
            }
            $record = Book::find($request->statusAll);
            return $record;
        }
    }

}