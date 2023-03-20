<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;
use App\Models\Video;
use App\Models\Tag;

class VideoController extends Controller
{
    use ResponseTrait;

    public function list($id)
    {
        $video = Video::with('tags')->findOrFail($id);
        return ok('Video',$video);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'  => 'required|max:40',
        ]);

        if($validation->fails())
            return error('Validation Error',$validation->errors(),'validation');

        $video = Video::create($request->only(['name']));
        return ok('Video Added Successfully',$video);
    }

    public function update($id,Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'  => 'max:40',
        ]);

        if($validation->fails())
            return error('Validation Error',$validation->errors(),'validation');

        if($request->name){
            $video = Video::findOrFail($id);
            $video->update([
                'name'  => $request->name
            ]);
            return ok('Video name updated successfully');
        }
    }

    public function delete($id)
    {
        Video::findOrFail($id)->delete();
        return ok('Video deleted successfully');
    }

    public function tag(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'video_id'   => 'required|exists:videos,id',
            'name'       => 'required'
        ]);

        if($validation->fails())
            return error('Validation Error',$validation->errors(),'validation');

        $video = Video::find($request->video_id);
        $tag = new Tag;
        $tag->name = $request->name;
        $video->tags()->save($tag);
        
        return ok('Tag added successfully',$tag);
    }
}
