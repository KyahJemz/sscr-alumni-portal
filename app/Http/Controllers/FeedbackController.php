<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings = Feedback::orderBy('id', 'DESC')->get();
        $sum = 0;
        $ratingsSummary = [
            ['rating'=>1, 'count'=>0, 'percentage'=>0],
            ['rating'=>2, 'count'=>0, 'percentage'=>0],
            ['rating'=>3, 'count'=>0, 'percentage'=>0],
            ['rating'=>4, 'count'=>0, 'percentage'=>0],
            ['rating'=>5, 'count'=>0, 'percentage'=>0],
        ];

        $totalRatings = count($ratings);

        if ($totalRatings > 0) {
            foreach ($ratings as $value) {
                $sum += $value->rating;
                $ratingsSummary[$value->rating - 1]['count'] += 1;
                $ratingsSummary[$value->rating - 1]['percentage'] = round(($ratingsSummary[$value->rating - 1]['count'] / $totalRatings) * 100, 2);
            }

            $averageRating = round($sum / $totalRatings, 2);
        } else {
            $averageRating = 0;
        }

        $data = [
            'feedbacks' => $ratings,
            'ratings' => $ratingsSummary,
            'counts' => $totalRatings,
            'total' => $averageRating,
        ];

        return view('feedbacks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'rating' => 'required|string',
                'feedback' => 'required|string',
            ]);

            Feedback::create([
                'user_id' => Auth::user()->id,
                'rating' => $request->rating,
                'feedback' => $request->feedback
            ]);

            return redirect()->back()->with('success', 'Feedback submitted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
