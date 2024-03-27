<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\CourseUpdate;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;



class MainHelper
{

    // public static function make_error_report(
    //     $options = []
    // ) {
    //     $options = array_merge([
    //         'error' => "",
    //         'error_code' => "",
    //         'details' => json_encode(request()->instance())
    //     ], $options);
    //     try {
    //         if (Schema::hasTable('report_errors'))
    //             \App\Models\ReportError::create([
    //                 'user_id' => (auth()->check() ? auth()->user()->id : null),
    //                 'title' => $options['error'],
    //                 'code' => $options['error_code'],
    //                 'url' => url()->previous(),
    //                 'ip' => \App\Helpers\UserSystemInfoHelper::get_ip(),
    //                 'user_agent' => request()->header('User-Agent'),
    //                 'request' => json_encode(request()->all()),
    //                 'description' => $options['details']
    //             ]);
    //     } catch (\Exception $e) {
    //     }
    // }


    public static  function locales()
    {
        $arr = [];
        $locales = ['ar', 'en']; // Define the supported locales manually

        foreach ($locales as $locale) {
            $arr[$locale] = trans('locales.' . $locale);
        }

        return $arr;
    }

    

    /**
     * format Bytes into b,KB,MB,GB
     *
     * @param mixed $bytes
     * @param mixed $precision
     * @return void
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    /* return arabic format date */
    public static function dateArabicFormat($date, $inFormat = 'Y-m-d', $outFormat = 'd M، Y')
    {
        /* incoming date */
        if (!$inFormat) {
            $inFormat = 'Y-m-d';
        }
        /* outcoming date */
        if (!$outFormat) {
            $outFormat = 'd M، Y';
        }
        $d = Carbon::createFromFormat($inFormat, $date);
        $isValidInFormat = ($d && $d->format($inFormat) == $date);
        // check if date has Valid Format
        if ($isValidInFormat) {
            return Carbon::parse($date)->translatedFormat($outFormat);
        }
    }


    /**
     * Convert a YouTube URL to an embedded YouTube video URL.
     *
     * This function takes a YouTube URL as input and extracts the video ID from it.
     * It then constructs an embedded YouTube video URL using the extracted video ID.
     *
     * @param string $url The YouTube URL to be converted.
     * @param bool $returnid Whether to return the extracted YouTube video ID.
     * @return string The embedded YouTube video URL.
     */

    public static   function addEmbedToYt($url, $returnid = false)
    {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
        $youtube_id = '';
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        $return = isset($youtube_id) ? $youtube_id : '';
        if ($returnid == true) return $youtube_id;
        return 'https://www.youtube.com/embed/' . $return;
    }





    // static function deleteFile($id)
    // {
    //     $file = \App\Models\Upload::find($id);
    //     $old = $file;
    //     if ($file) {
    //         if (File::exists(public_path($old->full_original_path))) {
    //             unlink(public_path('/') . $old->full_original_path);
    //         }
    //         if (File::exists(public_path($old->full_large_path))) {
    //             unlink(public_path('/') . $old->full_large_path);
    //         }
    //         if (File::exists(public_path($old->full_medium_path))) {
    //             unlink(public_path('/') . $old->full_medium_path);
    //         }
    //         if (File::exists(public_path($old->full_small_path))) {
    //             unlink(public_path('/') . $old->full_small_path);
    //         }
    //         $old->delete();
    //         return true;
    //     }
    //     return false;
    // }



    // static function upload($file, $file_type, $relation_id, $folder, $watermark = 0, $type = 'single', $valid_type = 0)
    // {
    //     if ($type == 'single') {
    //         $old = \App\Models\Upload::where('file_type', $file_type)->where('relation_id', $relation_id)->first();
    //         if (isset($old)) {
    //             if (File::exists(public_path($old->full_original_path))) {
    //                 unlink(public_path('/') . $old->full_original_path);
    //             }
    //             if (File::exists(public_path($old->full_large_path))) {
    //                 unlink(public_path('/') . $old->full_large_path);
    //             }
    //             if (File::exists(public_path($old->full_medium_path))) {
    //                 unlink(public_path('/') . $old->full_medium_path);
    //             }
    //             if (File::exists(public_path($old->full_small_path))) {
    //                 unlink(public_path('/') . $old->full_small_path);
    //             }
    //             $old->delete();
    //         }
    //     }
    //     $fileType = ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'];
    //     $videoFileType = ['video/x-ms-asf', 'video/x-flv', 'video/mp4', 'application/x-mpegURL', 'video/MP2T', 'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv', 'video/avi'];
    //     if ($type != 'single') {
    //         $files = $file;
    //     } else {

    //         $files = $file;
    //     }

