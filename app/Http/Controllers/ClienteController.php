<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(null), $this->mensagens());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $cliente = new Cliente();
        $cliente->nome = $request->nome;
        $cliente->telefone = $request->telefone;
        $cliente->cpf = $request->cpf;
        $cliente->placa_carro = $request->placa_carro;
        $cliente->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cliente cadastrado com sucesso!'
        ], 200);
       
    }

    public function read($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cliente não encontrado!'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $cliente
        ], 200);
    }

    public function findByFinalPlaca($id)
    {
        $cliente = Cliente::where('placa_carro', '=', $id)->get();
      
        if (count($cliente->toArray()) == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cliente não encontrado!'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $cliente
        ], 200);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), $this->rules($id), $this->mensagens());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cliente não encontrado!'
            ], 404);
        }
        $cliente->nome = $request->nome;
        $cliente->telefone = $request->telefone;
        $cliente->cpf = $request->cpf;
        $cliente->placa_carro = $request->placa_carro;
        $cliente->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cliente atualizado com sucesso!'
        ], 200);
    }

    public function delete($id){
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cliente não encontrado!'
            ], 404);
        }
        $cliente->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cliente excluído com sucesso!'
        ], 200);
    }

    protected function rules($id=null){
        return [
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:255',
            'cpf' => 'required|string|max:255|unique:clientes,cpf,'.$id,
            'placa_carro' => 'required|string|max:255',
        ];
    }

    protected function mensagens(){
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'telefone.required' => 'O campo telefone é obrigatório',
            'cpf.required' => 'O campo cpf é obrigatório',
            'cpf.unique' => 'O cpf informado já está cadastrado',
            'placa_carro.required' => 'O campo placa_carro é obrigatório',
        ];
    }
}
