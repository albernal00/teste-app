<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\CreateTask;
use Tests\TestCase;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

     public function setUp():void
     {
         parent::setUp();
 
         // テストケース実行前にフォルダデータを作成する
         $this->seed('FoldersTableSeeder');
     }

    public function due_date_should_be_date(): void
    {
        $response = $this->post('/folders/1/tasks/create',[
            'title' => 'sample task',
            'due_date' => 123,
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日は日付を入力してください',
        ]);
    }

    public function due_date_should_not_be_past():void{
        $response = $this->post('folders/1/tasks/create',[
            'title' => 'sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日は今日以降の日付を入力してください',
        ]);
    }

    public function status_should_be_within_defined_numbers()
{
    $this->seed('TasksTableSeeder');

    $response = $this->post('/folders/1/tasks/1/edit', [
        'title' => 'Sample task',
        'due_date' => Carbon::today()->format('Y/m/d'),
        'status' => 999,
    ]);

    $response->assertSessionHasErrors([
        'status' => '状態 には 未着手、着手中、完了 のいずれかを指定してください。',
    ]);
}
}
