<?php

namespace App\Http\Controllers\Backend\Education;

use Yajra\Datatables\Facades\Datatables;
use App\Models\Backend\EducationAnswer;
use App\Models\Backend\EducationQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function show(EducationQuestion $educationQuestion)
    {
        if (request()->expectsJson()){
            $educationQuestion->load('answers.user');
            $answers = $educationQuestion->answers;

            return Datatables::of($answers)
            ->addColumn('user', function($answers) {
                return $answers->user->last_name.' '.$answers->user->first_name;
            })
            ->addColumn('answer', function($answers) {
                return $answers->answer;
            })
            ->addColumn('comment', function($answers) {
                return '<input type="text" class="form-control add-comment" data-id="'.$answers->id.'" value="'.$answers->comment.'">';
            })
            ->addColumn('date_answered', function($answers) {
                return $answers->date_answered;
            })
            ->addColumn('right_answer', function($answers) {
                if ($answers->right_answer !== null)
                return $answers->right_answer == 1 ? 'Ναι' : 'Όχι';
            })
            ->addColumn('actions',function($answers){
                return view('backend.education.referee.answers.includes.actions',[
                    'educationAnswer'=>$answers->id,
                ]);                    
            })
            ->rawColumns(['actions', 'comment'])
            ->make(true);
        }
        

        return view('backend.education.referee.answers.index', compact('educationQuestion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ref_observer  $ref_observer
     * @return \Illuminate\Http\Response
     */
    public function update(EducationAnswer $educationAnswer, Request $request)
    {
        if ($request->has('comment')){
            $educationAnswer->update([ 'comment' => $request->comment]);
            
            return response()->json([
                'ok' => true
            ]);
        }

        if ($request->has('answer')){
            if ($request->answer == 'right'){
                $educationAnswer->update([ 'right_answer' => 1]);
            }

            if ($request->answer == 'wrong'){
                $educationAnswer->update([ 'right_answer' => 0]);
            }
        }

            

            return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
    }
}
