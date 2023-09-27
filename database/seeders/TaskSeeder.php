<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        Task::create([
            'name' => 'task12',
            'description' => 'task_2 description',
            'creator' => Auth::id(),
            'status' => 'pending'
        ]);
        
    }
}
