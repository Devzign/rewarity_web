@php($user = auth()->user())

<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex flex-col gap-4 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <x-filament::avatar :user="$user" class="h-16 w-16 ring-4 ring-emerald-100" />
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Profile overview</p>
                        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $user?->name ?? 'Your profile' }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user?->user_type ?? 'Team member' }} · Member since {{ optional($user?->created_at)->format('M Y') ?? '—' }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                        <x-filament::icon icon="heroicon-o-envelope" class="h-4 w-4" />
                        {{ $user?->email }}
                    </span>
                    @if ($user?->employee_id)
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                            <x-filament::icon icon="heroicon-o-identification" class="h-4 w-4" />
                            {{ $user->employee_id }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="border-b border-gray-200 pb-4 dark:border-white/10">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Account details</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update your personal information, profile photo, and password.</p>
                    </div>
                    <div class="pt-6">
                        <x-filament-panels::form id="form" wire:submit="save">
                            {{ $this->form }}

                            <x-filament-panels::form.actions
                                :actions="$this->getCachedFormActions()"
                                :full-width="$this->hasFullWidthFormActions()"
                            />
                        </x-filament-panels::form>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Account status</h3>
                    <dl class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center justify-between">
                            <dt class="font-medium">Role</dt>
                            <dd class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                <x-filament::icon icon="heroicon-o-shield-check" class="h-4 w-4" />
                                {{ $user?->user_type ?? '—' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="font-medium">Status</dt>
                            <dd class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-300">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 dark:bg-emerald-300"></span>
                                {{ $user?->status ?? 'Active' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="font-medium">Last updated</dt>
                            <dd>{{ optional($user?->updated_at)->format('d M Y') ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Need help?</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Have a question about your credentials or access? Our support team is happy to assist.</p>
                    <a href="mailto:support@rewarity.com" class="mt-4 inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                        <x-filament::icon icon="heroicon-o-lifebuoy" class="h-4 w-4" />
                        Contact support
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
