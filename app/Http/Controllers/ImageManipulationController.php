<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResizeImageRequest;
use App\Models\ImageManipulation;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageManipulationController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreImageManipulationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageManipulationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resize(ResizeImageRequest $request)
    {
        $all = $request->all();

        /** @var UploadedFile|string $image */
        $image = $all['image'];
        unset($all['image']);
        $data['type'] = ImageManipulation::TYPE_RESIZE;
        $data['data'] = json_encode($all);
        $dir = 'images/' . Str::random() . '/';
        $absolutePath = public_path($dir);
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        if ($image instanceof UploadedFile) {
            $data['name'] = $image->getClientOriginalName();
            $filename = pathinfo($data['name'], PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $originalPath = $absolutePath . $data['name'];
            $data['path'] = $dir . $data['name'];
            $image->move($absolutePath, $data['name']);

        } else {
            $data['name'] = pathinfo($image, PATHINFO_BASENAME);
            $filename = pathinfo($image, PATHINFO_FILENAME);
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $originalPath = $absolutePath . $data['name'];

            copy($image, $originalPath);
            $data['path'] = $dir . $data['name'];
        }

        $w = $all['w'];
        $h = $all['h'] ?? false;

        list($image, $width, $height) = $this->getWidthAndHeight($w, $h, $originalPath);

        $resizedFilename = $filename . '-resized.' . $extension;
        $image->resize($width, $height)->save($absolutePath . $resizedFilename);

        $data['output_path'] = $dir.$resizedFilename;

        ImageManipulation::create($data);

        return [
            'original' => URL::to($data['path']),
            'resized' =>  URL::to($data['output_path'])
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ImageManipulation $imageManipulation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageManipulation $imageManipulation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ImageManipulation $imageManipulation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageManipulation $imageManipulation)
    {
        //
    }

    protected function getWidthAndHeight($w, $h, $originalPath)
    {
        $image = Image::make($originalPath);
        $originalWidth = $image->width();
        $originalHeight = $image->height();

        if (str_ends_with($w, '%')) {
            $ratioW = (float)(str_replace('%', '', $w));
            $ratioH = $h ? (float)(str_replace('%', '', $h)) : $ratioW;
            $newWidth = $originalWidth * $ratioW / 100;
            $newHeight = $originalHeight * $ratioH / 100;
        } else {
            $newWidth = (float)$w;

            /**
             * $originalWidth  -  $newWidth
             * $originalHeight -  $newHeight
             * -----------------------------
             * $newHeight =  $originalHeight * $newWidth/$originalWidth
             */
            $newHeight = $h ? (float)$h : ($originalHeight * $newWidth / $originalWidth);
        }

        return [$image, $newWidth, $newHeight];
    }
}
