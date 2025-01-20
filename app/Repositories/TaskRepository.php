<?php
// app/Repositories/TaskRepository.php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getAllByUser($userId)
    {
        return Task::where('user_id', $userId)->with('user')->paginate(10);
    }

    public function findByIdAndUser($id, $userId)
    {
        return Task::where('user_id', $userId)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $task = Task::where('user_id', $userId)->findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function delete($id, $userId)
    {
        $task = Task::where('user_id', $userId)->findOrFail($id);
        return $task->delete();
    }
}