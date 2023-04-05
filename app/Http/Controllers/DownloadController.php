<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DownloadController extends Controller
{
    // public function index()
    // {
    //     return view('csv.index');
    // }

    public function download()
    {
        $filecsv='download/posts.csv';
        $pathToCsv = public_path($filecsv);
        // Storage::disk('local')->put('example2.csv', 'Contents');
        $writer=SimpleExcelWriter::create($pathToCsv);
        Post::get()->each(function($post) use ($writer) {
            $writer->addRow([
                'title'=> $post->title,
                'content'=> $post->content,
                'user'=>$post->author->name,
                'category'=>$post->category->name,
            ]);
        });

        $zip=new ZipArchive();
        $zipFileName="posts.zip";
        if($zip->open(public_path($zipFileName), ZipArchive::CREATE)==TRUE){
            
            $zip->addFile(public_path($filecsv), 'posts.csv');
            
                $zip->close();
                return response()->download(public_path($zipFileName));
                dd('done');
            
        }
        // dd('error');
        
        return to_route('dashboard');
    }
}
