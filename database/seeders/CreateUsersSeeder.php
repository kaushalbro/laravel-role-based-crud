<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $user = User::create([
        //     'name' => 'kjfhdsddkf',
        //     'email' => 'kshdjddkfhs@gmail.com',
        //     'password' => bcrypt('123456')
        // ]);

        // $role = Role::create(['name' => 'kshfdddkah']);
        // $permissions = Permission::pluck('id', 'id')->all();
        // $role->syncPermissions($permissions);
        // $user->assignRole([$role->id]);
        // Task::create([
        //     'name' => 'task1',
        //     'description' => 'task_1 description',
        //     'creator' => 1,
        //     'status' => 'Pending'
        // ]);
        $task = Task::find(9);
        // dd($task->id);
        $user = User::find(9);

        $task->assigUser()->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        // $data = Task::with('user')->get();
        // dd($data);

    }
}
