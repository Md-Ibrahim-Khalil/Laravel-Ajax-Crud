<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;





class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('teacher.index');
    }

    //All Data

    public function allData(){
        
        $data = Teacher::orderBy('id','DESC')->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeData(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);

        $data = Teacher::insert([
            
            'name' => $request->name,
            'title' => $request->title,
            'institute' => $request->institute
        ]);
        
        return response()->json($data);
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
    public function editData($id)
    {
        $data = Teacher::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);

        $data = Teacher::findOrFail($id)->update([
            
            'name' => $request->name,
            'title' => $request->title,
            'institute' => $request->institute,
        ]);
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Teacher::destroy($id);
        Alert::success('Success', 'Item Deleted Successfully');
        return back();
    }
}