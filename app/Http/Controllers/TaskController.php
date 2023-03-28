<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTask;
use App\Models\Folder;
use App\Models\Task;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{
    public function index(int $id)
    {
        $folders = Auth::user   ()->folders()->get();
        $current_folder = Folder::find($id);

        $tasks = $current_folder->tasks()->get();


        return view('tasks/index',[
            'folders'=>$folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id){
        return view('tasks/create',[
            'folder_id'=>$id,
        ]);
    }

    public function create(int $id,CreateTask $request){
        $current_folder = Folder::find($id);

        $task = new Task();
        $task -> title = $request ->title;
        $task ->due_date = $request->due_date;

        $current_folder -> tasks()->save($task);

        return redirect()->route('tasks.index',[
            'id'=>$current_folder->id,
        ]);
    }

    public function showEditForm(int $id,$task_id){
        $task = Task::find($task_id);

        return view('tasks/edit',[
            'task' => $task,
        ]);
    }

    public function edit(int $id,int $task_id,EditTask $request){
        $task = Task::find($task_id);

        $task->title = $request ->title;
        $task->status =  $request ->status;
        $task->due_date = $request ->due_date;
        $task->save();

        return redirect()->route('tasks.index',[
            'id' => $task->folder_id,
        ]);
    }
}
