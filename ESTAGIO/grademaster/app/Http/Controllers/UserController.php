<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function buscarUsuario($email_usuario){
        $email_usuario = User::where('email', $email_usuario)->get();
        return response()->json($email_usuario);
    }

    public function criarUsuario(Request $request){
        $usuario = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'password_confirmation' => Hash::make($request->password_confirmation)
    ]);

    return response()->json([
        'mensagem' => 'Usuário criado com sucesso!',
        'usuario' => $usuario
    ], 201);

    }

    public function listarUsuarios()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    

public function deletarUsuario($id)
{
    $usuario = User::find($id);

    if (!$usuario) {
        return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
    }

    $usuario->delete();

    return response()->json(['mensagem' => 'Usuário excluído com sucesso']);
}
}