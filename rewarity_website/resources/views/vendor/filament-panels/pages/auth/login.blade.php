@php($panelId = filament()->getId())

@push('styles')
    <style>
        body.fi-body.login-screen {
            background: radial-gradient(circle at 0% 0%, #03220f 0%, #0a3d1c 40%, #17b348 100%) !important;
        }

        body.fi-body.login-screen .fi-simple-page {
            background: transparent;
        }

        body.fi-body.login-screen .fi-simple-header {
            display: none;
        }

        body.fi-body.fi-panel-admin .fi-btn-primary,
        body.fi-body.fi-panel-admin .fi-button.fi-color-primary,
        body.fi-body.fi-panel-admin .fi-link.fi-color-primary {
            --tw-bg-opacity: 1 !important;
            --tw-border-opacity: 1 !important;
            background-color: rgb(23 179 72 / var(--tw-bg-opacity)) !important;
            border-color: rgb(23 179 72 / var(--tw-border-opacity)) !important;
        }

        body.fi-body.fi-panel-admin .fi-btn-primary:hover,
        body.fi-body.fi-panel-admin .fi-button.fi-color-primary:hover,
        body.fi-body.fi-panel-admin .fi-link.fi-color-primary:focus,
        body.fi-body.fi-panel-admin .fi-button.fi-color-primary:focus {
            background-color: rgb(20 152 60 / 1) !important;
            border-color: rgb(20 152 60 / 1) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (@js($panelId) === 'admin') {
                document.body.classList.add('login-screen');
            }
        });

        document.addEventListener('livewire:navigated', () => {
            document.body.classList.remove('login-screen');
        });
    </script>
@endpush

<x-filament-panels::page.simple>
    {{-- Remove the default Laravel title --}}
    <x-slot name="heading"></x-slot>

    {{-- Optional: Add your logo or project name --}}
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Rewarity Logo" class="h-12">
    </div>

    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}
            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>
