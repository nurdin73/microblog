<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ImageOptimize
{
    protected $EXTENSIONS = ['jpg', 'png', 'gif', 'webp', 'jpeg'];
    protected $TEMPLATE_COLORS = [
        ['bg' => '#f87171', 'text' => '#1c1917'],
        ['bg' => '#fb923c', 'text' => '#fff7ed'],
        ['bg' => '#fbbf24', 'text' => '#d97706'],
        ['bg' => '#4ade80', 'text' => '#f0fdf4'],
        ['bg' => '#22d3ee', 'text' => '#ecfeff'],
        ['bg' => '#164e63', 'text' => '#ecfeff'],
        ['bg' => '#1d4ed8', 'text' => '#eff6ff'],
        ['bg' => '#60a5fa', 'text' => '#eff6ff'],
        ['bg' => '#4f46e5', 'text' => '#eef2ff'],
        ['bg' => '#c026d3', 'text' => '#ecfeff'],
        ['bg' => '#e11d48', 'text' => '#ecfeff'],
        ['bg' => '#f472b6', 'text' => '#ecfeff'],
    ];

    public function getRandomColor() : Array
    {
        $colors = $this->TEMPLATE_COLORS;
        $random = rand(0, count($colors) - 1);
        return $colors[$random];
    }

    public function createAvatar(String $text, Int $width = 150, Int $height = 150, Int $quality = 80)
    {
        $color = $this->getRandomColor();
        $optimizerChain = OptimizerChainFactory::create();
        $letters = explode(' ', $text);
        $letter = '';
        if(count($letters) > 1) {
            $letter = $letters[0][0] . $letters[count($letters) - 1][0];
        } else {
            $letter = $letters[0][0] . $letters[0][1];
        }
        $path = '/images/avatar/';
        $filename = Str::slug($text) . '.jpg';
        $image = Image::canvas($width, $height, $color['bg']);
        $image->text(Str::upper($letter), $width / 2, $height / 2, function($font) use($color) {
            $font->file('fonts/open-sans/regular.ttf');
            $font->size(50);
            $font->color($color['text']);
            $font->align('center');
            $font->valign('middle');
        });
        $image->encode('jpg', $quality);
        Storage::disk()->put($path . $filename, $image, 'public');
        $storagePath = Storage::disk()->path($path . $filename);
        $optimizerChain->optimize($storagePath);
        return $path . $filename;
    }

    public function saveImage($file, String $path, $width = 640, $height = 480)
    {
        if (!in_array($file->getClientOriginalExtension(), $this->EXTENSIONS)) return false;
        $path = "/images/$path";
        $optimizerChain = OptimizerChainFactory::create();
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        if ($width != null && $height != null) {
            $img->resize($width, $height);
        }
        $img->encode('jpg', 90);
        Storage::disk()->put($path . $filename, $img, 'public');
        // $storagePath = Storage::disk()->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
        $storagePath = Storage::disk()->path($path . $filename);
        Log::info($storagePath);
        $optimizerChain->optimize($storagePath);
        return $path . $filename;
    }

    public function updateImage($newFile, $oldFile, String $path, Int $width = 640, Int $height = 480)
    {
        if (!in_array($newFile->getClientOriginalExtension(), $this->EXTENSIONS)) return false;
        $optimizerChain = OptimizerChainFactory::create();
        $path = "/images/$path";
        if ($oldFile != null) {
            Storage::disk()->delete($path . $oldFile);
        }
        $filename = Str::uuid() . '.' . $newFile->getClientOriginalExtension();
        $img = Image::make($newFile->getRealPath());
        $img->resize($width, $height);
        $img->encode('jpg', 70);
        Storage::disk()->put($path . $filename, $img, 'public');
        // $storagePath = Storage::disk()->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
        $storagePath = Storage::disk()->path($path . $filename);
        $optimizerChain->optimize($storagePath);
        return $path . $filename;
    }

    public function deleteImage($pathFile)
    {
        try {
            Storage::disk()->delete($pathFile);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
