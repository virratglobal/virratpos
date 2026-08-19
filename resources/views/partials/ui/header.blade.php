@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguages();
    $languages = \App\Models\Utility::languages();
    $profile = \App\Models\Utility::get_file('uploads/profile');
    
    $checktableExist = Utility::checktableExist();
    if ($checktableExist) {
        $LangName = \App\Models\Languages::where('code', $currantLang)->value('fullName') ?? 'english';
    } else {
        $LangName = 'english';
    }
    $current_store = \Auth::user()->activeStore;
@endphp

{{-- Header: fixed, floating, matching Stitch design --}}
<header class="fixed z-40 flex items-center justify-between px-4 lg:px-6 sg-header transition-all duration-300 ease-in-out" style="
    height: 64px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    border: 1px solid rgba(199,196,215,0.1);
">
    {{-- Left: Mobile menu button + Search --}}
    <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
        {{-- Menu toggle button --}}
        <button @click="sidebarOpen = !sidebarOpen; if(!sidebarOpen) document.body.classList.add('sidebar-closed-manual'); else document.body.classList.remove('sidebar-closed-manual');"
            style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; color: #464554; background: none; border: none; cursor: pointer; transition: background 0.2s;"
            onmouseover="this.style.background='#dce9ff';" onmouseout="this.style.background='';">
            <span class="material-symbols-outlined">menu</span>
        </button>

        {{-- Search Bar --}}
        <button style="
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: #F8FAFC;
            border-radius: 8px;
            color: #0F172A;
            font-family: Inter, sans-serif;
            font-size: 14px;
            line-height: 20px;
            width: 320px;
            border: 1px solid #E2E8F0;
            cursor: pointer;
            transition: all 0.2s;
        "
        onmouseover="this.style.borderColor='#4648d4';" onmouseout="this.style.borderColor='#E2E8F0';">
            <span class="material-symbols-outlined" style="font-size: 18px; color: #64748B;">search</span>
            <span style="color: #64748B;">{{ __('Search or press ⌘K') }}</span>
        </button>
    </div>

    {{-- Right: Actions --}}
    <div style="display: flex; align-items: center; gap: 8px;">

        {{-- Exit Owner Login --}}
        @impersonating($guard = null)
            <a href="{{ route('exit.owner') }}"
                style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #dc2626; color: #ffffff; border-radius: 8px; font-family: Inter, sans-serif; font-size: 12px; font-weight: 500; text-decoration: none; transition: opacity 0.2s;"
                onmouseover="this.style.opacity='0.85';" onmouseout="this.style.opacity='1';">
                <span class="material-symbols-outlined" style="font-size: 16px;">logout</span>
                {{ __('Exit Owner Login') }}
            </a>
        @endImpersonating

        {{-- Create New Store --}}
        @auth('web')
            @if (Auth::user()->type !== 'super admin')
                @can('Create Store')
                    <a href="#" class="cust-btn"
                        data-size="lg"
                        data-url="{{ route('store-resource.create') }}"
                        data-ajax-popup="true"
                        data-title="{{ __('Create New Store') }}"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: #4648d4; color: #FFFFFF; border-radius: 8px; font-family: Inter, sans-serif; font-size: 12px; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: background 0.2s;"
                        onmouseover="this.style.background='#3a3cb5';" onmouseout="this.style.background='#4648d4';">
                        <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                        <span class="hidden sm:inline">{{ __('New Store') }}</span>
                    </a>
                @endcan
            @endif
        @endauth

        {{-- My Store Switcher --}}
        @if (Auth::user()->type !== 'super admin' && $current_store)
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false" type="button"
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; background: #e5eeff; border-radius: 8px; font-family: Inter, sans-serif; font-size: 13px; color: #0F172A; border: 1px solid #E2E8F0; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='#dce9ff';" onmouseout="this.style.background='#e5eeff';">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #4648d4;">storefront</span>
                    <span class="hidden sm:block">{{ ucfirst($current_store->name) }}</span>
                    <span class="material-symbols-outlined" style="font-size: 16px; color: #64748B;">expand_more</span>
                </button>
                <div x-show="open" style="display: none;"
                    class="absolute right-0 z-50 mt-2 w-56 origin-top-right"
                    style="background: #ffffff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); border: 1px solid #E2E8F0;">
                    <div style="padding: 6px;">
                        @php $userStores = \Auth::user()->currentuser()->stores; @endphp
                        @foreach ($userStores as $store)
                            @if ($store->is_store_enabled == 1)
                                <a href="{{ Auth::user()->current_store == $store->id ? '#' : route('change_store', $store->id) }}"
                                    style="display: flex; align-items: center; padding: 8px 12px; border-radius: 8px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: background 0.2s; {{ Auth::user()->current_store == $store->id ? 'background: #e5eeff; color: #4648d4;' : 'color: #475569;' }}"
                                    onmouseover="if(!this.style.background.includes('#e5eeff')) { this.style.background='#F8FAFC'; }"
                                    onmouseout="if(!this.style.background.includes('#e5eeff')) { this.style.background=''; }">
                                    @if (Auth::user()->current_store == $store->id)
                                        <span class="material-symbols-outlined" style="font-size: 16px; margin-right: 8px; color: {{ $primaryColor }};" >check</span>
                                    @else
                                        <span style="width: 16px; margin-right: 8px;"></span>
                                    @endif
                                    {{ $store->name }}
                                </a>
                            @else
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; font-family: Inter, sans-serif; font-size: 13px; color: #94A3B8; cursor: not-allowed;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">lock</span>
                                        {{ $store->name }}
                                    </div>
                                    @if (isset($store->pivot->permission))
                                        <span style="background: #e5eeff; color: {{ $primaryColor }}; padding: 2px 8px; border-radius: 999px; font-size: 11px;">{{ $store->pivot->permission == 'Owner' ? __($store->pivot->permission) : __('Shared') }}</span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Full Screen Button --}}
        <button type="button" x-data="{ isFullScreen: false }"
            @click="
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().then(() => isFullScreen = true).catch(err => console.error(err));
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen().then(() => isFullScreen = false);
                    }
                }
            "
            @fullscreenchange.window="isFullScreen = !!document.fullscreenElement"
            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #464554; background: none; border: none; cursor: pointer; transition: background 0.2s;"
            onmouseover="this.style.background='#dce9ff';" onmouseout="this.style.background='';"
            title="{{ __('Toggle Fullscreen') }}">
            <span class="material-symbols-outlined" x-text="isFullScreen ? 'fullscreen_exit' : 'fullscreen'">fullscreen</span>
        </button>

        {{-- Theme Button --}}
        <button id="theme-toggle-btn" type="button"
            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #475569; background: none; border: none; cursor: pointer; transition: all 0.2s;"
            title="{{ isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? __('Switch to light mode') : __('Switch to dark mode') }}">
            <span class="material-symbols-outlined" id="theme-toggle-icon">
                {{ isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'light_mode' : 'dark_mode' }}
            </span>
        </button>

        {{-- Language Button --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false" type="button"
                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #475569; background: none; border: none; cursor: pointer; transition: background 0.2s;"
                onmouseover="this.style.background='#e5eeff'; this.style.color='#4648d4';" onmouseout="this.style.background=''; this.style.color='#475569';"
                title="{{ ucFirst($LangName) }}">
                <span class="material-symbols-outlined">language</span>
            </button>
            <div x-show="open" style="display: none; position: absolute; right: 0; z-index: 50; margin-top: 8px; width: 224px; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); border: 1px solid #E2E8F0; padding: 6px;">
                @foreach ($languages as $code => $lang)
                    <a href="{{ route('change.language', $code) }}"
                        style="display: block; padding: 8px 12px; border-radius: 8px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: background 0.2s; {{ $currantLang == $code ? 'background: #e5eeff; color: #4648d4; font-weight: 500;' : 'color: #475569;' }}"
                        onmouseover="if(!this.style.background.includes('#e5eeff')) { this.style.background='#F8FAFC'; }"
                        onmouseout="if(!this.style.background.includes('#e5eeff')) { this.style.background=''; }">
                        {{ ucFirst($lang) }}
                    </a>
                @endforeach
                @if (Auth::user()->type == 'super admin')
                    <div style="height: 1px; background: #E2E8F0; margin: 4px 0;"></div>
                    @can('Create Language')
                        <a href="#" data-url="{{ route('create.language') }}" data-size="md" data-ajax-popup="true" data-title="{{ __('Create New Language') }}" class="cust-btn"
                            style="display: block; padding: 8px 12px; border-radius: 8px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; color: #4648d4; transition: background 0.2s;"
                            onmouseover="this.style.background='#e5eeff';" onmouseout="this.style.background='';">
                            {{ __('Create Language') }}
                        </a>
                    @endcan
                    @can('Manage Language')
                        <a href="{{ route('manage.language', [$currantLang]) }}"
                            style="display: block; padding: 8px 12px; border-radius: 8px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; color: #4648d4; transition: background 0.2s;"
                            onmouseover="this.style.background='#e5eeff';" onmouseout="this.style.background='';">
                            {{ __('Manage Languages') }}
                        </a>
                    @endcan
                @endif
            </div>
        </div>

        {{-- Notifications --}}
        <button style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #475569; background: none; border: none; cursor: pointer; transition: background 0.2s;"
            onmouseover="this.style.background='#e5eeff'; this.style.color='#4648d4';" onmouseout="this.style.background=''; this.style.color='#475569';">
            <span class="material-symbols-outlined">notifications</span>
        </button>

        {{-- Divider --}}
        <div style="width: 1px; height: 24px; background: #E2E8F0; margin: 0 4px;"></div>

        {{-- User Profile --}}
        <style>
            .sg-profile-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 16px;
                border-radius: 8px;
                font-family: Inter, sans-serif;
                font-size: 13px;
                font-weight: 500;
                text-decoration: none !important;
                color: #475569 !important;
                transition: all 0.2s;
            }
            .sg-profile-link:hover {
                background: {{ $primaryColor }} !important;
                color: #ffffff !important;
            }
            .sg-profile-logout {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 16px;
                border-radius: 8px;
                font-family: Inter, sans-serif;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none !important;
                color: #dc2626 !important;
                transition: all 0.2s;
            }
            .sg-profile-logout:hover {
                background: #fef2f2 !important;
                color: #dc2626 !important;
            }
        </style>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false" type="button"
                style="width: 36px; height: 36px; border-radius: 50%; padding: 0; background: transparent; display: flex; align-items: center; justify-content: center; border: 2px solid transparent; cursor: pointer; overflow: hidden; transition: all 0.2s;"
                onmouseover="this.style.borderColor='#e5eeff';" onmouseout="this.style.borderColor='transparent';">
                @if(!empty($users->avatar))
                    <img src="{{ $profile . '/' . $users->avatar }}" alt="" style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%;">
                @else
                    <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="Placeholder" style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%;">
                @endif
            </button>
            <div x-show="open" style="display: none; position: absolute; right: 0; z-index: 50; margin-top: 12px; width: 280px; background: #ffffff; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid rgba(199,196,215,0.2); overflow: hidden;">
                
                {{-- Profile Context --}}
                <div style="padding: 20px; background: #f8f9ff; border-bottom: 1px solid rgba(199,196,215,0.2); display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; background: #e5eeff; flex-shrink: 0;">
                        @if(!empty($users->avatar))
                            <img src="{{ $profile . '/' . $users->avatar }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="Placeholder" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div style="overflow: hidden;">
                        <h4 style="font-family: Geist, sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0 0 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $users->name }}</h4>
                        <p style="font-family: Inter, sans-serif; font-size: 13px; color: #767586; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $users->email }}</p>
                    </div>
                </div>

                {{-- Quick Actions Hub --}}
                <div style="padding: 8px;">
                    <a href="{{ route('profile') }}" class="sg-profile-link">
                        <span class="material-symbols-outlined" style="font-size: 18px;">account_circle</span>
                        {{ __('My Profile') }}
                    </a>
                    <a href="{{ route('settings') }}" class="sg-profile-link">
                        <span class="material-symbols-outlined" style="font-size: 18px;">settings</span>
                        {{ __('Account Settings') }}
                    </a>
                </div>

                {{-- Clear Exit Intent --}}
                <div style="padding: 8px; border-top: 1px solid rgba(199,196,215,0.2); background: #fafafa;">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('frm-logout').submit();" class="sg-profile-logout">
                        <span class="material-symbols-outlined" style="font-size: 18px;">logout</span>
                        {{ __('Logout') }}
                    </a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            </div>
        </div>

    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var themeBtn = document.getElementById('theme-toggle-btn');
        var themeIcon = document.getElementById('theme-toggle-icon');

        function applyTheme(isDark) {
            if (isDark) {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
                if (themeIcon) {
                    themeIcon.textContent = 'light_mode';
                }
                if (themeBtn) {
                    themeBtn.setAttribute('title', '{{ __("Switch to light mode") }}');
                }
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
                if (themeIcon) {
                    themeIcon.textContent = 'dark_mode';
                }
                if (themeBtn) {
                    themeBtn.setAttribute('title', '{{ __("Switch to dark mode") }}');
                }
            }
        }

        // Initialize state
        var isCurrentlyDark = document.documentElement.classList.contains('dark') || document.body.classList.contains('dark');
        applyTheme(isCurrentlyDark);

        if (themeBtn) {
            themeBtn.addEventListener('click', function () {
                var nextIsDark = !(document.documentElement.classList.contains('dark') || document.body.classList.contains('dark'));
                localStorage.setItem('virratpos_theme', nextIsDark ? 'dark' : 'light');
                applyTheme(nextIsDark);

                fetch('{{ route('toggle.theme') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .catch(err => console.error(err));
            });
        }
    });
</script>
