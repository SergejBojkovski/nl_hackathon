<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::with(['category', 'professors'])->get();
        return response()->json($courses);
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course = Course::create($validated);
        return response()->json($course, 201);
    }

    /**
     * Display a specific course.
     */
    public function show($id)
    {
        $course = Course::with(['category', 'professors'])->findOrFail($id);
        return response()->json($course);
    }

    /**
     * Assign a professor to a course.
     */
    public function assignProfessor(Request $request, $courseId)
    {
        $validated = $request->validate([
            'professor_id' => 'required|exists:users,id',
        ]);

        $course = Course::findOrFail($courseId);
        $professor = User::findOrFail($validated['professor_id']);

        // Attach professor with role 'professor'
        $course->professors()->attach($professor->id, ['role' => 'professor']);

        return response()->json(['message' => 'Professor assigned successfully']);
    }
}

