<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\agente;
use App\Models\User;

class AgentesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $agentes = DB::select("SELECT usu.name, age.age_id, age.age_documento
        FROM agentes AS age
        INNER JOIN users AS usu ON usu.id = age.user_id
        WHERE age_estado = 1
        AND usu.estado = 1");

        return view('Agente.principal', compact('agentes'));
    }

}
