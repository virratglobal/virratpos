{{-- Mobile sidebar backdrop --}}
<div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-on-surface/50 lg:hidden" @click="sidebarOpen = false" style="display:none;"></div>

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed left-0 top-0 bottom-0 z-50 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 sg-sidebar"
    style="background: #ffffff; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,0.04); border: 1px solid rgba(199,196,215,0.1);">

    {{-- Logo Area --}}
    <div style="padding: 24px; display: flex; align-items: center; justify-content: space-between;">
        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 8px; text-decoration: none; max-width: 170px;">
            @php
                $company_logo = \App\Models\Utility::getValByName('company_logo');
            @endphp
            @if(isset($company_logo) && !empty($company_logo) && file_exists(storage_path('uploads/logo/' . $company_logo)))
                @php
                    $logo = \App\Models\Utility::get_file('uploads/logo/');
                @endphp
                <img src="{{ $logo . '/' . $company_logo . '?timestamp='. time() }}" alt="{{ config('app.name') }}" style="max-height: 32px; object-fit: contain;">
            @else
                <div style="width: 32px; height: 32px; background: #000000; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ffffff !importantfff !important; flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 20px;">storefront</span>
                </div>
                <span style="font-family: Geist, sans-serif; font-size: 18px; font-weight: 700; color: #0b1c30 !important; letter-spacing: -0.02em;">
                    {{ config('app.name', 'VirratPOS') }}
                </span>
            @endif
        </a>
        <button @click="sidebarOpen = false" class="ml-auto lg:hidden" style="color: #767586 !important !important;">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    {{-- Navigation --}}
    <div style="flex: 1; overflow-y: auto; padding: 8px 12px; display: flex; flex-direction: column; gap: 4px;">
        
        {{-- Nav Section Label --}}
        <div style="padding: 8px 12px 4px; font-family: Geist, sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; color: rgba(70,69,84,0.6); text-transform: uppercase;">
            {{ __('Main') }}
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('dashboard') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
            onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
            onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
            <span class="material-symbols-outlined" style="font-size: 20px;">grid_view</span>
            <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Dashboard') }}</span>
        </a>

        @if (Auth::user()->type == 'super admin')
            {{-- Super Admin Section --}}
            <div style="padding: 16px 12px 4px; font-family: Geist, sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; color: rgba(70,69,84,0.6); text-transform: uppercase; margin-top: 8px;">
                {{ __('Store Management') }}
            </div>

            <a href="{{ route('store-resource.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('store-resource*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">domain</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Companies') }}</span>
            </a>

            <a href="{{ route('coupons.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('coupons*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">sell</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Coupons') }}</span>
            </a>

            <div style="padding: 16px 12px 4px; font-family: Geist, sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; color: rgba(70,69,84,0.6); text-transform: uppercase; margin-top: 8px;">
                {{ __('Subscriptions') }}
            </div>

            <a href="{{ route('plans.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('plans*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">workspace_premium</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Plans') }}</span>
            </a>

            <a href="{{ route('plan_request.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('plan_request*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">hourglass_empty</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Plan Requests') }}</span>
            </a>

            <a href="{{ route('referral-program.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('referral-program*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">share</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Referral Program') }}</span>
            </a>

            <a href="{{ route('custom_domain_request.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('custom_domain_request*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">public</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Domain Requests') }}</span>
            </a>

            <div style="padding: 16px 12px 4px; font-family: Geist, sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; color: rgba(70,69,84,0.6); text-transform: uppercase; margin-top: 8px;">
                {{ __('System') }}
            </div>

            <a href="{{ route('email_templates.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('email_template*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">mail</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Email Templates') }}</span>
            </a>

            @if(Route::has('landingpage.index'))
            <a href="{{ route('landingpage.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('landingpage*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">web</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Landing Page') }}</span>
            </a>
            @endif

            <a href="{{ route('settings') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('settings*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">settings</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Settings') }}</span>
            </a>

        @else
            {{-- Store Owner Section --}}
            @can('Manage Store Analytics')
            <a href="{{ route('storeanalytic') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('storeanalytic') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">monitoring</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Analytics') }}</span>
            </a>
            @endcan

            @can('Manage Orders')
            <a href="{{ route('orders.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('orders*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">shopping_bag</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Orders') }}</span>
            </a>
            @endcan

            {{-- Product Dropdown --}}
            <div x-data="{ open: {{ in_array(Request::segment(1), ['product', 'product_categorie', 'product_tax', 'subscriptions', 'products']) ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; color: #464554 !important !important; background: none; border: none; cursor: pointer; transition: all 0.2s; {{ in_array(Request::segment(1), ['product', 'product_categorie', 'product_tax', 'subscriptions']) ? 'background: #000000; color: #ffffff !importantfff !important;' : '' }}"
                    onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                    onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                    <span class="material-symbols-outlined" style="font-size: 20px;">inventory_2</span>
                    <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px; flex: 1; text-align: left;">{{ __('Products') }}</span>
                    <span class="material-symbols-outlined" :style="open ? 'transform: rotate(90deg);' : ''" style="font-size: 16px; transition: transform 0.2s;">chevron_right</span>
                </button>
                <div x-show="open" x-collapse style="padding-left: 44px; padding-right: 12px; display: flex; flex-direction: column; gap: 2px; margin-top: 2px;">
                    @can('Manage Products')
                    <a href="{{ route('product.index') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('product*') && !request()->is('product_categorie*') && !request()->is('product_tax*') && !request()->is('product-coupon*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('All Products') }}
                    </a>
                    @endcan
                    @can('Manage Product category')
                    <a href="{{ route('product_categorie.index') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('product_categorie*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('Categories') }}
                    </a>
                    @endcan
                    @can('Manage Product Tax')
                    <a href="{{ route('product_tax.index') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('product_tax*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('Taxes') }}
                    </a>
                    @endcan
                    @can('Manage Subscriber')
                    <a href="{{ route('subscriptions.index') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('subscriptions*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('Subscribers') }}
                    </a>
                    @endcan
                </div>
            </div>

            @can('Manage Product Coupan')
            <a href="{{ route('product-coupon.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('product-coupon*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">sell</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Coupons') }}</span>
            </a>
            @endcan

            @if (isset(\Auth::user()->currentPlan->shipping_method) && \Auth::user()->currentPlan->shipping_method == 'on')
                @can('Manage Shipping')
                <a href="{{ route('shipping.index') }}"
                    style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('shipping*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                    onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                    onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                    <span class="material-symbols-outlined" style="font-size: 20px;">local_shipping</span>
                    <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Shipping') }}</span>
                </a>
                @endcan
            @endif

            {{-- Appearance Dropdown --}}
            <div x-data="{ open: {{ in_array(Request::segment(1), ['themes', 'custom-page', 'blog']) ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; color: #464554 !important !important; background: none; border: none; cursor: pointer; transition: all 0.2s; {{ in_array(Request::segment(1), ['themes', 'custom-page', 'blog']) ? 'background: #000000; color: #ffffff !importantfff !important;' : '' }}"
                    onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                    onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                    <span class="material-symbols-outlined" style="font-size: 20px;">palette</span>
                    <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px; flex: 1; text-align: left;">{{ __('Appearance') }}</span>
                    <span class="material-symbols-outlined" :style="open ? 'transform: rotate(90deg);' : ''" style="font-size: 16px; transition: transform 0.2s;">chevron_right</span>
                </button>
                <div x-show="open" x-collapse style="padding-left: 44px; padding-right: 12px; display: flex; flex-direction: column; gap: 2px; margin-top: 2px;">
                    @can('Manage Themes')
                    <a href="{{ route('themes.theme') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('themes*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('Themes') }}
                    </a>
                    @endcan
                    @if (isset(\Auth::user()->currentPlan->additional_page) && \Auth::user()->currentPlan->additional_page == 'on')
                        @can('Manage Custom Page')
                        <a href="{{ route('custom-page.index') }}"
                            style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('custom-page*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                            onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                            onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                            {{ __('Custom Pages') }}
                        </a>
                        @endcan
                    @endif
                    @if (isset(\Auth::user()->currentPlan->blog) && \Auth::user()->currentPlan->blog == 'on')
                        @can('Manage Blog')
                        <a href="{{ route('blog.index') }}"
                            style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('blog*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                            onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                            onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                            {{ __('Blog') }}
                        </a>
                        @endcan
                    @endif
                </div>
            </div>

            @can('Manage Pos')
            <a href="{{ route('pos.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('pos*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">point_of_sale</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('POS') }}</span>
            </a>
            @endcan

            @can('Manage Customers')
            <a href="{{ route('customer.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('customer*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">group</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Customers') }}</span>
            </a>
            @endcan

            @can('Manage Plans')
            <a href="{{ route('plans.index') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('plans*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">workspace_premium</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Plans') }}</span>
            </a>
            @endcan

            @if (Auth::user()->type == 'Owner')
            <a href="{{ route('referral-program.company') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('referral-program*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">share</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Referral Program') }}</span>
            </a>
            @endif

            {{-- Staff Dropdown --}}
            <div x-data="{ open: {{ Request::segment(1) == 'users' || Request::segment(1) == 'roles' ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; color: #464554 !important !important; background: none; border: none; cursor: pointer; transition: all 0.2s; {{ in_array(Request::segment(1), ['users', 'roles']) ? 'background: #000000; color: #ffffff !importantfff !important;' : '' }}"
                    onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                    onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                    <span class="material-symbols-outlined" style="font-size: 20px;">manage_accounts</span>
                    <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px; flex: 1; text-align: left;">{{ __('Staff') }}</span>
                    <span class="material-symbols-outlined" :style="open ? 'transform: rotate(90deg);' : ''" style="font-size: 16px; transition: transform 0.2s;">chevron_right</span>
                </button>
                <div x-show="open" x-collapse style="padding-left: 44px; padding-right: 12px; display: flex; flex-direction: column; gap: 2px; margin-top: 2px;">
                    @can('Manage Role')
                    <a href="{{ route('roles.index') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('roles*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('Roles') }}
                    </a>
                    @endcan
                    @can('Manage User')
                    <a href="{{ route('users.index') }}"
                        style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0.2s; {{ request()->is('users*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #767586 !important !important;' }}"
                        onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#0b1c30'; this.style.background='#e5e5e5'; }"
                        onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.color='#767586'; this.style.background=''; }">
                        {{ __('Users') }}
                    </a>
                    @endcan
                </div>
            </div>

            @can('Manage Settings')
            <a href="{{ route('settings') }}"
                style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0.2s; {{ request()->is('settings*') ? 'background: #000000; color: #ffffff !importantfff !important; font-weight: 500;' : 'color: #464554 !important !important;' }}"
                onmouseover="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background='#e5e5e5'; this.style.color='#0b1c30'; }"
                onmouseout="if(this.style.background !== 'rgb(0, 0, 0)' && this.style.background !== '#000000') { this.style.background=''; this.style.color='#464554'; }">
                <span class="material-symbols-outlined" style="font-size: 20px;">settings</span>
                <span style="font-family: Inter, sans-serif; font-size: 13px; line-height: 18px;">{{ __('Store Settings') }}</span>
            </a>
            @endcan
        @endif
    </div>

    @if(Auth::user()->type != 'super admin')
    {{-- User Footer --}}
    <div style="padding: 16px; border-top: 1px solid rgba(199,196,215,0.1);">
        <div style="display: flex; align-items: center; gap: 12px; padding: 8px; background: #eff4ff; border-radius: 8px;">
            @php
                $profile = \App\Models\Utility::get_file('uploads/profile');
                $users_sidebar = \Auth::user();
            @endphp
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #000000; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                @if(!empty($users_sidebar->avatar))
                    <img src="{{ $profile . '/' . $users_sidebar->avatar }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span class="material-symbols-outlined" style="color: #ffffff !importantfff !important; font-size: 18px;">person</span>
                @endif
            </div>
            <div style="flex: 1; overflow: hidden;">
                <p style="font-family: Inter, sans-serif; font-size: 13px; font-weight: 500; color: #0b1c30 !important; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0;">{{ $users_sidebar->name }}</p>
                <p style="font-family: Geist, sans-serif; font-size: 12px; color: #464554 !important !important; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin: 0;">
                    {{ isset($users_sidebar->currentPlan->name) ? $users_sidebar->currentPlan->name : __('Store Owner') }}
                </p>
            </div>
        </div>
    </div>
    @endif
</aside>
