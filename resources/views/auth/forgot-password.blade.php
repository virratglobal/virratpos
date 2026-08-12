@extends('layouts.ui-auth')

@section('page-title')
    {{__('Reset Password')}}
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
            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-surface-container-lowest shadow-lg border border-outline-variant/20">
            <div class="py-1">
                @foreach($languages as $code => $language)
                    <a href="{{ route('password.request', $code) }}"
                        class="{{ $code == $lang ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container' }} block px-4 py-2 text-body-sm font-body-sm transition-colors">
                        {{ ucFirst($language) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="w-full">
        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-2">
            <span class="material-symbols-outlined text-primary">lock_reset</span>
        </div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface mb-1">{{ __('Forgot Password?') }}</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">{{ __('Enter your email and we\'ll send you a reset link.') }}</p>
    </div>

    @if(session('status'))
        <div class="w-full rounded-lg bg-surface-container border border-primary/20 p-3 flex items-start gap-3">
            <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
            <p class="text-body-sm font-body-sm text-on-surface">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5 w-full" novalidate>
        @csrf

        <!-- Email -->
        <div class="flex flex-col gap-1.5 relative group">
            <label for="email" class="font-label-md text-label-md text-on-surface-variant ml-1">{{ __('Email Address') }}</label>
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-outline group-focus-within:text-primary transition-colors duration-200">mail</span>
                <input id="email" name="email" type="email" autocomplete="email" required autofocus
                    class="w-full bg-surface py-3 pl-10 pr-4 rounded-lg outline-none text-on-surface font-body-md text-body-md placeholder:text-outline/60 transition-shadow duration-200 focus:shadow-[0_0_0_2px_rgba(70,72,212,0.2)] shadow-[0_0_0_1px_#c7c4d7] @error('email') shadow-[0_0_0_2px_rgba(186,26,26,0.3)] @enderror"
                    placeholder="{{ __('Enter your email') }}"
                    value="{{ old('email') }}">
            </div>
            @error('email')
                <p class="text-body-sm font-body-sm text-error ml-1">{{ $message }}</p>
            @enderror
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

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-primary hover:bg-on-primary-fixed-variant text-on-primary font-label-md text-label-md py-3.5 rounded-lg mt-1 flex items-center justify-center gap-2 transition-all duration-200 active:scale-[0.98] shadow-md shadow-primary/20 uppercase tracking-wide">
            <span>{{ __('Send Reset Link') }}</span>
            <span class="material-symbols-outlined text-[18px]">send</span>
        </button>
    </form>
@endsection

@section('bottom-text')
    {{ __('Back to') }}
    <a href="{{ route('login', $lang) }}"
        class="font-label-md text-label-md text-primary hover:text-on-primary-fixed-variant ml-1 transition-colors duration-200">
        {{ __('Log in') }}
    </a>
@endsection

@push('custom-scripts')
<script src="{{ asset('custom/libs/jquery/dist/jquery.min.js') }}"></script>
    @if (isset($settings['RECAPTCHA_MODULE']) && $settings['RECAPTCHA_MODULE'] == 'yes')
        @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2')
            {!! NoCaptcha::renderJs() !!}
        @else
            <script src="https://www.google.com/recaptcha/api.js?render={{ $settings['NOCAPTCHA_SITEKEY'] }}"></script>
            <script>
                $(document).ready(function() {
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ $settings['NOCAPTCHA_SITEKEY'] }}', {
                            action: 'submit'
                        }).then(function(token) {
                            $('#g-recaptcha-response').val(token);
                        });
                    });
                });
            </script>
        @endif
    @endif
@endpush
