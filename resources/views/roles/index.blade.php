@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Roles & Permissions') }}
@endsection

@section('content')
<x-ui.page-container>

    {{-- ===================== PAGE HEADER ===================== --}}
    <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 28px;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                    {{ __('Roles & Permissions') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 4px 0 0;">
                    {{ __('Manage staff roles and control what each role can access.') }}
                </p>
            </div>
            @can('Create Role')
                <a href="#"
                   data-url="{{ route('roles.create') }}"
                   data-title="{{ __('Add Role') }}"
                   data-size="lg"
                   data-ajax-popup="true"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="{{ __('Create') }}"
                   style="text-decoration: none; align-self: flex-start;">
                    <button type="button"
                            style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #4648d4; color: #fff; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; letter-spacing: 0.01em; transition: background 0.2s;"
                            onmouseover="this.style.background='#2f2ebe'" onmouseout="this.style.background='#4648d4'">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Add Role') }}
                    </button>
                </a>
            @endcan
        </div>
    </div>

    {{-- ===================== STAT CARDS ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" style="margin-bottom: 28px;">

        {{-- Total Roles --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff0fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #4648d4;">shield_person</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ $totalRoles }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('Total Roles') }}</p>
            </div>
        </div>

        {{-- Permissions --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #e8f5e9; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #1a7431;">key</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ $totalPermissions }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('Permissions') }}</p>
            </div>
        </div>

        {{-- Staff Members --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #fff3e0; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #904900;">group</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ $staffCount }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('Staff Members') }}</p>
            </div>
        </div>

    </div>

    {{-- ===================== ROLES MANAGEMENT CARD ===================== --}}
    <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 14px; box-shadow: 0 1px 8px rgba(0,0,0,0.04); overflow: hidden;">

        {{-- Card Header: Title + Search + Filter --}}
        <div style="padding: 18px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                {{ __('Roles Management') }}
            </h2>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                {{-- Search --}}
                <div style="position: relative;">
                    <span class="material-symbols-outlined" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 16px; color: #a0a0b0; pointer-events: none;">search</span>
                    <input
                        type="text"
                        id="roles-search-input"
                        placeholder="{{ __('Search roles...') }}"
                        style="padding: 8px 12px 8px 34px; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; color: #0b1c30; outline: none; width: 200px; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#4648d4'" onblur="this.style.borderColor='rgba(199,196,215,0.4)'"
                    >
                </div>
                {{-- Status Filter --}}
                <select id="roles-status-filter"
                    style="padding: 8px 12px; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; background: #fff; outline: none; cursor: pointer; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='#4648d4'" onblur="this.style.borderColor='rgba(199,196,215,0.4)'">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="active">{{ __('Active') }}</option>
                </select>
            </div>
        </div>

        {{-- Table or Empty State --}}
        @if($roles->isEmpty())
            {{-- Empty State --}}
            <div style="text-align: center; padding: 72px 24px;">
                <div style="width: 72px; height: 72px; background: #eff0fe; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <span class="material-symbols-outlined" style="font-size: 36px; color: #4648d4;">manage_accounts</span>
                </div>
                <h3 style="font-family: 'Geist', sans-serif; font-size: 17px; font-weight: 600; color: #0b1c30; margin: 0 0 8px;">
                    {{ __('No roles created yet') }}
                </h3>
                <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin: 0 0 28px; max-width: 360px; margin-left: auto; margin-right: auto;">
                    {{ __('Create your first staff role to define permissions and access levels.') }}
                </p>
                @can('Create Role')
                    <a href="#"
                       data-url="{{ route('roles.create') }}"
                       data-title="{{ __('Add Role') }}"
                       data-size="lg"
                       data-ajax-popup="true"
                       style="text-decoration: none;">
                        <button type="button"
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 11px 22px; background: #4648d4; color: #fff; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                                onmouseover="this.style.background='#2f2ebe'" onmouseout="this.style.background='#4648d4'">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('Create Role') }}
                        </button>
                    </a>
                @endcan
            </div>

        @else
            {{-- Roles Table --}}
            <div style="overflow-x: auto;">
                <table class="table" id="pc-dt-simple" style="width: 100%; border-collapse: collapse; min-width: 640px;" id="roles-table">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(199,196,215,0.2);">
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; white-space: nowrap; background: #fafafa;">
                                {{ __('Role') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa;">
                                {{ __('Permissions') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; white-space: nowrap; background: #fafafa;">
                                {{ __('Status') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; white-space: nowrap; background: #fafafa;">
                                {{ __('Created') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: right; white-space: nowrap; background: #fafafa;">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody id="roles-table-body">
                        @foreach ($roles as $role)
                            @php
                                // Build a compact list of unique module names from permission names
                                // e.g. "Manage Products" → "Products", "Create Orders" → "Orders"
                                $permNames = $role->permissions()->pluck('name');
                                $modules = $permNames->map(function($p) {
                                    // Strip verb prefix: Manage/Create/Edit/Delete/Show/Upgrade
                                    return preg_replace('/^(Manage|Create|Edit|Delete|Show|Upgrade|Reset)\s+/i', '', $p);
                                })->unique()->values();
                                $displayModules = $modules->take(4);
                                $extraCount     = max(0, $modules->count() - 4);
                            @endphp
                            <tr class="roles-row" data-role-name="{{ strtolower($role->name) }}" style="border-bottom: 1px solid rgba(199,196,215,0.12); transition: background 0.15s;"
                                onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background='transparent'">

                                {{-- Role Name --}}
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff0fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <span class="material-symbols-outlined" style="font-size: 18px; color: #4648d4;">shield_person</span>
                                        </div>
                                        <div>
                                            <p style="font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 600; color: #0b1c30; margin: 0; white-space: nowrap;">
                                                {{ $role->name }}
                                            </p>
                                            <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 2px 0 0;">
                                                {{ $permNames->count() }} {{ __('permission') }}{{ $permNames->count() !== 1 ? 's' : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Permission Badges --}}
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; flex-wrap: wrap; gap: 5px; max-width: 340px;">
                                        @foreach ($displayModules as $mod)
                                            <span style="display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 6px; background: #f1f2fe; color: #4648d4; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 500; white-space: nowrap; letter-spacing: 0.01em;">
                                                {{ $mod }}
                                            </span>
                                        @endforeach
                                        @if($extraCount > 0)
                                            <span style="display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 6px; background: #f1f1f1; color: #767586; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 500; white-space: nowrap;">
                                                +{{ $extraCount }} {{ __('more') }}
                                            </span>
                                        @endif
                                        @if($modules->isEmpty())
                                            <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #b0afc0; font-style: italic;">{{ __('No permissions') }}</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td style="padding: 16px 24px; vertical-align: middle; white-space: nowrap;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; background: #e8f5e9; color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #1a7431; display: inline-block;"></span>
                                        {{ __('Active') }}
                                    </span>
                                </td>

                                {{-- Created Date --}}
                                <td style="padding: 16px 24px; vertical-align: middle; white-space: nowrap;">
                                    <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586;">
                                        {{ $role->created_at ? $role->created_at->format('M d, Y') : '—' }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        @can('Edit Role')
                                            <a href="#!"
                                               data-url="{{ URL::to('roles/' . $role->id . '/edit') }}"
                                               data-ajax-popup="true"
                                               data-size="lg"
                                               data-title="{{ __('Edit Role') }}"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-original-title="{{ __('Edit') }}"
                                               title="{{ __('Edit') }}"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #eff0fe; color: #4648d4; text-decoration: none; transition: background 0.15s;"
                                               onmouseover="this.style.background='#e2e3fd'" onmouseout="this.style.background='#eff0fe'">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('Delete Role')
                                            <a class="bs-pass-para"
                                               href="#"
                                               data-title="{{ __('Delete Role') }}"
                                               data-confirm="{{ __('Are You Sure?') }}"
                                               data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                               data-confirm-yes="delete-form-{{ $role->id }}"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="{{ __('Delete') }}"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #ffdad6; color: #ba1a1a; text-decoration: none; transition: background 0.15s;"
                                               onmouseover="this.style.background='#ffbdb8'" onmouseout="this.style.background='#ffdad6'">
                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-form-' . $role->id]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- No-results row (shown when search finds nothing) --}}
                <div id="roles-no-results" style="display: none; text-align: center; padding: 48px 24px;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: #c7c4d7; display: block; margin-bottom: 12px;">search_off</span>
                    <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin: 0;">{{ __('No roles match your search.') }}</p>
                </div>
            </div>

        @endif
    </div>

</x-ui.page-container>
@endsection

@push('script-page')
<script>
    (function () {
        // ── Client-side search ────────────────────────────────────────────
        var searchInput  = document.getElementById('roles-search-input');
        var statusFilter = document.getElementById('roles-status-filter');
        var noResults    = document.getElementById('roles-no-results');

        function filterRoles() {
            var query  = searchInput ? searchInput.value.toLowerCase().trim() : '';
            var rows   = document.querySelectorAll('.roles-row');
            var shown  = 0;

            rows.forEach(function (row) {
                var name = (row.getAttribute('data-role-name') || '').toLowerCase();
                var matchSearch = query === '' || name.includes(query);
                // Status filter: currently all roles are Active, so filter passes always
                var matchStatus = true;

                if (matchSearch && matchStatus) {
                    row.style.display = '';
                    shown++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResults) {
                noResults.style.display = (shown === 0 && rows.length > 0) ? 'block' : 'none';
            }
        }

        if (searchInput)  searchInput.addEventListener('input', filterRoles);
        if (statusFilter) statusFilter.addEventListener('change', filterRoles);
    })();
</script>
@endpush
