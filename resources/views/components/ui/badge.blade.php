@props([
    'variant' => 'info',
])

@php
    $variantStyles = [
        'info' => 'background: #e5eeff; color: #4648d4;',
        'primary' => 'background: #e5eeff; color: #4648d4;',
        'success' => 'background: #e8f5e9; color: #1a7431;',
        'warning' => 'background: #fff3e0; color: #904900;',
        'danger' => 'background: #ffdad6; color: #ba1a1a;',
        'error' => 'background: #ffdad6; color: #ba1a1a;',
        'gray' => 'background: #eff4ff; color: #464554;',
        'secondary' => 'background: #dae2fd; color: #565e74;',
    ];
    $style = $variantStyles[$variant] ?? $variantStyles['info'];
@endphp

<span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-family: 'Geist', sans-serif; font-size: 11px; font-weight: 500; letter-spacing: 0.02em; {{ $style }}" {{ $attributes }}>
    {{ $slot }}
</span>
