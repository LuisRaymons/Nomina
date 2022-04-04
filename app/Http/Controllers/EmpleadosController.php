<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\EmpleadosModel;
use Response;

class EmpleadosController extends Controller
{
    public function getempleados(){
      try {
        $existregister = EmpleadosModel::whereNull('deleted_at')->count();

        if($existregister > 0){
          $empleados = EmpleadosModel::whereNull('deleted_at')->get();

          $result['code'] = 200;
          $result['status'] = 'success';
          $result['data'] = $empleados;
        } else{
          $result['code'] = 204;
          $result['status'] = 'warning';
          $result['data'] = array();
        }
      } catch (\Exception $e) {
        $result['code'] = 500;
        $result['status'] = 'success';
        $result['data'] = array();
      }
      return Response::json($result);
    }

    public function store(Request $request){
      try{

        $validator = Validator::make($request->all(),
          [
            'name'=> 'required | regex:/^[a-z\_\-\s]+$/i',
            'lastnameP' => 'required  | regex:/^[a-z\_\-\s]+$/i',
            'lastnameM' => 'required  | regex:/^[a-z\_\-\s]+$/i',
            'email'=> 'required|email',
            'typecontrato'=> 'required'
          ],
          [
            'name.required'=> 'El nombre es requerido',
            'name.regex'=> 'El nombre no debe contener caracteres especiales ni numeros',
            'lastnameP.required' => 'El apellido paterno es requerido',
            'lastnameP.regex' => 'El apellido paterno no debe contener caracteres especiales ni numeros',
            'lastnameM.required' => 'El apellido materno es requerido',
            'lastnameM.regex' => 'El apellido materno no debe contener caracteres especiales ni numeros',
            'email.required'=> 'El correo es requerido',
            'email.email'=> 'El formato de correo es incorrecto',
            'typecontrato.required'=> 'El tipo de contrato es reuerido'
          ]
        );

        if(!$validator->fails()){
          $nombre = isset($request->name) ? $request->name : '';
          $lasnameP = isset($request->lastnameP) ? $request->lastnameP : '';
          $lasnameM = isset($request->lastnameM) ? $request->lastnameM : '';
          $email = isset($request->email) ? $request->email : '';
          $typecontrato = isset($request->typecontrato) ? $request->typecontrato : '';

          $empleadonew = new EmpleadosModel();
          $empleadonew->codigo = $this->generarCodigo();
          $empleadonew->nombre = $nombre;
          $empleadonew->apellidopaterno = $lasnameP;
          $empleadonew->apellidomaterno = $lasnameM;
          $empleadonew->correoelectronico = $email;
          $empleadonew->tipocontrato = $typecontrato;
          $empleadonew->estado = 'activo';
          $empleadonew->created_at = date('Y-m-d H:m:s');
          $empleadonew->updated_at = date('Y-m-d H:m:s');
          $empleadonew->save();

          $result['code'] = 200;
          $result['status'] = 'success';
          $result['msm'] = 'El registro de empleado fue registrado con exito';
        } else{
          $result['code'] = 400;
          $result['status'] = 'warning';
          $result['msm'] = $validator->errors();
        }
      } catch(\Exception $e){
        $result['code'] = 500;
        $result['status'] = 'success';
        $result['msm'] = $e->getMessage(); //'Error al guardar el nuevo empleado';
      }
      return Response::json($result);
    }

