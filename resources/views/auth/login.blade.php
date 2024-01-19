<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div class="flex justify-center items-center flex-col gap-1">
        <h1 class="text-2xl font-bold">Silahkan Login</h1>
        <p class="font-semibold text-lg">
            Belum punya akun? <a href="{{route('register')}}" class="text-[#02AF81]">Daftar di sini</a>
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-12">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-Mail')"/>
            <x-text-input id="email" class="block mt-1 w-full"
                          placeholder="Enter your email"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          placeholder="Enter your password"
                          name="password"
                          required autocomplete="current-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <button type="submit"
                    class="focus:outline-none w-full text-white bg-[#02AF81] hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Masuk
            </button>
        </div>

        <div class="flex flex-col items-end justify-end mt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-[#02AF81] font-semibold hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
