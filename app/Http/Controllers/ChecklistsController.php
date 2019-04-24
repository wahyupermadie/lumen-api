<?php namespace App\Http\Controllers;

use App\Item;
use App\Checklist;
use App\Template;
use Illuminate\Http\Request;

class ChecklistsController extends Controller {

    public function all(Request $request)
    {
        if(isset($request->include)){
            return Checklist::with([$request->include])->paginate();
        }else{
            return Checklist::paginate();
        }
    }

    public function get(Request $request,$checklistid)
    {
        if(isset($request->include)){
            return Checklist::with(["$request->include"])->find($checklistid);
        }else{
            return Checklist::find($checklistid);
        }
    }

    public function put(Request $request,$checklistid)
    {
        $item = Checklist::updateOrCreate(
            ['id' => $checklistid],
            [
                'object_domain' => $request->object_domain,
                'template_id' => $request->template_id,
                'object_id' => $request->object_id,
                'description' => $request->description,
                'is_completed' => $request->is_completed,
                'completed_at' => $request->completed_at,
                'due' => $request->due,
                'urgency' => $request->urgency
            ]
        );
        if($item){
            return response()->json(['message' => 'Update Successfully'],200);
        }
        return response()->json([
            'message' => "Error Update Data"
        ],500);
    }

    public function remove($checklistid)
    {
        $deleted = Checklist::find($checklistid)->delete();
        if($deleted){
            return response()->json(['message' => 'Delete Successfully'],200);
        }
        return response()->json([
            'message' => "Error Deleted Data"
        ],500);
    }

    public function add(Request $request)
    {
        $checklist = Checklist::create(
            [
                'object_domain' => $request->object_domain,
                'template_id' => $request->template_id,
                'object_id' => $request->object_id,
                'description' => $request->description,
                'is_completed' => $request->is_completed,
                'completed_at' => $request->completed_at,
                'due' => $request->due,
                'urgency' => $request->urgency
            ]
        );

        if($checklist){
            return response()->json(['message' => 'Create Successfully'],200);
        }
        return response()->json([
            'message' => "Error Create Data"
        ],500);
    }
}
