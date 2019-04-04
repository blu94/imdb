<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Asset;
use App\User;
use Image;
use Auth;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
         //
         // ini_set('upload_max_filesize', "50M");
         // ini_set("memory_limit", "2000M");
         ini_set('max_input_time', "-1");
         ini_set('max_execution_time', "0");

         // Convert the byte to MB from http://converter.elliotbeken.com/ ,
         // 1mb = 1048576
         // 2MB = 2097152
         // 3MB = 3145728
         // 4MB = 4194304

         $byte = 1048576;
         $img = "";
         $file = $request->file("file");

         $usage = $request->usage;
         $returnType = $request->returnType;

         $path = "assets/original/".date("Y")."/".date("m")."/";
         if(!file_exists($path)) {
           // path does not exist
           Storage::makeDirectory($path);
         }

         $name = time() . md5($file->getClientOriginalName()) . env("APP_NAME") . "." . strtolower($file->getClientOriginalExtension());

         // move file
         $file->move($path, $name);

         // extension
         $extension = strtolower(pathinfo($path . $name, PATHINFO_EXTENSION));

         // compress image if file size more then certain amount
         // $size = Storage::size($path . $name);
         // $size = $file->getSize();
         $size = filesize($path . $name);

         // store record
         $asset = Asset::create([
           "title" => $name,
           "usage" => $usage,
           "path" => $path . $name,
           "format" => $extension,
           "user_id" => Auth::user()->id,
           "size" => $size
         ]);

         // if assetable details is not empty
         if ($request->assetable_id) {
           $asset->update([
             "assetable_id" => $request->assetable_id
           ]);
         }
         if ($request->assetable_type) {
           $asset->update([
             "assetable_type" => $request->assetable_type
           ]);
         }

         // remove other image if has attribute
         if (($request->removeOther) && ($request->assetable_type) && ($request->assetable_id)) {
           $removeOtherAssets = Asset::where("usage", $usage)
           ->where("assetable_type", $request->assetable_type)
           ->where("assetable_id", $request->assetable_id)
           ->where("id", "!=", $asset->id)
           ->delete();
         }

         // compress job
         // if ($size >= $byte && ($extension != "mp4" || $extension != "pdf" || $extension != "docx")) {
         //   ini_set("max_execution_time", 0);
         //   ini_set("memory_limit", "2000M");
         //   $compressedPath = "assets/compressed/".date("Y")."/".date("m")."/";
         //   if(!file_exists($compressedPath)) {
         //     // path does not exist
         //     Storage::makeDirectory($compressedPath);
         //   }
         //
         //   $size = filesize($asset->path);
         //   if ($size >= $byte) {
         //     $allowedMimeTypes = [
         //       "image/jpeg",
         //       "image/gif",
         //       "image/png",
         //       "image/jpg"
         //     ];
         //
         //     $contentType = mime_content_type($asset->path);
         //
         //     if(in_array($contentType, $allowedMimeTypes)){
         //       // check file exist or not
         //       $imagePath = ltrim($asset->path, '/');
         //       $finalPath = null;
         //       if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/demo/" . $imagePath)) {
         //         $finalPath = $_SERVER['DOCUMENT_ROOT'] . "/demo/" . $imagePath;
         //       }
         //       elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $imagePath)) {
         //         $finalPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $imagePath;
         //       }
         //
         //       if ($finalPath !== null) {
         //         // open and resize an image file
         //         $img = Image::make($imagePath)->resize(null, 800, function ($constraint) {
         //           $constraint->aspectRatio();
         //         });
         //
         //         // save file as jpg with medium quality
         //         $img->save($compressedPath . $asset->title, 80);
         //       }
         //
         //     }
         //   }
         // }

         if ($returnType == "URL") {
           return asset($asset->path);
         }
         elseif ($returnType == "ID") {
           return $asset->id;
         }
     }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         //
         $asset = Asset::findOrFail($id);

         $assetPath = ltrim($asset->path, "/");
         if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$assetPath)){
           unlink($_SERVER['DOCUMENT_ROOT']."/".$assetPath);
         }
         elseif (file_exists($assetPath)) {
           unlink($assetPath);
         }

         $compressedPath = str_replace("original","compressed", $assetPath);
         if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$compressedPath)){
           unlink($_SERVER['DOCUMENT_ROOT']."/".$compressedPath);
         }
         elseif (file_exists($compressedPath)) {
           unlink($compressedPath);
         }

         $asset->delete();
     }
}
