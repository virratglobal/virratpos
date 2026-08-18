@extends('layouts.ui-auth')

@section('page-title')
    {{__('Login')}}
@endsection

@section('bottom-title')
    {{ __('Welcome back. Manage your business from anywhere.') }}
@endsection

@section('language-bar')
    @php
        $languages = App\Models\Utility::languages();
        $settings = App\Models\Utility::settings();
        if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes'){
            config(
                [
                    'captcha.secret' => $settings['NOCAPTCHA_SECRET'],
                    'captcha.sitekey' => $settings['NOCAPTCHA_SITEKEY'],
                    'options' => [
                        'timeout' => 30,
                    ],
                ]
            );
        }
    @endphp
    
    <div x-data="{ open: false }" class="relative inline-block text-left">
        <button @click="open = !open" @click.away="open = false" type="button"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-surface-container-lowest/80 backdrop-blur border border-outline-variant/30 text-on-surface-variant text-body-sm font-body-sm hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[16px]">language</span>
            {{ ucFirst($languages[$lang]) }}
            <span class="material-symbols-outlined text-[16px]">expand_more</span>
        </button>

        <div x-show="open" style="display: none;"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-surface-container-lowest shadow-lg border border-outline-variant/20" role="menu">
            <div class="py-1" role="none">
                @foreach($languages as $code => $language)
                    <a href="{{ route('login', $code) }}"
                        class="{{ $code == $lang ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container' }} block px-4 py-2 text-body-sm font-body-sm transition-colors"
                        role="menuitem">
                        {{ ucFirst($language) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="w-full">
        <h1 class="font-headline-lg text-headline-lg text-on-surface mb-1">{{ __('Log in to your account') }}</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">{{ __('Welcome back to StoreGo Dashboard') }}</p>
    </div>

    @if(session('status'))
        <div class="w-full rounded-lg bg-error-container/50 border border-error/20 p-3">
            <p class="text-body-sm font-body-sm text-error">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="form_data" class="flex flex-col gap-5 w-full">
        @csrf

        <!-- Email -->
        <div class="flex flex-col gap-1.5 relative group">
            <label for="email" class="font-label-md text-label-md text-on-surface-variant ml-1">{{ __('Email Address') }}</label>
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-outline group-focus-within:text-primary transition-colors duration-200">mail</span>
                <input id="email" name="email" type="email" autocomplete="email" required
                    class="w-full bg-surface py-3 pl-10 pr-4 rounded-lg outline-none text-on-surface font-body-md text-body-md placeholder:text-outline/60 transition-shadow duration-200 focus:shadow-[0_0_0_2px_rgba(70,72,212,0.2)] shadow-[0_0_0_1px_#c7c4d7] @error('email') shadow-[0_0_0_2px_rgba(186,26,26,0.3)] @enderror"
                    placeholder="{{ __('admin@storego.com') }}"
                    value="{{ old('email') }}">
            </div>
            @error('email')
                <p class="text-body-sm font-body-sm text-error ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-1.5 relative group" x-data="{ show: false }">
            <label for="password" class="font-label-md text-label-md text-on-surface-variant ml-1">{{ __('Password') }}</label>
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-outline group-focus-within:text-primary transition-colors duration-200">lock</span>
                <input id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="current-password" required
                    class="w-full bg-surface py-3 pl-10 pr-12 rounded-lg outline-none text-on-surface font-body-md text-body-md placeholder:text-outline/60 transition-shadow duration-200 focus:shadow-[0_0_0_2px_rgba(70,72,212,0.2)] shadow-[0_0_0_1px_#c7c4d7] @error('password') shadow-[0_0_0_2px_rgba(186,26,26,0.3)] @enderror"
                    placeholder="••••••••">
                <button type="button" @click="show = !show"
                    class="absolute right-3 text-outline hover:text-on-surface transition-colors duration-200 flex items-center justify-center">
                    <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                </button>
            </div>
            @error('password')
                <p class="text-body-sm font-body-sm text-error ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer group">
                <div class="relative flex items-center justify-center w-4 h-4 rounded bg-surface shadow-[0_0_0_1px_#c7c4d7] group-hover:shadow-[0_0_0_1px_#4648d4] transition-shadow duration-200">
                    <input class="peer sr-only" type="checkbox" name="remember">
                    <span class="material-symbols-outlined text-[14px] text-on-primary opacity-0 peer-checked:opacity-100 transition-opacity duration-200 absolute pointer-events-none" style="font-variation-settings: 'FILL' 1;">check</span>
                    <div class="absolute inset-0 bg-primary rounded opacity-0 peer-checked:opacity-100 transition-opacity duration-200 pointer-events-none"></div>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface transition-colors duration-200">{{ __('Remember Me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request', $lang) }}"
                    class="font-label-md text-label-md text-primary hover:text-on-primary-fixed-variant transition-colors duration-200">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- reCAPTCHA -->
        @if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes')
            @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2')
                <div>
                    {!! NoCaptcha::display($settings['cust_darklayout']=='on' ? ['data-theme' => 'dark'] : []) !!}
                    @error('g-recaptcha-response')
                        <p class="mt-1 text-body-sm font-body-sm text-error">{{ $message }}</p>
                    @enderror
                </div>
            @else
                <div>
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                    @error('g-recaptcha-response')
                        <p class="mt-1 text-body-sm font-body-sm text-error">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        @endif

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-primary hover:bg-on-primary-fixed-variant text-on-primary font-label-md text-label-md py-3.5 rounded-lg mt-1 flex items-center justify-center gap-2 transition-all duration-200 active:scale-[0.98] shadow-md shadow-primary/20 uppercase tracking-wide">
            <span>{{ __('Sign In') }}</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>

        <div class="relative flex items-center justify-center mt-2">
            <div class="border-t border-outline-variant/30 w-full"></div>
            <span class="absolute bg-surface-container-lowest px-2 text-on-surface-variant font-label-md text-label-md">{{ __('OR') }}</span>
        </div>

        <div class="flex flex-col gap-3 mt-1">
            <a href="{{ route('social.login', 'google') }}" class="w-full flex items-center justify-center gap-3 py-3 rounded-lg border border-outline-variant hover:bg-surface transition-colors duration-200 text-on-surface font-label-md text-label-md">
                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                </svg>
                {{ __('Continue with Google') }}
            </a>
            <a href="{{ route('social.login', 'facebook') }}" class="w-full flex items-center justify-center gap-3 py-3 rounded-lg border border-outline-variant hover:bg-surface transition-colors duration-200 text-on-surface font-label-md text-label-md">
                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" fill="#1877F2"></path>
                </svg>
                {{ __('Continue with Facebook') }}
            </a>
        </div>
    </form>

    @if(Utility::getValByName('signup_button')=='on')
        <div class="mt-6 text-center text-on-surface-variant font-body-sm text-body-sm">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}"
                class="font-label-md text-label-md text-primary hover:text-on-primary-fixed-variant ml-1 transition-colors duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-[1px] after:bg-current after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300 after:origin-left">
                {{ __('Create one') }}
            </a>
        </div>
    @endif
@endsection
