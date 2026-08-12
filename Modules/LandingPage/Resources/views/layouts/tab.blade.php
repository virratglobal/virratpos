

    <a href="{{ route('landingpage.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'landingpage.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'landingpage.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Top Bar') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('custom_page.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'custom_page.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'custom_page.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Custom Page') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('homesection.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'homesection.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'homesection.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Home') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('features.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'features.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'features.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Features') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('discover.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'discover.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'discover.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Discover') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('screenshots.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'screenshots.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'screenshots.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Screenshots') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('pricing_plan.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'pricing_plan.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'pricing_plan.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Pricing Plan') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('faq.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'faq.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'faq.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('FAQ') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('testimonials.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'testimonials.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'testimonials.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Testimonials') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

    <a href="{{ route('join_us.index') }}" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg mb-1 {{ (Request::route()->getName() == 'join_us.index') ? 'active-tab' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}" {!! (Request::route()->getName() == 'join_us.index') ? 'style="background-color: #e5eeff; color: #4648d4;"' : '' !!}>
        {{ __('Join Us') }} <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </a>

