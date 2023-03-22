<?php

namespace App\Http\Controllers\Backend\Education;

use Yajra\Datatables\Facades\Datatables;
use App\Models\Backend\RefereeEducation;
use App\Models\Backend\EducationQuestion;
use App\Models\Backend\EducationAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyEducationController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        
        
        if (request()->expectsJson()){
            
            $educations = RefereeEducation::whereStatus('Active')->get();

            return Datatables::of($educations)
            ->addColumn('title', function($educations) {
                return '<a href="'.route('admin.education.referees.myeducation.show', $educations->id).'">'.$educations->title.'</a>';
            })
            ->addColumn('type', function($educations) {
                return $educations->type;
            })
            ->addColumn('reference_link', function($educations) {
                return '<a href="'.$educations->reference_link.'" target="_blank">'.$educations->reference_link.'</a>';
            })
            ->addColumn('date_added', function($educations) {
                return $educations->date_added;
            })
            ->addColumn('actions',function($educations){
                return view('backend.education.referee.myeducation.partials.actions',[
                    'refereeEducation'=>$educations->id
                ]);
            })
            ->rawColumns(['title', 'reference_link', 'actions'])
            ->make(true);
        }
        return view('backend.education.referee.myeducation.index');
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function show(RefereeEducation $refereeEducation)
    {
        $refereeEducation->load(['questions', 'questions.answers' => function ($q) {
            $q->where('education_answers.user_id', request()->user()->id);
        }]);
        
        return view('backend.education.referee.myeducation.show', compact('refereeEducation'));
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ref_observer  $ref_observer
     * @return \Illuminate\Http\Response
     */
    public function update(RefereeEducation $refereeEducation, Request $request)
    {
        if($request->has('answers')){
            foreach ($request->answers as $question => $answer){
                $educationAnswer = EducationAnswer::updateOrCreate([
                    'user_id' => $request->user()->id,
                    'question_id' => $question
                ],[
                    'answer' => $answer[0],
                    'date_answered' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση Απάντησης');
    }
}
