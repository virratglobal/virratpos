@props([
    'title',
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
            {{ $title }}
        </h1>
        @if(isset($breadcrumbs))
            <nav style="margin-top: 4px; display: flex; align-items: center; font-family: 'Inter', sans-serif; font-size: 13px; color: #767586;">
                {{ $breadcrumbs }}
            </nav>
        @endif
    </div>
    
    @if(isset($actions))
        <div style="margin-top: 16px; display: flex; align-items: center; gap: 8px;">
            {{ $actions }}
        </div>
    @endif
</div>