    //     $name = $files->getClientOriginalName();
    //     $size = $files->getSize();
    //     $mime_type = $files->getMimeType();
    //     $hashname = $files->hashName();
    //     if ($hashname == null) {
    //         $hashname = md5_file($files->getRealPath());
    //     }
    //     $year = now()->year;
    //     $month = now()->month;
    //     if (in_array($mime_type, $fileType)) {
    //         if ($relation_id == null) {
    //             $relation_id = 'images';
    //         }
    //     }
    //     if (in_array($mime_type, $videoFileType)) {
    //         if ($relation_id == null) {
    //             $relation_id = 'videos';
    //         }
    //     }

    //     $dir = public_path("uploads/" . $year . '/' . $month . '/' . $folder . '/' . $relation_id);
    //     $dir_thumbnail = public_path("uploads/" . $year . '/' . $month . '/' . $folder . '/' . $relation_id . '/thumbnail');


    //     if (!File::isDirectory($dir)) {
    //         File::makeDirectory($dir, 493, true);
    //     }
    //     if (!File::isDirectory($dir_thumbnail)) {
    //         File::makeDirectory($dir_thumbnail, 493, true);
    //     }

    //     $path_original_livewire = 'uploads/' . $year . '/' . $month . '/' . $folder . '/' . $relation_id;
    //     $path_original = 'uploads/' . $year . '/' . $month . '/' . $folder . '/' . $relation_id . '/' . $hashname;
    //     $path_thumbnail_large = 'uploads/' . $year . '/' . $month . '/' . $folder . '/' . $relation_id . '/thumbnail/' . 'large' . $hashname;
    //     $path_thumbnail_medium = 'uploads/' . $year . '/' . $month . '/' . $folder . '/' . $relation_id . '/thumbnail/' . 'medium' . $hashname;
    //     $path_thumbnail_small = 'uploads/' . $year . '/' . $month . '/' . $folder . '/' . $relation_id . '/thumbnail/' . 'small' . $hashname;
    //     if ($valid_type == 0) {
    //         if (in_array($mime_type, $fileType)) {
    //             if ($mime_type != 'image/svg+xml') {
    //                 $maxWidth = 1024; // your max width
    //                 $maxHeight = 700; // your max height
    //                 $thumbnailImage = Image::make($files)->encode('webp', 75);
    //                 if ($watermark == 1) {
    //                     $thumbnailImage->insert('uploads/admin/logo/logo.png', 'center')->encode('webp', 75)
    //                         ->limitColors(255);
    //                 }
    //                 $thumbnailImage->height() > $thumbnailImage->width() ? $maxWidth = null : $maxHeight = null;
    //                 $thumbnailImage->resize($maxWidth, $maxHeight, function ($constraint) {
    //                     $constraint->aspectRatio();
    //                     $constraint->upsize();
    //                 });
    //                 $thumbnailImage->save($path_original);
    //                 $thumbnailImage->resize(1193, 746, function ($constraint) {
    //                     $constraint->aspectRatio();
    //                     $constraint->upsize();
    //                 });
    //                 $thumbnailImage->save($path_thumbnail_large);
    //                 $thumbnailImage->resize(699, 437, function ($constraint) {
    //                     $constraint->aspectRatio();
    //                     $constraint->upsize();
    //                 });
    //                 $thumbnailImage->save($path_thumbnail_medium);
    //                 $thumbnailImage->resize(409, 256, function ($constraint) {
    //                     $constraint->aspectRatio();
    //                     $constraint->upsize();
    //                 });
    //                 $thumbnailImage->save($path_thumbnail_small);
    //             } else {
    //                 $files->move($dir, $path_original);
    //             }
    //         } elseif (in_array($mime_type, $videoFileType)) {
    //             $files->move($dir, $path_original);
    //         }
    //     } else {

    //         if ($files instanceof Livewire\TemporaryUploadedFile) {
    //             $path_original_livewire = 'uploads/' . $year . '/' . $month . '/' . $folder . '/' . $relation_id;
    //             $file->storeAs($path_original_livewire, $hashname, ['disk' => 'uploads']);
    //         } else {
    //             $files->move($dir, $path_original);
    //         }
    //     }

    //     if ($mime_type == 'image/svg+xml') {
    //         $path_thumbnail_large = $path_original;
    //         $path_thumbnail_medium = $path_original;
    //         $path_thumbnail_small = $path_original;
    //     }
    //     $uploads = \App\Models\Upload::create([
    //         'name' => $name,
    //         'size' => $size,
    //         'filename' => $hashname,
    //         'path' => $year . '/' . $month . '/' . $folder . '/' . $relation_id,
    //         'full_original_path' => $path_original,
    //         'full_large_path' => $path_thumbnail_large,
    //         'full_medium_path' => $path_thumbnail_medium,
    //         'full_small_path' => $path_thumbnail_small,
    //         'mime_type' => $mime_type,
    //         'file_type' => $file_type,
    //         'created_by' => \auth()->check() ? auth()->user()->id : null,
    //     ]);
    //     if ($relation_id != null && $relation_id != 'images' && $relation_id != 'videos') {
    //         $uploads->relation_id = $relation_id;
    //         $uploads->save();
    //     }
    //     return $uploads->id;
    // }




    
    


}
