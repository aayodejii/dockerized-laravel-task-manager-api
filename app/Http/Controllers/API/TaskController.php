<?php
// app/Http/Controllers/API/TaskController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\TaskRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        return response()->json([
            'data' => $this->taskRepository->getAllByUser(Auth::id())
        ]);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        
        $task = $this->taskRepository->create($data);
        
        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return response()->json([
            'data' => $this->taskRepository->findByIdAndUser($id, Auth::id())
        ]);
    }

    public function update(TaskRequest $request, $id)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        
        $task = $this->taskRepository->update($id, Auth::id(), $data);
        
        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    public function destroy($id)
    {
        $this->taskRepository->delete($id, Auth::id());
        
        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}