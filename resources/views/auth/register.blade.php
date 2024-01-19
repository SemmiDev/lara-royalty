<x-guest-layout>

    <div class="flex justify-center items-center flex-col gap-1">
        <h1 class="text-2xl font-bold">Silahkan Daftar</h1>
        <p class="font-semibold text-lg">
            Sudah punya akun? <a href="{{route('login')}}" class="text-[#02AF81]">Login di sini</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-12">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name"
                          placeholder="Enter your name"
                          class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus
                          autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('E-Mail')"/>
            <x-text-input id="email"
                          placeholder="Enter your email"
                          class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          placeholder="Enter your password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          placeholder="Enter your password confirmation"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <button type="submit"
                    class="focus:outline-none w-full text-white bg-[#02AF81] hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Daftar
            </button>
        </div>
    </form>
</x-guest-layout>
