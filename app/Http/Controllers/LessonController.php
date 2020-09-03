<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\NewLessonNotification;
use App\Lesson;
use App\User;
use Auth;

class LessonController extends Controller
{
    public function _construct(){
      $this->middleware('auth');
    }

    public function newLesson(){

      // var_dump(Auth::user()->id);exit;
      $lesson = new Lesson;
      $lesson->user_id=Auth::user()->id;
      $lesson->title='laravel Notification model';
      $lesson->body='this is the lesson';
      $lesson->save();

      $user=User::where('id','!=',Auth::user()->id)->get();

      // var_dump($user);exit;

      if (\Notification::send($user,new NewLessonNotification(Lesson::latest('id')->first()))) {
        return back();
      }
    }

}
