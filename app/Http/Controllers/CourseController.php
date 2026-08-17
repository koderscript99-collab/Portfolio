<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)->latest()->get();

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $enrolled = $course->hasStudent(auth()->user());

        return view('courses.show', compact('course', 'enrolled'));
    }

    // For a free course this enrolls immediately.
    // For a paid course, route this through CheckoutController the same way
    // products work — reuse the Order flow with a polymorphic "purchasable"
    // relation once you outgrow this simple version.
    public function enroll(Course $course)
    {
        abort_if($course->price > 0, 403, 'Paid courses must go through checkout.');

        Enrollment::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
        ], [
            'enrolled_at' => now(),
        ]);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'You\'re enrolled!');
    }
}