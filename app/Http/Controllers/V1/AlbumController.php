<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Models\V1\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Album::where('user_id', $request->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AlbumRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        return Album::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Album $album
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Album $album)
    {
        if ($album->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        return $album;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\AlbumRequest $request
     * @param \App\Models\Album $album
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, Album $album)
    {
        if ($album->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        $album->update($request->all());
        return $album;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Album $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Album $album)
    {
        if ($album->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        $album->delete();
    }
}
