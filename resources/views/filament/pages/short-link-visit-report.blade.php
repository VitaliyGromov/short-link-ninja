<x-filament-panels::page>
    <div class="grid gap-6">
        <x-filament::section>
            <x-slot name="heading">
                Общая статистика
            </x-slot>

            <p class="text-3xl font-semibold text-gray-950 dark:text-white">
                {{ number_format($this->totalVisitsCount, 0, ',', ' ') }}
            </p>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Всего переходов по всем ссылкам
            </p>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                Переходы по ссылкам
            </x-slot>

            @if ($this->links === [])
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    У вас пока нет ссылок для отображения статистики.
                </p>
            @else
                <div class="w-full overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
                    <table class="w-full table-fixed divide-y divide-gray-200 dark:divide-white/10">
                        <colgroup>
                            <col style="width: 35%">
                            <col style="width: 35%">
                            <col style="width: 15%">
                            <col style="width: 15%">
                        </colgroup>
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-950 dark:text-white">
                                    Оригинальная ссылка
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-950 dark:text-white">
                                    Короткая ссылка
                                </th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-950 dark:text-white">
                                    Переходы
                                </th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-gray-950 dark:text-white">
                                    Детали
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900">
                            @foreach ($this->links as $link)
                                <tr>
                                    <td class="max-w-0 overflow-hidden px-4 py-3 text-sm">
                                        <a
                                            href="{{ $link['targetUrl'] }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="block truncate text-primary-600 hover:underline dark:text-primary-400"
                                            title="{{ $link['targetUrl'] }}"
                                        >
                                            {{ \Illuminate\Support\Str::limit($link['targetUrl'], config('short-link.length_of_original_url')) }}
                                        </a>
                                    </td>
                                    <td class="max-w-0 overflow-hidden px-4 py-3 text-sm">
                                        <a
                                            href="{{ $this->formatShortUrl($link['shortCode']) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="block truncate text-primary-600 hover:underline dark:text-primary-400"
                                            title="{{ $this->formatShortUrl($link['shortCode']) }}"
                                        >
                                            {{ $this->formatShortUrl($link['shortCode']) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-950 dark:text-white">
                                        {{ number_format($link['visitsCount'], 0, ',', ' ') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm">
                                        {{ ($this->viewLinkDetailsAction)(['shortLinkId' => $link['shortLinkId']]) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
