@php
    $settings = Utility::settings();
@endphp
<style>
    #printarea {
        background: #ffffff !important;
        color: #0b1c30 !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
        padding: 24px !important;
        font-family: 'Inter', sans-serif !important;
    }
    #printarea *,
    #printarea p,
    #printarea h3,
    #printarea h5,
    #printarea b,
    #printarea div,
    #printarea td,
    #printarea th,
    #printarea span,
    #printarea .text-dark {
        color: #0b1c30 !important;
    }
    #printarea .product-border {
        border-bottom: 1px dotted rgba(11, 28, 48, 0.2) !important;
        padding-bottom: 6px !important;
        margin-bottom: 6px !important;
    }

    @media print {
        /* Hide all non-printable layout wrappers and modal overlays */
        .sg-sidebar,
        .sg-main-content,
        .modal-backdrop,
        #commonModalOver,
        .modal-header,
        .modal-footer,
        #print,
        .toast,
        .alert,
        header,
        footer,
        nav,
        aside {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* Reset HTML and body layouts, margins and backgrounds */
        html, body {
            background: #ffffff !important;
            color: #000000 !important;
            height: auto !important;
            min-height: 0 !important;
            overflow: visible !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Remove fixed positions, overflows, transforms and shadows from parents of the print area */
        #commonModal {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            height: auto !important;
            overflow: visible !important;
            display: block !important;
            opacity: 1 !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
        }

        #commonModal .modal-dialog {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        #commonModal .modal-content {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Position and format the receipt box at the top left */
        #printarea {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            background: #ffffff !important;
            border: none !important;
        }
    }
</style>
<div class="modal-body pos-module" id="printarea" >
    <table class="table pos-module-tbl">
        <tbody>
            <div class="text-center ">
                <h3>{{ $details['user']['name'] }}</h3>
            </div>
            <div class="text-left">
                {!! $details['user']['details'] !!}
            </div>
            <br>

            <div class="text-left">
                <b>#{{ $details['pos_id'] }}</b>
            </div>
          
            <div class="invoice-to mt-2 product-border" >
                {!! isset($details['customer']['name']) ? '' : $details['customer']['details'] !!}
            </div><br>
            <div>
                {!! isset($details['customer']['name']) ? 'Name:  ' . (isset($customer_detail->name) ? $customer_detail->name : '') : '' !!}
            </div>
            <div>
                {!! isset($details['customer']['address']) ? 'Address:  ' . $details['customer']['address'] : '' !!}
            </div>
            <div>
                {!! isset($details['customer']['email']) ? 'Email:  ' . (isset($customer_detail->email) ? $customer_detail->email : '') : '' !!}
            </div>
            <div>
                {!! isset($details['customer']['phone_number']) ? 'Phone:  ' . (isset($customer_detail->phone) ? $customer_detail->phone : '') : '' !!}
            </div>
            <div>
                {!! isset($details['date']) ? 'Date of POS:  ' . $details['date'] : '' !!}
            </div>
            <div class="product-border">
                {!! isset($details['store']['details']) ? 'Store Name:  ' . $details['store']['details'] : '' !!}
            </div>
        </tbody>
    </table>
    <div class=" text-black text-left fs-5 mt-0 mb-0">{{__('Items')}}</div>
        @foreach ($sales['data'] as $key => $value)
            <div class="mt-2">
                <div class="p-0"> <b>{{ $value['product_name'] }}</b></div>
                <div class="d-flex product-border">
                    <div>{{ __('Quantity:') }}</div>
                    <div class="text-end ms-auto">{{ $value['quantity'] }}</div>
                </div>
            </div>
            <div class="d-flex product-border">
                <div>{{__('Price:')}}</div>
                <div class="text-end ms-auto">{{ $value['price'] }}</div>
            </div>
            @php
                $taxes = $value['tax'];
            @endphp
            <div class="d-flex product-border">
                <div>{{__('Tax:')}}</div>
                @if(!empty($value['tax']))
                    <div class="text-end ms-auto">
                        @foreach($taxes as $key => $tax)
                                {{ $tax['tax_name'] }} {{ $tax['tax'] }}%
                        @endforeach
                    </div>
                @else
                <div class="text-end ms-auto">-</div>
                @endif
               
            </div>
            <div class="d-flex product-border mb-2">
                <div>{{__('Tax Amount:')}}</div>
                <div class="text-end ms-auto">{{ $value['tax_amount'] }}</div>
            </div>
            <div class="d-flex product-border mb-2">
                <div>{{__('Sub Total:')}}</div>
                <div class="text-end ms-auto"> {{ $value['subtotal'] }}</div>
            </div>
        @endforeach
        <div class="d-flex product-border mb-2 mt-4">
            <div><b>{{__('Discount:')}}</b></div>
            <div class="text-end ms-auto"> {{ $sales['discount'] }}</div>
        </div>
        <div class="d-flex product-border mb-2">
            <div><b>{{__('Total:')}}</b></div>
            <div class="text-end ms-auto"> {{ $sales['total'] }}</div>
        </div>

        <h5 class="text-center mt-3 font-label">{{__('Thank You For Shopping With Us. Please visit again.')}}</h5>
</div>

    <div class="justify-content-center pt-2 modal-footer">
        <a href="#" id="print"
            class="btn btn-primary btn-sm text-right float-right mb-3 ">
            {{ __('Print') }}
        </a>
    </div>
<script>
    $("#print").click(function () {
        window.print();
    });
</script>
