<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }

    public function index()
    {
        $statuses = StatusResource::collection(
            Status::latest()->paginate()
        );

        return $statuses;
    }

    public function store(Request $request)
    {
        $request->validate(['body' => 'required|min:5']);

        $status = Status::create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        return StatusResource::make($status);
    }
}
