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
        return view('courses.index', compact('courses'));
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

        Course::create($validated);
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display a specific course.
     */
    public function show($id)
    {
        $course = Course::with(['category', 'professors'])->findOrFail($id);
        return view('courses.show', compact('course'));
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
        
        #ako treba ovde da se menja za stranata
        return redirect()->route('courses.show', $courseId)->with('success', 'Professor assigned successfully.');
    }
}
