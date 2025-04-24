<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Summary of showLoginForm
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        if (Auth::check()) {

        return redirect()->route('home');
        }
        return view('usuario.login');
    }


    /**
     * Summary of showRegisterForm
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegisterForm()
    {
        return view('usuario.signIn'); 
    }

    /**
     * Summary of register
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede tener más de :max caracteres.',
            'name.regex' => 'El nombre debe comenzar con letras y solo puede contener números después.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'email.regex' => 'El correo electrónico debe terminar en .com o .es',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'telefono.max' => 'El teléfono no puede tener más de :max caracteres.',
            'telefono.regex' => 'El teléfono solo puede contener números.'
        ];

        //Validación
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zñáéíóúA-ZÑÁÉÍÓÚ]+[a-zñáéíóúA-ZÑÁÉÍÓÚ\s]*[0-9]*$/'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|es)$/'
            ],
            'password' => 'required|min:6|confirmed',
            'telefono' => [
                            'nullable',
                            'max:20',
                            'regex:/^[0-9]+$/'
                        ]
        ];

        try {
            $validated = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)
                        ->withInput();
        }

        $user = User::create([
            'nombre' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'telefono' => $validated['telefono'] ?? null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }

    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
    }

    Auth::login($user);

    return redirect()->route('home');
    }
    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
    Auth::logout();
    return redirect()->route('login');
    }

    /**
     * Summary of welcome
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function welcome()
    {
        if (Auth::check()) {
            return redirect()->route('home');
    }
        return view('welcome');
        }

}
