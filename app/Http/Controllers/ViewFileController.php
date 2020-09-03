<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Add;

class ViewFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // if(request()->ajax()) {
            return datatables()->of(Add::select('*'))
            ->addColumn('action', 'action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        // }
        return view('view_document_data');
    }

    public function viewFile()
    {
      // // if(request()->ajax()) {
      //       return datatables()->of(Add::select('*'))
      //       ->addColumn('action', 'action')
      //       ->rawColumns(['action'])
      //       ->addIndexColumn()
      //       ->make(true);
      //   // }
        return view('view_document_data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $uploadedFile = $request->file('fileToUpload');
var_dump($uploadedFile);exit;
      $filePath = base_path().'/public'.'/documents';

        if ($uploadedFile->isValid()) {
          $fileName = $uploadedFile->getClientOriginalName();
            $uploadedFile->move($filePath, $fileName);
        }
      $url=$filePath.'/'.$fileName;
      // var_dump($url);exit;
      $add->File=$url;
      // $productId = $request->product_id;
      $document   =   Add::updateOrCreate(
                  ['Document_name' => $request->document_name, 'Department' => $request->department, 'Description' => $request->description,
                  'Description' => $request->description]);
      return Response::json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      var_dump('sndkmfjsd');exit;
      $where = array('id' => $id);
      $product = product::where($where)->first();

      return response::json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $record = Add::where('id',$id)->delete();

      // return Response::json($record);
      return redirect()->route('viewUploads');
    }
}
