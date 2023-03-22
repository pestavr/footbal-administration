<?php

namespace App\Http\Controllers\Backend\Education;

use Storage;
use Redirect;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Models\Backend\RefereeEducation;
use App\Models\Backend\EducationQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefereeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $status = 'Active';
        if (request()->has('active') && request()->active == 0){
            $status = 'Inactive';
        }
        
        if (request()->expectsJson()){
            
            $educations = RefereeEducation::whereStatus(request()->status)->get();

            return Datatables::of($educations)
            ->addColumn('title', function($educations) {
                return $educations->title;
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
                    
                    return view('backend.includes.partials.actions',[
                        'refereeEducation'=>$educations->id, 
                        'condition'=>(request()->status == 'Active') ? 'activate' : 'deactivate', 
                        'page'=>'educations']);
            })
            ->rawColumns(['actions', 'reference_link'])
            ->make(true);
        }
        return view('backend.education.referee.index', compact('status'));
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function show(RefereeEducation $refereeEducation)
    {
        $refereeEducation->load('questions.answers');

        return view('backend.education.referee.show', compact('refereeEducation'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.education.referee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if ($request->hasFile('pdf')){
            $file = $request->pdf->store("educational_staff");
            $fileUrl = Storage::disk('public')->url($file);
        }else{
            $fileUrl = $request->video_link;
        }

        $refereeEducation = RefereeEducation::create([
            'title' => $request->title,
            'reference_link' => $fileUrl,
            'details' => $request->details,
            'status' => 'Active',
            'date_added' => date('Y-m-d H:i:s'),
            'added_by_user' => $request->user()->id
        ]);

        if (!empty($request->question)){
            $questions = $request->question;
            $answers = $request->answer;
            $suggestions = $request->suggestion;
            $counter = 0;
            foreach($questions as $question){
                if (!empty($question)){
                    $educationQuestion = new  EducationQuestion([
                        'question' => $question,
                        'answer' => $answers[$counter],
                        'suggestion' => $suggestions[$counter],
                        'date_added' => date('Y-m-d H:i:s'),
                    ]);

                    $educationQuestion->education()->associate($refereeEducation);
                    $educationQuestion->save();
                }
                $counter++;
            }
        }

        return Redirect::route('admin.education.referees.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ref_observer  $ref_observer
     * @return \Illuminate\Http\Response
     */
    public function edit(RefereeEducation $refereeEducation)
    {
        if (request()->has('question')){
            return response()->json([
                'ok' => true,
                'question' => EducationQuestion::findOrFail(request()->question) 
            ]);
        }
        $refereeEducation->load('questions');
        return view('backend.education.referee.edit', compact('refereeEducation'));
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
        if ($request->has('question')){
            $educationQuestion = EducationQuestion::whereId($request->id)->first();
            if ($educationQuestion) {
                $educationQuestion->update($request->except(['id']));
            }
            return response()->json([
                'ok' => true,
                'question' => view('backend.education.referee.partials.question', ['question' => $educationQuestion])->render()
            ]);
        }
        if ($request->has('mode')){
            if ($request->mode == 'activate'){
                $refereeEducation->update([
                    'status' => 'Active'
                ]);
            }else{
                $refereeEducation->update([
                    'status' => 'Inactive'
                ]);
            }
            return Redirect::route('admin.education.referees.index');
        }
        $fileUrl =  $refereeEducation->reference_link;
        if ($request->hasFile('pdf')){
            $file = $request->pdf->store("educational_staff");
            $fileUrl = Storage::disk('public')->url($file);
        }else{
            if (!empty($request->video_link))
                $fileUrl = $request->video_link;
        }

        $refereeEducation->update([
            'title' => $request->title,
            'reference_link' => $fileUrl,
            'details' => $request->details,
        ]);

        if (!empty($request->questions)){
            $questions = $request->questions;
            $answers = $request->answers;
            $suggestions = $request->suggestions;
            $counter = 0;
            foreach($questions as $question){
                if (!empty($question)){
                    $educationQuestion = new  EducationQuestion([
                        'question' => $question,
                        'answer' => $answers[$counter],
                        'suggestion' => $suggestions[$counter],
                        'date_added' => date('Y-m-d H:i:s'),
                    ]);

                    $educationQuestion->education()->associate($refereeEducation);
                    $educationQuestion->save();
                }
                $counter++;
            }
        }

        return Redirect::route('admin.education.referees.index');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefereeEducation $refereeEducation)
    {
        if (request()->has('question')){
            $educationQuestion = EducationQuestion::whereId(request()->question)->first();
            if ($educationQuestion) {
                $educationQuestion->delete();
            }
            return response()->json([
                'ok' => true
            ]);
        }
        
        $refereeEducation->delete();

        return response()->json([
            'ok' => true
        ]);
    }
}
