<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $field = [
        'name',
        'address',
        'email',
        'password',
        'photos',
        'creditcard_type',
        'creditcard_number',
        'creditcard_name',
        'creditcard_expired',
        'creditcard_cvv',
    ];


    public function scopeWhereLike($query, $attributes, $searchTerm)
    {
        return $query->where(function ($query) use ($attributes, $searchTerm) {
            foreach ($attributes as $attribute) {
                $query->when(
                    function ($query) use ($attribute, $searchTerm) {
                        $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                    }
                );
            }
        });
    }

    public function validation($request){

        $data = $request->all();
        $error_field = array_diff($this->field, array_keys($request->all()));

        foreach ($data as $key => $value) {
            if(!$value){
                $error_field[] = $key;
            }
        }

        $total_error = count($error_field);

        $error ="";
        if($total_error > 0){
            $imp_error = implode(", ", $error_field);
            $imp_error = $total_error > 1 ? substr_replace($imp_error, ' and', strrpos($imp_error, ','), 1) : $imp_error;
            $error = "Please provide ". $imp_error ." fields";
        }

        return $error;
    }

    public function formatted($e){
        return collect([
            "user_id"=> $e->id,
            "name"=> $e->name,
            "address"=> $e->address,
            "email"=> $e->email,
            "password"=> $e->password,
            "photos" => collect(explode(',',$e->photos))->map(function($e){
                return asset('photos/'.$e);
            }),
            "creditcard" => [
                "type" => $e->creditcard_type,
                "number" => $e->creditcard_number,
                "name" => $e->creditcard_name,
                "expired" => $e->creditcard_expired,
                "cvv" => $e->creditcard_cvv,
            ],
        ]);
    }
}
