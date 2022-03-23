<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class ApiController extends Controller
{
    public function getAllStudents(){
        $student = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($student, 200);
    }
    public function createStudent(Request $request){
        $student = New Student;
        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json([
            "message" => "Registro do aluno criado com sucesso"
        ], 201);
    }
    public function getStudent($id){
       if(Student::where('id', $id)->exists()){
           $student = Student::where('id', $id)->get()->tojson(JSON_PRETTY_PRINT);
           return response($student, 200);
       }else{
           return response()->json([
                "message" => "Aluno não encontrado"
           ], 404);
       }

    }
    public function updateStudent(Request $request, $id){
        if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;
            $student->save();

            return response()->json([
                "message" => "Registros atualizados com sucesso"
            ], 204);
            
        }else{
            return response()->json([
                "message" => "Aluno não encontrado"
            ], 404);
        }
    }
    public function deleteStudent($id){
        if(Student::where('id', $id)->exists()){
            $student = Student::find($id);
            $student->delete();

            return response()->json([
                "message" => "Registro deletado"
            ]);

        }else{
            return response()->json([
                "message" => "not.found"
            ], 404);
        }
    }
}
