<<<<<<< HEAD
{{-- @dd(get_defined_vars()) --}}
@php
    $method = $record->method;
    $methodColor = match ($method) {
        'DELETE' => \Illuminate\Support\Arr::toCssClasses([
            'text-danger-700 bg-danger-500/10 dark:text-danger-500 border border-danger-400/20',
        ]),
        'POST' => \Illuminate\Support\Arr::toCssClasses([
            'text-primary-700 bg-primary-500/10 dark:text-primary-500 border border-primary-400/20',
        ]),
        'GET' => \Illuminate\Support\Arr::toCssClasses([
            'text-success-700 bg-success-500/10 dark:text-success-500 border border-success-400/20',
        ]),
        'PUT' => \Illuminate\Support\Arr::toCssClasses([
            'text-warning-700 bg-warning-500/10 dark:text-warning-500 border border-warning-400/20',
        ]),
        'PATCH', 'OPTIONS' => \Illuminate\Support\Arr::toCssClasses([
            'text-gray-700 bg-gray-500/10 dark:text-gray-300 dark:bg-gray-500/20 border border-gray-400/20',
        ]),
        default => \Illuminate\Support\Arr::toCssClasses([
            'text-gray-700 bg-gray-500/10 dark:text-gray-300 dark:bg-gray-500/20 border border-gray-400/20',
        ]),
    };
@endphp

<x-filament-panels::page>

    <div class="px-6 py-5 bg-white border border-gray-200 rounded-xl shadow-none dark:bg-gray-900 dark:border-gray-950 sm:px-6"
        x-data="{
            init() {
                    this.updateClasses();
                    this.setTableFirstTdWidth();

                    // Optional: observe dynamic changes
                    const observer = new MutationObserver(() => {
                        this.updateClasses();
                        this.setTableFirstTdWidth();
                    });
                    this.$el.querySelectorAll('li.fi-in-repeatable-item').forEach(li => {
                        observer.observe(li, { childList: true, subtree: true });
                    });
                },

                updateClasses() {
                    this.$el.querySelectorAll('li.fi-in-repeatable-item').forEach(li => {
                        const visibleCols = Array.from(li.querySelectorAll('div.fi-sc > div.fi-grid-col'))
                            .filter(div => !div.classList.contains('fi-hidden')); // filter out hidden cols

                        const classes = ['p-4', 'bg-gray-50', 'rounded-xl', 'dark:bg-gray-800']; // multiple Tailwind classes
                        if (visibleCols.length > 1) {
                            li.classList.add(...classes);
                        } else {
                            li.classList.remove(...classes);
                        }
                    });
                },
                setTableFirstTdWidth() {
                    document.querySelectorAll('table.fi-in-key-value tbody').forEach(tbody => {
                        tbody.querySelectorAll('tr').forEach(tr => {
                            const firstTd = tr.querySelector('td');
                            if (firstTd) {
                                firstTd.style.width = '20%';
                            }
                        });
                    });
                },

        }">
        <h3 class="flex items-center text-base font-semibold leading-6 text-gray-900 dark:text-gray-50">
            <span class="{{ $methodColor }} rounded-s-lg px-3 py-0.5">{{ $method }}</span>
            <span
                class=" px-3 py-0.5 text-gray-700 text-base border border-gray-200 dark:border-gray-800 bg-gray-100 rounded-e-lg dark:bg-gray-800 dark:text-gray-100">{{ $record->path }}
            </span>
        </h3>
        <div class="flex items-center max-w-2xl mt-1 text-sm leading-5 text-gray-500">
            <span class="mt-1 font-mono text-xs text-gray-600 dark:text-gray-200">
                {{ __('filament-exceptions::filament-exceptions.columns.occurred_at') }}:

                {{ $record->created_at->toDateTimeString() }}
            </span>
        </div>
        <div class="pt-5">
            {{ $record->message }}
        </div>
    </div>

    {{ $this->content }}

</x-filament-panels::page>
=======
@php
    use Illuminate\Foundation\Exceptions\Renderer\Renderer;
    use BezhanSalleh\FilamentExceptions\FilamentExceptionsServiceProvider;

    $exception = $this->getStoredException();
    $record = $exception->record();
@endphp

<div class="gap-8 flex">
    {{-- Include our custom CSS (class-based dark mode for Filament compatibility) --}}
    {{-- {!! Renderer::css() !!} --}}
    {!! FilamentExceptionsServiceProvider::css() !!}
    <div class="flex flex-col gap-y-8" dir="ltr">
        {{-- Use Laravel's header component --}}
        <x-laravel-exceptions-renderer::header :$exception />

        {{-- Use Laravel's trace component --}}
        <x-laravel-exceptions-renderer::trace :$exception />

        {{-- Use Laravel's query component --}}
        <x-laravel-exceptions-renderer::query :queries="$exception->applicationQueries()" />

        {{-- Use Laravel's request-header component --}}
        <x-laravel-exceptions-renderer::request-header :headers="$exception->requestHeaders()" />

        {{-- Use Laravel's request-body component --}}
        <x-laravel-exceptions-renderer::request-body :body="$exception->requestBody()" />

        {{-- Use Laravel's routing component --}}
        <x-laravel-exceptions-renderer::routing :routing="$exception->applicationRouteContext()" />

        {{-- Use Laravel's routing-parameter component --}}
        <x-laravel-exceptions-renderer::routing-parameter :routeParameters="$exception->applicationRouteParametersContext()" />

        {{-- Cookies Section (not in Laravel's renderer, but we store it) --}}
        @if (filled($record->cookies))
            <div class="flex flex-col gap-3">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">Cookies</h2>
                <div class="flex flex-col gap-1">
                    @foreach ($record->cookies as $key => $value)
                        <div class="flex max-w-full items-baseline gap-2 text-sm font-mono py-1">
                            <div class="uppercase text-neutral-500 dark:text-neutral-400 shrink-0">{{ $key }}</div>
                            <div class="min-w-6 grow h-3 border-b-2 border-dotted border-neutral-300 dark:border-neutral-600"></div>
                            <div class="truncate text-neutral-900 dark:text-white" title="{{ is_array($value) ? json_encode($value) : $value }}">
                                {{ is_array($value) ? json_encode($value) : $value }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Timestamp & IP (extra info not in Laravel's renderer) --}}
        <div class="flex flex-wrap items-center gap-4 text-xs text-neutral-500 dark:text-neutral-400 pb-4">
            <div class="flex items-center gap-1.5">
                <x-laravel-exceptions-renderer::icons.info class="w-4 h-4" />
                <span>Recorded: {{ $record->created_at->format('M d, Y H:i:s') }}</span>
            </div>
            @if ($record->ip)
                <div class="flex items-center gap-1.5">
                    <x-laravel-exceptions-renderer::icons.globe class="w-4 h-4" />
                    <span class="font-mono">{{ $record->ip }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Include our custom JS (without Alpine.js to avoid Filament conflicts) --}}
    {!! FilamentExceptionsServiceProvider::js() !!}
</div>
>>>>>>> v4
