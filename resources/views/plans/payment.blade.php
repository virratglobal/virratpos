@extends('layouts.ui-admin')

@section('page-title', __('Payment'))

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Payment Selection') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <a href="{{ route('plans.index') }}" class="hover:text-gray-900">{{ __('Plans') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Payment') }}</span>
        </x-slot>
    </x-ui.page-header>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl border border-gray-150 p-8 shadow-sm">
            <form role="form" action="{{ route('prepare.payment') }}" method="post" class="require-validation space-y-6" id="payment-form">
                @csrf
                <input type="hidden" name="code" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 mb-2 block">{{ __('Payment Processor') }}</label>
                        <div class="flex flex-col space-y-2">
                            <label class="inline-flex items-center p-3 bg-gray-50 hover:bg-gray-100 border border-gray-150 rounded-lg cursor-pointer transition-colors">
                                <input type="radio" name="payment_processor" value="paypal" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked>
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ __('PayPal') }}</span>
                            </label>
                            <label class="inline-flex items-center p-3 bg-gray-50 hover:bg-gray-100 border border-gray-150 rounded-lg cursor-pointer transition-colors">
                                <input type="radio" name="payment_processor" value="stripe" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ __('Stripe') }}</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 mb-2 block">{{ __('Payment Type') }}</label>
                        <div class="flex flex-col space-y-2">
                            <label class="inline-flex items-center p-3 bg-gray-50 hover:bg-gray-100 border border-gray-150 rounded-lg cursor-pointer transition-colors">
                                <input type="radio" name="payment_type" id="one_time_type" value="one-time" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked>
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ __('One Time') }}</span>
                            </label>
                            <label class="inline-flex items-center p-3 bg-gray-50 hover:bg-gray-100 border border-gray-150 rounded-lg cursor-pointer transition-colors">
                                <input type="radio" name="payment_type" id="recurring_type" value="recurring" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <span class="ml-3 text-sm font-medium text-gray-900">{{ __('Recurring') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <label for="coupon" class="text-xs font-semibold text-gray-500 mb-1.5 block">{{ __('Coupon Code') }}</label>
                    <div class="flex space-x-3">
                        <input type="text" id="coupon" name="coupon" class="form-control pc-input flex-1" placeholder="{{ __('Enter Coupon Code Here') }}">
                        <button type="button" class="apply-coupon px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-200 border border-gray-150 transition-colors">
                            {{ __('Apply') }}
                        </button>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 block">{{ __('Total Price') }}</span>
                        <span class="text-2xl font-bold text-indigo-600 mt-1 block final-price"></span>
                    </div>
                    <x-ui.button variant="primary" type="submit" class="px-6 py-3">
                        <span class="material-symbols-outlined text-[18px]">shopping_cart_checkout</span>
                        {{ __('Checkout') }}
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
</x-ui.page-container>
@endsection

@push('scripts')
    <?php $stripe_session = Session::get('stripe_session');?>
    <?php if(isset($stripe_session) && $stripe_session): ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        stripe.redirectToCheckout({
            sessionId: '{{ $stripe_session->id }}',
        }).then((result) => {
        });
    </script>
    <?php endif ?>

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        $(document).on('change', 'input[name="payment_frequency"], input[name="payment_type"]', function (e) {
            var price = $('input[name="payment_frequency"]:checked').attr('data-price');
            var frequency = $('input[name="payment_frequency"]:checked').val();
            var type = $('input[name="payment_type"]:checked').val();

            var total = per = '';

            if (frequency == 'monthly') {
                var per = '/month';
                $('#recurring_type').parent().show();
            } else if (frequency == 'annual') {
                var per = '/year';
                $('#recurring_type').parent().show();
            }

            if (type == 'recurring') {
                var total = price + per;
            } else if (type == 'one-time') {
                var total = price;
            }
            $('.final-price').text(total);
        });

        $('input[name="payment_frequency"]:first').trigger('change');

        // Apply Coupon
        $(document).on('click', '.apply-coupon', function (e) {
            e.preventDefault();

            var ele = $(this);
            var coupon = ele.closest('.row').find('.coupon').val();

            if (coupon != '') {
                $.ajax({
                    url: '{{route('apply.coupon')}}',
                    datType: 'json',
                    data: {
                        plan_id: '{{ $plan->id }}',
                        coupon: coupon
                    },
                    success: function (data) {
                        $('#stripe_coupon, #paypal_coupon').val(coupon);
                        if (data.is_success) {
                            $('.coupon-tr').show().find('.coupon-price').text(data.discount_price);
                            $('.final-price').text(data.final_price);
                            show_toastr('Success', data.message, 'success');
                        } else {
                            $('.coupon-tr').hide().find('.coupon-price').text('');
                            $('.final-price').text(data.final_price);
                            show_toastr('Error', data.message, 'error');
                        }
                    }
                })
            } else {
                show_toastr('Error', '{{__('Invalid Coupon Code.')}}', 'error');
            }
        });
    </script>
@endpush
