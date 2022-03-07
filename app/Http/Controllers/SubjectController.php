<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSubject;
use App\Models\Subject;


class SubjectController extends Controller
{
    //
    function addSubject(Request $request){
        // return $request;
        $rules = [
            'subject' => 'required',
        ];
        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response['result'] = false;
            $response['message'] = $validator->getMessageBag()->toArray();
            return Response()->json($response, 200);
        }
        // new subject
        $subject = new Subject();
        $subject->name = $request->subject;
        $subject->save();
        // new subject attach with user
        $subject->users()->attach(auth()->user()->id);
        // response
        $response['result'] = true;
        $response['message'] = "subjects";
        $response['subjects'] = &auth()->user()->subjects;
        return response()->json($response,200);
    }

    function userSubject(){
        $response['result'] = true;
        $response['message'] = "subjects";
        $response['subjects'] = &auth()->user()->subjects;
        return response()->json($response,200);
    }
}
