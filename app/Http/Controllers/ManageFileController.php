 <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Add;
use App\Lesson;
use Auth;
use App\User;
use App\Notifications\NewLessonNotification;

class ManageFileController extends Controller
{


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function attachFile(){
      return view('add');
    }

  public function uploadFile(Request $request){
    // $request->validate([
    //        'file' => 'required|mimes:pdf,xlx,csv|max:2048',
    //    ]);

          $add=new Add;

          $add->Document_name=$request->input('doc_name');
          $add->Department=$request->input('department');
          $add->Description=$request->input('description');

          $uploadedFile = $request->file('fileToUpload');

          $filePath = base_path().'/public'.'/documents';

            if ($uploadedFile->isValid()) {
              $fileName = $uploadedFile->getClientOriginalName();
                $uploadedFile->move($filePath, $fileName);
            }
          $url=$filePath.'/'.$fileName;
          // var_dump($url);exit;
          $add->File=$url;
          $add->status="Assigned";

          $add->save();

          // var_dump(Auth::user()->id);exit;
          $lesson = new Lesson;
          $lesson->user_id=Auth::user()->id;
          $lesson->title=$fileName;
          $lesson->body='New File was uploaded : ';
          $lesson->save();

          $user=User::all();

          // var_dump($user);exit;

          if (\Notification::send($user,new NewLessonNotification(Lesson::latest('id')->first()))) {
            return back();
          }

          $message='Successfully updated';
          return redirect()->route('viewUploads',[$message]);
  }

  // public function getdata()
  //   {
  //    $viewFileData = Add::all();
  //    var_dump($viewFileData);exit;
  //    return Datatables::of($students)->make(true);
  //   }

}
