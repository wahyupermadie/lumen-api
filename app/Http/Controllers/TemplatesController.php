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
}
