<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function create(){
        $candidates = \App\Models\Candidate::all();
        return view('vote.create', [
            'candidates' => $candidates,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $vote = new \App\Models\Vote();
        $vote->candidate_id = $request->input('candidate_id');
        $vote->user_id = Auth::id();
        $vote->save();

        return redirect('/dashboard')->with('success', 'Vote cast successfully!');
    }
}
