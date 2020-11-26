<?php

namespace App\Http\Controllers\Api;

use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $filter = $request->filter;
        $sortOrder = $request->sortOrder;
        $pageSize = $request->pageSize;
        
        //
        return User::searcher($filter)->orderBy('id', 'DESC')->paginate($pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'] 
        ]);

        $name = $request->name;
        $email = $request->email;
        $validateUser = User::where('email', $email)->get();


        if(count($validateUser)>=1){
            return response()->json(["message" => "El Usuaio ".$name." ya existe!!!"], 400);
        }else{

            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->role = $request->role;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->phone = $request->phone;
            $user->ci = $request->ci;
            $user->rut = $request->rut;
            $user->company = $request->company;
            $user->discount = $request->discount;
            $user->save();

            return response()->json($user, 200);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id); 

        return response()->json($user, 200);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request )
    {


        if($request->password){
            $user = User::find($id);
            $user->password = bcrypt($request->password);
            return response()->json(["message" => "Contraseña actualizada"], 200);
        }

        $name = $request->name;
        $email = $request->email;
        $validateUser = User::where('email', $email)->where('id', '!=', $id)->get();


        


        if(count($validateUser)>=1){
            return response()->json(["message" => "El Usuaio con correo ".$email." ya existe!!!"], 400);
        }else{

            $user = User::find($id);
            $user->name = $name;
            // $user->email = $email;
            $user->role = $request->role;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->phone = $request->phone;
            $user->ci = $request->ci;
            $user->rut = $request->rut;
            $user->company = $request->company;
            $user->discount = $request->discount;
            $user->save();

            return response()->json($user, 200);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json($user, 200);
    }




    public function search(Request $request){

        // $user = User::where('name')

    }

    public function export_user_excel(){
        // Storage::disk('public')->put('images/productos',  $img);
        return Excel::download(new UserExport, 'usuarios_nueva_era_web.xlsx');

    }
}
