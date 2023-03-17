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
        return $tag;
    }

    public function update($id,Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'  => 'max:40'
        ]);

        if($validation->fails())
            return $this->returnResponse(false,'Validation Error',$validation->errors());

        if($request->name){
            $tag = Tag::findOrFail($id);
            $tag->update([
                'name'  => $request->name
            ]);
            return $this->returnResponse(true,'Tag updated successfully');
        }
    }

    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return $this->returnResponse(true,'Tag deleted successfully');
    }
}
