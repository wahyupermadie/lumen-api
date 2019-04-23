<?php namespace App\Http\Controllers;

use App\Item;
use App\Checklist;
use Illuminate\Http\Request;

class ItemsController extends Controller {
    public $offset = 0;
    public $limit = 10;
    public $field = 'id';
    public $sort = 'asc';
    public $filter = '';

    public function complete_item()
    {
        $items = Item::where('is_completed',1)->get();
        if($items){
            return response()->json($items,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }

    public function incomplete_item()
    {
        $items = Item::where('is_completed',0)->get();
        if($items){
            return response()->json($items,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }

    public function item_with_checklist(Request $request,$checklistid)
    {
        $reqLimit = $this->limit;
        $reqOffset = $this->offset;
        $reqField = $this->field;
        $reqSort = $this->sort;
        $reqFilter = $this->filter;

        if(isset($request->limit)){
            $reqLimit = $request->limit;
        }

        if(!empty($request->offset)){
            $reqOffset = $request->offset;
        }

        if(!empty($request->field)){
            $reqField = $request->field;
        }

        if(!empty($request->sort)){
            $reqSort = $request->sort;
        }

        if(!empty($request->filter)){
            $reqFilter = $request->filter;
        }

        $items = Checklist::with(['item' => function($q) use($reqLimit,$reqOffset,$reqField,$reqSort,$reqFilter){
            $q->skip($reqOffset)
                  ->take($reqLimit)
                  ->where('name','LIKE','%'.$reqFilter.'%')
                  ->orderBy($reqField,$reqSort);
        }])->find($checklistid);
        if($items){
            $data = (object)array(
                'type' => 'checklists',
                'id' => $checklistid,
                'attributes' => $items
                );
            return response()->json($data,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }

    public function create_checklist_item(Request $request, $checklistid)
    {
        $item = Item::create([
            'name' => $request->name,
            'is_completed' => $request->is_completed,
            'checklist_id' => $checklistid,
            'due' => $request->due,
            'urgency' => $request->urgency,
            'compeleted_at' => $request->completed_at,
            'last_update_by' => $request->last_update_by,
        ]);
        if($item){
            $data = (object)array(
                'type' => 'checklists',
                'id' => $checklistid,
                'attributes' => $item
            );
            return response()->json($data,200);
        }
        return response()->json([
            'message' => "Error Creating Data"
        ],500);
    }

    public function get_checklist_item($itemid, $checklistid)
    {
        $item = Checklist::with(['item' => function ($q) use($itemid){
            $q->where('id',$itemid)->first();
        }])->where('id',$checklistid)->first();
        if($item){
            $data = (object)array(
                'type' => 'checklists',
                'id' => $checklistid,
                'attributes' => $item
            );
            return response()->json($data,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }

    public function destroy($itemid,$checklistid)
    {
        $deleted = Item::where('checklist_id',$checklistid)
                    ->find($itemid)->delete();
        if($deleted){
            return response()->json(['message' => 'Delete Successfully'],200);
        }
        return response()->json([
            'message' => "Error Deleted Data"
        ],500);
    }
}
