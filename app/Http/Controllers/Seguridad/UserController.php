<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Mantenimiento\Persona\Persona;
use App\Permission\Model\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('haveaccess','user.index');
        $users = User::where('estado','ACTIVO')->get();
        return view('seguridad.users.index',compact('users'));
    }

    public function create()
    {
        $this->authorize('haveaccess','user.create');

        $auxs = Persona::where('estado','ACTIVO')->get();

        $colaboradores = array();
        foreach($auxs as $aux)
        {
            if(!$aux->user_persona)
            {
                $colaborador = new stdClass();
                $colaborador->id = $aux->id;
                $colaborador->colaborador = $aux->getApellidosYNombres();
                $colaborador->area = 'SIN ÁREA';
                array_push($colaboradores,$colaborador);
            }
        }
        
        $role_user = [];

        $roles = Role::all();

        return view('seguridad.users.create',compact('roles','colaboradores'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'usuario' => 'required',
            'email' => ['required', Rule::unique('users','email')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'password' => 'required'
        ];
        $message = [
            'usuario.required' => 'El campo usuario es obligatorio.',
            'email.required' => 'El campo email es obligatorio',
            'email.unique' => 'El campo email debe ser único',
            'password.required' => 'El campo contraseña  es obligatorio'

        ];

        Validator::make($data, $rules, $message)->validate();
        $arrayDatos = $request->all();


        if($request->password !== $request->confirm_password)
        {
            //Session::flash('success','Usuario creado.');
            return back()->with([
                'password' => $request->password ,
                'confirm_password' => $request->confirm_password,
                'mpassword' => 'Contraseñas distintas',
                'usuario' => $request->get('usuario'),
                'colaborador_id' => $request->get('colaborador_id'),
                'email' => $request->get('email'),
                'role' => $request->get('role'),
            ]);
        }

        $user = new User($arrayDatos);

        $password = strtoupper($request->password);

        $user->usuario = strtoupper($request->get('usuario'));
        $user->email = strtoupper($request->get('email'));
        $user->colaborador_id = $request->get('colaborador_id');
        $user->password = bcrypt($password);
        $user->contra = $password;

        $user->save();

        if($request->get('role'))
        {
            $user->roles()->sync($request->get('role'));
        }
        else
        {
            $user->roles()->sync([]);
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL USUARIO CON EL NOMBRE: ". $user->usuario;
        $gestion = "CLIENTES";
        crearRegistro($user, $descripcion , $gestion);

        Session::flash('success','Usuario creado.');
        return redirect()->route('seguridad.user.index')->with('guardar', 'success');
    }

    public function show($id)
    {
        $user = User::find($id);

        $this->authorize('view',[$user,['user.show','userown.show']]);

        $auxs = Persona::where('estado','ACTIVO')->get();

        $colaboradores = array();
        foreach($auxs as $aux)
        {
            if(!$aux->user_persona)
            {
                $colaborador = new stdClass();
                $colaborador->id = $aux->id;
                $colaborador->colaborador = $aux->getApellidosYNombres();
                $colaborador->area = 'SIN ÁREA';

                array_push($colaboradores,$colaborador);
            }
            else
            {
                if(!empty($user->colaborador['persona_id']))
                {
                    if($aux->id == $user->colaborador['persona_id'])
                    {
                        $colaborador = new stdClass();
                        $colaborador->id = $aux->id;
                        $colaborador->colaborador = $aux->getApellidosYNombres();
                        $colaborador->area = 'SIN ÁREA';

                        array_push($colaboradores,$colaborador);
                    }
                }
            }
        }

        $role_user = [];

        $roles = Role::all();

        foreach($user->roles as $role)
        {
            $role_user[] = $role->id;
        }

        return view('seguridad.users.show',compact('roles','role_user','user','colaboradores'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('view',[$user,['user.edit','userown.edit']]);

        $auxs = Persona::where('estado','ACTIVO')->get();

        $colaboradores = array();
        foreach($auxs as $aux)
        {
            if(!$aux->user_persona)
            {
                $colaborador = new stdClass();
                $colaborador->id = $aux->id;
                $colaborador->colaborador = $aux->getApellidosYNombres();
                $colaborador->area = 'SIN ÁREA';

                array_push($colaboradores,$colaborador);
            }
            else
            {
                if(!empty($user->colaborador['persona_id']))
                {
                    if($aux->id == $user->colaborador['persona_id'])
                    {
                        $colaborador = new stdClass();
                        $colaborador->id = $aux->id;
                        $colaborador->colaborador = $aux->getApellidosYNombres();
                        $colaborador->area = 'SIN ÁREA';

                        array_push($colaboradores,$colaborador);
                    }
                }
            }
        }
        
        $role_user = [];

        $roles = Role::all();

        foreach($user->roles as $role)
        {
            $role_user[] = $role->id;
        }

        return view('seguridad.users.edit',compact('roles','role_user','user','colaboradores'));
    }

}
