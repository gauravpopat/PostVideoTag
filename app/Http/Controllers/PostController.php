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
        return ok('Post', $post);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'  => 'required|max:40',
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $post = Post::create($request->only(['name']));
        return ok('Post Created Succesfully', $post);
    }

    public function update($id, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'  => 'max:40',
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $post = Post::findOrFail($id);
        if ($request->name) {
            $post->update([
                'name'  => $request->name
            ]);
            return ok('Post Updated Successfully');
        }
    }

    public function delete($id)
    {
        Post::findOrFail($id)->delete();
        return ok('Post Deleted Successfully');
    }

    public function tag(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'post_id'   => 'required|exists:posts,id',
            'name'      => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $post = Post::find($request->post_id);
        $tag = new Tag;
        $tag->name = $request->name;
        $post->tags()->save($tag);

        return ok('Tag added successfully',$tag);
    }
}
