<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // No necesitamos un constructor especial aquí, 
    // ya que la aplicación del middleware se hará en las rutas

    /**
     * Muestra la página de bienvenida
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function welcome(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        
        // Añadir cabeceras para prevenir caché específicamente para esta vista
        $response = response()->view('welcome');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
        
        return $response;
    }

    /**
     * Muestra el formulario de inicio de sesión
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm(Request $request)
    {
        // La redirección si está autenticado ahora la maneja el middleware 'guest' 
        // Verificar si llegamos aquí después de un logout explícito
        $explicitLogout = session('explicit_logout', false);
        
        // Si no es un logout explícito, eliminamos cualquier mensaje de éxito
        // para evitar confusiones
        if (!$explicitLogout) {
            session()->forget('success');
        }
        
        // Limpiamos el indicador para futuras visitas
        session()->forget('explicit_logout');
        
        // Añadir cabeceras para prevenir caché específicamente para esta vista
        $response = response()->view('usuario.login');
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
        
        return $response;
    }

    /**
     * Muestra el formulario de registro
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('usuario.signIn'); 
    }

    /**
     * Registra un nuevo usuario
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

        // Validación
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
     * Inicia sesión de usuario
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
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

        // Regenerar sesión antes de iniciar sesión para prevenir ataques de fijación de sesión
        $request->session()->regenerate();
        
        Auth::login($user);

        return redirect()->route('home');
    }

    /**
     * Cierra la sesión del usuario
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Cerrar sesión de autenticación
        Auth::logout();
        
        // Invalidar la sesión actual
        $request->session()->invalidate();
        
        // Regenerar el token CSRF
        $request->session()->regenerateToken();
        
        // Guardar un indicador específico en la sesión para identificar un logout explícito
        session(['explicit_logout' => true]);
        
        // Redirigir al login con mensaje de confirmación
        return redirect()->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}