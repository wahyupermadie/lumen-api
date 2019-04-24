<?php namespace App\Http\Controllers;

use App\Item;
use App\Checklist;
use App\Template;
use Illuminate\Http\Request;

class TemplatesController extends Controller {

    public function all()
    {
        return Template::with(['checklist'])->with(['item'])->paginate();
    }

    public function get($templateid)
    {
        return Template::with(['checklist'])->with(['item'])->find($templateid);
    }

    public function remove($templateid)
    {
        $deleted = Template::find($checklistid)->delete();
        if($deleted){
            return response()->json(['message' => 'Delete Successfully'],200);
        }
        return response()->json([
            'message' => "Error Deleted Data"
        ],500);
    }

    public function put(Request $request,$templateid)
    {
        $item = Template::updateOrCreate(
            ['id' => $templateid],
            [
                'name' => $request->name
            ]
        );
        if($item){
            return response()->json(['message' => 'Update Successfully'],200);
        }
        return response()->json([
            'message' => "Error Update Data"
        ],500);
    }
}
