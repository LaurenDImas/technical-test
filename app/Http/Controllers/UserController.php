<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = new User;
        $this->path = 'photos';
    }

    public function list(){
        // params
        try {

            $data = request()->all();
            $q  = $data['q'];
            $ob = $data['ob'] ? $data['ob'] : "id";
            $sb = $data['sb'] ? $data['sb'] : "ASC";
            $lt = $data['lt'] ? $data['lt'] : 10;
            $of = $data['of'];


            Paginator::currentPageResolver(function () use ($of) {
                return $of;
            });

            // get semua data user
            $users = $this->user->query();

            // kondisi search by kolom
            $users->when($q, function($query) use ($q) {
                return $query->whereLike(["name","address","email","password","photos","creditcard_type","creditcard_number","creditcard_name","creditcard_expired","creditcard_cvv"],$q);
            });

            // orderby dan paginate
            $users = $users->orderBy("id", $sb)->paginate($lt);

            return  response()->json(
                [
                    "count"         =>$users->total(),
                    "rows"          =>collect($users->getCollection())->map(function($e){
                                        return $this->user->formatted($e);
                                    }),
                ],200
            );
        }catch(\Exception $e) {
            return response()->json([ 'error'=> "Somethind went wrong. Please try again"], 500);
        }
    }


    public function register(Request $request){
        try {
            $data = $request->all();

            $validationRequired = $this->user->validation($request);
            if($validationRequired){
                return response()->json([ 'error'=> $validationRequired ], 400);
            }

            $uniqueEmail = $this->user->where('email', $request->email)->first();
            if(!empty($uniqueEmail)){
                return response()->json([ 'error'=> "Email data has been invalid." ], 400);
            }


            if($photos = $this->uploadPhoto($request->file('photos'))){
                $data['photos'] = implode(",", $photos);
            }else{
                return response()->json([ 'error'=> "Photos card data invalid." ], 400);
            }

            $user = $this->user->create($data);
            return response()->json([ 'user_id'=> $user->id ], 200);

        } catch(\Exception $e) {

            return response()->json([ 'error'=> "Somethind went wrong. Please try again"], 500);
        }
    }

    public function update(Request $request, $id){
        try {

            $user = $this->user->find($id);

            $data = $request->all();

            $validationRequired = $this->user->validation($request);
            if($validationRequired){
                return response()->json([ 'error'=> $validationRequired ], 400);
            }

            $uniqueEmail = $this->user->where('email', $request->email)->where('id','!=', $id)->first();
            if(!empty($uniqueEmail)){
                return response()->json([ 'error'=> "Email data has been invalid." ], 400);
            }

            if($photos = $this->uploadPhoto($request->file('photos'), $user->photo)){
                $data['photos'] = implode(",", $photos);
            }else{
                return $user->photo;
            }

            $user = $user->update($data);

            return response()->json([ 'user_id'=> $user ], 200);

        } catch(\Exception $e) {

            return response()->json([ 'error'=> "Somethind went wrong. Please try again"], 500);
        }
    }

    public function detail($id){
        try {
            $user = $this->user->find($id);
            return response()->json([ $this->user->formatted($user) ], 200);

        } catch(\Exception $e) {

            return response()->json([ 'error'=> "Somethind went wrong. Please try again"], 500);
        }
    }

    private function uploadPhoto($request, $photo = null){
        $files = [];
        if ($request){
            if($photo){
                $photo = explode(',', $photo);
                foreach($photo as $r){
                    if(File::exists(public_path($this->path.$photo))){
                        File::delete(public_path($this->path.$photo));
                    }
                }
            }
            foreach($request as $key => $file)
            {
                $fileName = time().rand(1,99).'.'.$file->extension();
                $file->move($this->path, $fileName);
                $files[] = $fileName;
            }
        }else{
            return "";
        }
        return $files;
    }
}
