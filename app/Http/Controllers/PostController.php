<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    use ResponseTrait;

    public function list($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        return $this->returnResponse(true,'Post',$post);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'  => 'required|max:40',
        ]);

        if($validation->fails())
            return $this->returnResponse(false,'Validation Error',$validation->errors());

        $post = Post::create($request->only(['name']));
        return $this->returnResponse(true,'Post Created Successfully',$post);
    }

    public function update($id,Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'  => 'max:40',
        ]);

        if($validation->fails())
            return $this->returnResponse(false,'Validation Error',$validation->errors());

        $post = Post::findOrFail($id);
        if($request->name){
            $post->update([
                'name'  => $request->name
            ]);
            return $this->returnResponse(true,'Post Name Updated Successfully');
        }
    }

    public function delete($id)
    {
        Post::findOrFail($id)->delete();
        return $this->returnResponse(true,'Post Deleted Successfully');
    }

    public function tag(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'post_id'   => 'required|exists:posts,id',
            'name'      => 'required'
        ]);

        if($validation->fails())
            return $this->returnResponse(false,'Validation Error',$validation->errors());

        $post = Post::find($request->post_id);
        $tag = new Tag;
        $tag->name = $request->name;
        $post->tags()->save($tag);

        return $this->returnResponse(true,'tag Added',$tag);
    }
}
