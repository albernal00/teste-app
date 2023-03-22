<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFolder;
use App\Models\Folder;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Illuminate\Support\Facades\Auth;


class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }



    public function create(CreateFolder $request){

        $folder = new Folder();
        $folder->title = $request->title;

        Auth::user()->folders()->save($folder);
        $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
