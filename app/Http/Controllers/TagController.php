<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;

class TagController extends Controller
{
    use ResponseTrait;
    public function list($id)
    {
        $tag = Tag::findOrFail($id);
        return ok('Post', $tag);
    }

    public function update($id, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'  => 'max:40'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        if ($request->name) {
            $tag = Tag::findOrFail($id);
            $tag->update([
                'name'  => $request->name
            ]);
            return ok('Tag Updated Successfully');
        }
    }

    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return ok('Tag Deleted Successfully');
    }
}
