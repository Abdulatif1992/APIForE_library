<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use ZipArchive;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = DB::table('books')->select('book_id','book_name', 'book_title', 'status', 'base64')->orderBy('id', 'DESC')->get();
        //return $book;
        return view('welcome', compact('books'));
    }

    public function getbookid()
    {
        $bookId = DB::table('books')->select('id')->find(\DB::table('books')->max('id'));
        // /$order = Order::find(\DB::table('orders')->max('id'));
        //dd($bookId->id);
        $realbookid =  $bookId->id+1000+1;
        return response()->json($realbookid);
        //echo"mana senga id = ". $realbookid;
    }

    public function savebook(Request $request)
    {
        $bid = $request->input('bookId');        
        $bname = $request->input('bookName');
        $btitle = $request->input('bookTitle');
        
        // upload img and convert to base64
        $img = $request->file('img');
        $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
        // save the uploaded file to storage
        $img->storeAs('uploads', $imgName);
        $base64 = self::convertBase64($imgName);

        
        // upload epub and archive it
        $epub = $request->file('epub');
        $fileName = uniqid() . '.' . $epub->getClientOriginalExtension();
        // save the uploaded file to storage
        $epub->storeAs('uploads', $fileName);
        // archive file
        $check = self::archiveFile($fileName, $bid);
        // delete file after archived
        unlink(storage_path('app/uploads/'.$fileName));
        // delete image after saved to db
        unlink(storage_path('app/uploads/'.$imgName));


        // save data to db
        DB::table('books')->insert([
            'book_id' => $bid,
            'book_name' => $bname,
            'book_title' => $btitle,
            'status' => 0,
            'base64' => $base64,
        ]);
        //DB::insert('insert into books values (?, ?, ?)', [1, "Infinity", "MS500"]);
        

        return redirect('dashboard');
    }

    public function archiveFile($fileName, $archivename)
    {
        $zip = new ZipArchive();
        $archivePath = storage_path('app/'.$archivename.'.zip');

        if ($zip->open($archivePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $file = storage_path('app/uploads/'. $fileName);
            $zip->addFile($file, $fileName);
            $zip->close();
            return true;
            // Archive created successfully
        } else {
            return false;
            // Failed to create the archive
        }
    }

    public function convertBase64($imgName)
    {
        $path = storage_path('app/uploads/'.$imgName);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = base64_encode($data);
        return $base64;
    }

    public function confirmbook(Request $request)
    {
        DB::table('books')->where('book_id',$request->input('bookId'))->update(array('status'=>1,));
        return redirect('dashboard');
    }

    public function deletebook(Request $request)
    {
        DB::table('books')->where('book_id',$request->input('bookId'))->delete();
        return redirect('dashboard');
    }
}
