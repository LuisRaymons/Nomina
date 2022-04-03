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
}
