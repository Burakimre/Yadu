<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\EditLinkRequest;
use App\Http\Requests\EditEmailRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use Hamcrest\Type\IsArray;
use Illuminate\Support\Facades\Auth;
use App\socialmedia;

class EditLinksController extends Controller
{
    public function index()
    {
        $socialmedia = socialmedia::all();
        return view("admin.links.editLinks",compact('socialmedia'));
    }

    public function saveLink(EditLinkRequest $request){
        $socialmedia = socialmedia::findOrFail($request['name']);
        $socialmedia->link = $request['link'];
        $socialmedia->save();
        return back();
    }

    public function saveEmail(EditEmailRequest $request){
        $socialmedia = socialmedia::findOrFail($request['name']);
        $socialmedia->link = $request['email'];
        $socialmedia->save();
        return back();
    }
}
