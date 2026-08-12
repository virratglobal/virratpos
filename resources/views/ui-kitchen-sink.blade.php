@extends('layouts.ui-admin')

@section('page-title', 'UI Kitchen Sink')

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="UI Kitchen Sink">
        <x-slot name="actions">
            <x-ui.button variant="primary">Create New Component</x-ui.button>
        </x-slot>
    </x-ui.page-header>

    <div class="space-y-12">
        
        <!-- Metrics (Stat Cards) placeholder for visual density -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-ui.card>
                <p class="text-sm font-medium text-gray-500 truncate">Total Sales</p>
                <p class="mt-1 text-2xl font-semibold text-gray-900">₹0</p>
                <div class="mt-4"><a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">View more &rarr;</a></div>
            </x-ui.card>
            <x-ui.card>
                <p class="text-sm font-medium text-gray-500 truncate">Store Conversion Rate</p>
                <p class="mt-1 text-2xl font-semibold text-gray-900">0%</p>
                <div class="mt-4"><a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">View more &rarr;</a></div>
            </x-ui.card>
        </div>

        <div>
            <h2 class="text-lg font-medium text-gray-900 mb-4">Typography & Buttons</h2>
            <div class="flex space-x-4 p-6 bg-white shadow-card rounded-lg border border-gray-200">
                <x-ui.button variant="primary">Primary Action</x-ui.button>
                <x-ui.button variant="secondary">Secondary Action</x-ui.button>
                <x-ui.button variant="danger">Danger Action</x-ui.button>
                <x-ui.button variant="ghost">Ghost Action</x-ui.button>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-medium text-gray-900 mb-4">Badges</h2>
            <div class="flex space-x-4 p-6 bg-white shadow-card rounded-lg border border-gray-200">
                <x-ui.badge variant="success">Active</x-ui.badge>
                <x-ui.badge variant="warning">Pending</x-ui.badge>
                <x-ui.badge variant="danger">Failed</x-ui.badge>
                <x-ui.badge variant="info">New</x-ui.badge>
                <x-ui.badge variant="gray">Draft</x-ui.badge>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Forms</h2>
                <x-ui.card>
                    <div class="space-y-4">
                        <div>
                            <x-ui.label>Email Address</x-ui.label>
                            <x-ui.input type="email" placeholder="you@example.com" />
                        </div>
                        <div>
                            <x-ui.label>Disabled Input</x-ui.label>
                            <x-ui.input type="text" disabled value="Cannot edit this" />
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Empty State</h2>
                <x-ui.card>
                    <x-ui.empty-state 
                        title="No orders found" 
                        description="Get started by creating a new order."
                    >
                        <x-slot name="action">
                            <x-ui.button variant="primary">Create manual order</x-ui.button>
                        </x-slot>
                    </x-ui.empty-state>
                </x-ui.card>
            </div>
        </div>

    </div>
</x-ui.page-container>
@endsection
