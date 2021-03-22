<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ColorPalette;

class CalculateColor extends Controller
{
    public function getColor(Request $request){
        //Recoger datos
        $image = $request->file('file0');
        //Validar los datos
        $validate = \Validator::make($request->all(),[
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);
        //guardar imagen
        if($image){
            $image_name = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_name, \File::get($image));
        }else{
            //en caso de que la imagen no se haya subido correctamente
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'error al subir la imagen'
            );
            return response()->json($data,$data['code']);
        }
        $file = \Storage::disk('images')->get($image_name);

        $color = ColorPalette::getColor($file);

        return $color;

    }
}