    public function updatefn(Request $request){
      try{

          $validator = Validator::make($request->all(),
            [
              'id'=>'required | numeric',
              'name'=> 'required | regex:/^[a-z\_\-\s]+$/i',
              'lastnameP' => 'required  | regex:/^[a-z\_\-\s]+$/i',
              'lastnameM' => 'required  | regex:/^[a-z\_\-\s]+$/i',
              'email'=> 'required|email',
              'typecontrato'=> 'required'
            ],
            [
              'id.required'=>'El id del empleado es requerido para su modificacion',
              'id.numeric'=>'El id deve ser numerico',
              'name.required'=> 'El nombre es requerido',
              'name.regex'=> 'El nombre no debe contener caracteres especiales ni numeros',
              'lastnameP.required' => 'El apellido paterno es requerido',
              'lastnameP.regex' => 'El apellido paterno no debe contener caracteres especiales ni numeros',
              'lastnameM.required' => 'El apellido materno es requerido',
              'lastnameM.regex' => 'El apellido materno no debe contener caracteres especiales ni numeros',
              'email.required'=> 'El correo es requerido',
              'email.email'=> 'El formato de correo es incorrecto',
              'typecontrato.required'=> 'El tipo de contrato es reuerido'
            ]
          );

          if(!$validator->fails()){
            $id = isset($request->id) ? $request->id : 0;
            $nombre = isset($request->name) ? $request->name : '';
            $lasnameP = isset($request->lastnameP) ? $request->lastnameP : '';
            $lasnameM = isset($request->lastnameM) ? $request->lastnameM : '';
            $email = isset($request->email) ? $request->email : '';
            $typecontrato = isset($request->typecontrato) ? $request->typecontrato : '';

            $empleadonew = EmpleadosModel::find($id);
            $empleadonew->nombre = $nombre;
            $empleadonew->apellidopaterno = $lasnameP;
            $empleadonew->apellidomaterno = $lasnameM;
            $empleadonew->correoelectronico = $email;
            $empleadonew->tipocontrato = $typecontrato;
            $empleadonew->updated_at = date('Y-m-d H:m:s');
            $empleadonew->save();

            $result['code'] = 200;
            $result['status'] = 'success';
            $result['msm'] = 'El registro de empleado fue modificado con exito';
          } else{
            $result['code'] = 400;
            $result['status'] = 'warning';
            $result['msm'] = $validator->errors();
          }
      } catch(\Exception $e){
        $result['code'] = 500;
        $result['status'] = 'success';
        $result['msm'] = 'Error al guardar el empleado';
      }
      return Response::json($result);
    }

    public function destroy($id){
      try{
        $existempleado = EmpleadosModel::whereNull('deleted_at')->where('id','=',$id)->count();

        if($existempleado > 0){
          $empleadomodel = EmpleadosModel::whereNull('deleted_at')->where('id','=',$id)->first();
          $empleadomodel->deleted_at = date('Y-m-d H:m:s');
          $empleadomodel->save();

          $result['code'] = 200;
          $result['status'] = 'success';
          $result['msm'] = 'El empleado fue dado de baja con exito';

        } else{
          $result['code'] = 204;
          $result['status'] = 'warning';
          $result['msm'] = 'El empleado no se encuentra disponible';
        }

      } catch(\Exception $e){
        $result['code'] = 500;
        $result['status'] = 'success';
        $result['msm'] = 'Error al eliminar el empleado';
      }
      return Response::json($result);      
    }

    public function statuschange(Request $request){
      try {
        $validator = Validator::make($request->all(),
          [
            'id'=> 'required',
            'status' => 'required | in:"activo","inativo"',
          ],
          [
            'id.required'=> 'El id es requerido',
            'status.required'=> 'El estatus es requerido',
            'status.in'=> 'El estatus solo permite valores activo y/o inativo'
          ]
        );

        if(!$validator->fails()){
          $employeestatus = EmpleadosModel::find($request->id);
          $employeestatus->estado = $request->status;
          $employeestatus->updated_at = date('Y-m-d H:m:s');
          $employeestatus->save();

          $result['code'] = 200;
          $result['status'] = 'success';
          $result['msm'] = 'El estatus del empleado fue modificado con exito';

        } else{
          $result['code'] = 400;
          $result['status'] = 'warning';
          $result['msm'] = $validator->errors();
        }
      } catch (\Exception $e) {
        $result['code'] = 500;
        $result['status'] = 'error';
        $result['msm'] = 'Error al cambiar el estatus del empleado';
      }
      return Response::json($result);
    }


    private function generarCodigo() {
      $alfanumerico = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      return 'code-'.substr(str_shuffle($alfanumerico), 0, 10);
  } 
}
