<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - El Maíz Dorado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 flex items-center justify-center min-h-screen">

    <div class="bg-white bg-opacity-90 shadow-lg rounded-2xl p-8 w-full max-w-md border-4 border-yellow-600">
    
        <div class="text-center mb-6">
            <img src="{{ asset('img/logo_maiz.png') }}" alt="Maíz Logo" class="w-20 mx-auto">
            <h2 class="text-3xl font-bold text-yellow-700 mt-2">El Maíz Dorado</h2>
            <p class="text-gray-600">Bienvenido, ingresa tus credenciales</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 p-3 w-full border border-yellow-400 rounded-lg focus:ring focus:ring-yellow-300 focus:border-yellow-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 p-3 w-full border border-yellow-400 rounded-lg focus:ring focus:ring-yellow-300 focus:border-yellow-500">
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="text-yellow-500">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-yellow-600 hover:underline">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit"
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 shadow-md">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-yellow-600 font-bold hover:underline">Regístrate</a></p>
    </div>

</body>
</html>
