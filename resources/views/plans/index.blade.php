@extends('layouts.ui-admin')

@section('page-title', __('Plans'))

@php
    $dir = asset(Storage::url('uploads/plan'));
    $settings = Utility::settings();
@endphp

@section('content')
<x-ui.page-container>
    <div class="flex items-center justify-between mb-8 mt-4">
        <div class="flex flex-col gap-1 relative z-10">
            <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Subscription Plans') }}</h1>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px; max-width: 42rem;">{{ __('Configure and manage available subscription tiers and their features.') }}</p>
        </div>
        @if (Auth::user()->type == 'super admin')
            @can('Create Plans')
                <a href="#" data-url="{{ route('plans.create') }}" data-title="{{ __('Add Plan') }}" data-ajax-popup="true" data-size="lg" class="btn btn-primary" style="display: flex; gap: 8px;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                    {{ __('New Plan') }}
                </a>
            @endcan
        @endif
    </div>

    <!-- Plans Grid -->
    <div class="flex flex-wrap justify-center gap-6 mb-8 relative">
        <div class="absolute -inset-10 blur-3xl -z-10 rounded-full opacity-50 pointer-events-none" style="background: linear-gradient(to bottom right, rgba(211,228,254,0.3), transparent, rgba(225,224,255,0.2));"></div>
        @foreach ($plans as $plan)
            @php
                $isActive = (\Auth::user()->type !== 'super admin' && \Auth::user()->plan == $plan->id);
            @endphp
            <div class="w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] xl:w-[calc(25%-18px)] max-w-sm bg-white rounded-2xl p-6 relative flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-1 {{ $isActive ? 'border-2 border-[#4648d4] shadow-md' : 'border border-gray-200' }}">
                
                @if ($isActive)
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <span class="bg-[#4648d4] text-white px-4 py-1 rounded-full text-xs font-semibold uppercase tracking-wider shadow-sm">
                            {{ __('Current Plan') }}
                        </span>
                    </div>
                @endif

                <div class="flex items-start justify-between mt-2">
                    <div>
                        <h3 style="font-family: 'Geist', sans-serif; font-size: 24px; line-height: 32px; letter-spacing: -0.02em; font-weight: 600; color: #0b1c30; margin: 0;">{{ $plan->name }}</h3>
                        @if ($plan->description)
                            <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">{{ Str::limit($plan->description, 50) }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-end gap-1 mt-4">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30;">{{ isset($admin_payments_setting['currency_symbol']) ? $admin_payments_setting['currency_symbol'] : '$' }}{{ $plan->price }}</span>
                    <span style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-bottom: 8px;">/ {{ __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</span>
                </div>

                <div class="flex flex-col gap-3 flex-1 mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]" style="color: #4648d4;">check_circle</span>
                        <span style="font-family: 'Inter', sans-serif; font-size: 14px; color: #0b1c30;">{{ $plan->max_stores == '-1' ? __('Unlimited') : $plan->max_stores }} {{ __('Stores') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]" style="color: #4648d4;">check_circle</span>
                        <span style="font-family: 'Inter', sans-serif; font-size: 14px; color: #0b1c30;">{{ $plan->max_products == '-1' ? __('Unlimited') : $plan->max_products }} {{ __('Products') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]" style="color: #4648d4;">check_circle</span>
                        <span style="font-family: 'Inter', sans-serif; font-size: 14px; color: #0b1c30;">{{ $plan->max_users == '-1' ? __('Unlimited') : $plan->max_users }} {{ __('Users') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]" style="color: #4648d4;">check_circle</span>
                        <span style="font-family: 'Inter', sans-serif; font-size: 14px; color: #0b1c30;">{{ $plan->storage_limit == '-1' ? __('Unlimited') : $plan->storage_limit }} {{ __('MB Storage') }}</span>
                    </div>
                    @if($plan->enable_custdomain == 'on')
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]" style="color: #4648d4;">check_circle</span>
                        <span style="font-family: 'Inter', sans-serif; font-size: 14px; color: #0b1c30;">{{ __('Custom Domain') }}</span>
                    </div>
                    @endif
                </div>

                <div class="mt-8 flex flex-col gap-2 w-full">
                    @if (\Auth::user()->type == 'super admin')
                        @can('Edit Plans')
                            <a href="#" class="btn w-full justify-center" style="background: #e5eeff; color: #4648d4; border: none; font-weight: 500;" data-url="{{ route('plans.edit',$plan->id) }}" data-title="{{__('Edit Plan')}}" data-ajax-popup="true" data-size="lg">
                                {{ __('Edit Plan') }}
                            </a>
                        @endcan
                    @else
                        @if($isActive)
                            <button class="btn w-full" disabled style="background: #f3f4f6; color: #9ca3af; border: 1px solid #e5e7eb; font-weight: 500;">
                                {{ __('Current Plan') }}
                            </button>
                            @if(\Auth::user()->trial_plan == $plan->id && \Auth::user()->trial_expire_date && date('Y-m-d') < \Auth::user()->trial_expire_date)
                                <div class="text-center text-xs font-medium mt-1" style="color: #904900;">{{ __('Trial Expires: ') }} {{ \Auth::user()->dateFormat(\Auth::user()->trial_expire_date) }}</div>
                            @elseif (date('Y-m-d') < \Auth::user()->plan_expire_date && \Auth::user()->is_trial_done != 1)
                                <div class="text-center text-xs font-medium mt-1" style="color: #767586;">{{ __('Renews: ') }} {{ \App\Models\Utility::dateFormat(\Auth::user()->plan_expire_date) }}</div>
                            @elseif(!empty(\Auth::user()->plan_expire_date) && \Auth::user()->plan_expire_date < date('Y-m-d'))
                                <div class="text-center text-xs font-medium mt-1" style="color: #ba1a1a;">{{ __('Expired') }}</div>
                            @endif
                        @else
                            @if($plan->price <= 0)
                                <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}" class="w-full">
                                    <button class="btn btn-primary w-full" style="background: #4648d4; border: none;">{{ __('Select Plan') }}</button>
                                </a>
                            @else
                                <div class="flex space-x-2">
                                    @if (\Auth::user()->trial_plan == 0 && $plan->trial != 'off' && $plan->trial_days != 0)
                                        <a href="{{ route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}" class="flex-1">
                                            <button class="btn w-full" style="background: #e5eeff; color: #4648d4; border: none;">{{ __('Free Trial') }}</button>
                                        </a>
                                    @endif
                                    <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}" class="flex-1">
                                        <button class="btn btn-primary w-full" style="background: #4648d4; border: none;">{{ __('Subscribe') }}</button>
                                    </a>
                                </div>
                            @endif
                            @if ($plan->id != 1)
                                <div class="mt-2">
                                    @if (\Auth::user()->requested_plan != $plan->id)
                                        <a href="{{ route('send.request',[\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}" data-title="{{ __('Send Request') }}">
                                            <button class="btn w-full" style="background: white; border: 1px solid #dce9ff; color: #4648d4;">{{ __('Request Plan') }}</button>
                                        </a>
                                    @else
                                        <a href="{{ route('request.cancel',\Auth::user()->id) }}" data-title="{{ __('Cancel Request') }}">
                                            <button class="btn btn-danger w-full">{{ __('Cancel Request') }}</button>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Contact Sales Section -->
    <div class="flex flex-col items-center justify-center text-center p-8 bg-white border border-gray-200 rounded-2xl mb-8 mt-2 shadow-sm relative overflow-hidden">
        <div class="absolute -inset-10 blur-3xl -z-10 rounded-full opacity-20 pointer-events-none" style="background: linear-gradient(to right, #4648d4, transparent);"></div>
        <h3 style="font-family: 'Geist', sans-serif; font-size: 20px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Need more flexibility?') }}</h3>
        <p style="font-family: 'Inter', sans-serif; font-size: 15px; color: #767586; margin-top: 8px; max-width: 500px;">
            {{ __('Contact us for custom limits, enterprise features, and tailored plans to perfectly fit your business needs.') }}
        </p>
        <a href="#" class="mt-6 btn btn-primary" style="background: #4648d4; border: none; padding: 10px 24px; font-weight: 500; font-family: 'Inter', sans-serif;">
            {{ __('Contact Sales') }}
        </a>
    </div>

    <!-- Orders Table -->
    <x-ui.card class="overflow-hidden">
        <div class="p-6 border-b" style="border-color: #dce9ff;">
            <h3 style="font-family: 'Geist', sans-serif; font-size: 24px; line-height: 32px; letter-spacing: -0.02em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Order History') }}</h3>
            <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">{{ __('Recent subscription transactions and upgrades.') }}</p>
        </div>
        <x-ui.table>
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Order Id') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Date') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Plan') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Price') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Payment Type') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Invoice') }}</th>
                    @if(\Auth::user()->type == 'super admin')
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y" style="border-color: #dce9ff;">
                @foreach ($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->plan_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ isset($admin_payments_setting['currency_symbol']) ? $admin_payments_setting['currency_symbol'] . $order->price : '$' . $order->price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->payment_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($order->payment_status == 'succeeded')
                                <span style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 500; text-transform: uppercase;">{{ ucfirst($order->payment_status) }}</span>
                            @else
                                <span style="background: rgba(186, 26, 26, 0.1); color: #ba1a1a; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 500; text-transform: uppercase;">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if ($order->receipt != 'free coupon' && $order->payment_type == 'STRIPE')
                                <a href="{{ $order->receipt }}" title="Invoice" target="_blank" class="text-primary-600 hover:text-primary-900"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a>
                            @elseif ($order->payment_type == 'Bank Transfer')
                                <a href="{{ \App\Models\Utility::get_file($order->receipt) }}" title="Invoice" target="_blank" download class="text-primary-600 hover:text-primary-900"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a>
                            @elseif($order->receipt == 'free coupon')
                                <span class="text-xs text-gray-500">{{ __('100% discount') }}</span>
                            @elseif($order->payment_type == 'Manually')
                                <span class="text-xs text-gray-500">{{ __('Manual Upgrade') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        @if(\Auth::user()->type == 'super admin')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="#" class="text-red-600 hover:text-red-900 bs-pass-para p-1.5 rounded hover:bg-gray-100 transition-colors" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone.') }}" data-confirm-yes="delete-form-{{ $order->id }}" title="Delete">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['planorder.destroy', $order->id], 'id' => 'delete-form-' . $order->id, 'class' => 'hidden']) !!}
                                    {!! Form::close() !!}
                                    
                                    @if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer')
                                        <a href="#" class="text-gray-600 hover:text-gray-900 p-1.5 rounded hover:bg-gray-100 transition-colors" data-url="{{ route('bank_transfer.show',$order->id) }}" data-ajax-popup="true" data-size="lg" title="{{ __('Payment Status') }}">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </a>
                                    @endif

                                    @php $user = \App\Models\User::find($order->user_id); @endphp
                                    @if($user)
                                        @foreach($userOrders as $userOrder)
                                            @if ($user->plan == $order->plan_id && $order->order_id == $userOrder->order_id && $order->is_refund == 0 && $user->plan != 1)
                                                <a href="{{ route('order.refund' , [$order->id , $order->user_id])}}" class="text-orange-600 hover:text-orange-900 ml-2" title="{{ __('Refund') }}">
                                                    {{ __('Refund') }}
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>
    </x-ui.card>
</x-ui.page-container>
@endsection

@push('scripts')
    <script>
        $(document).on("change", ".is_active", function() {
            var id = $(this).attr('data-id');
            var is_active = ($(this).is(':checked')) ? $(this).val() : 0;
            $.ajax({
                url: '{{ route('plan.enable') }}',
                type: 'POST',
                data: {
                    "is_active": is_active,
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.success) {
                        show_toastr('Success', data.success, 'success');
                    } else {
                        show_toastr('Error', data.error, 'error');
                    }
                }
            });
        });
    </script>
@endpush
