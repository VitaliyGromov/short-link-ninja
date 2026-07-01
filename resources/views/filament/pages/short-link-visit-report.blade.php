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
                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900">
                            @foreach ($this->links as $link)
                                <tr>
                                    <td class="px-4 py-3 text-sm">
                                        <a
                                            href="{{ $link['targetUrl'] }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary-600 hover:underline dark:text-primary-400"
                                        >
                                            {{ \Illuminate\Support\Str::limit($link['targetUrl'], 50) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <a
                                            href="{{ $this->formatShortUrl($link['shortCode']) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-primary-600 hover:underline dark:text-primary-400"
                                        >
                                            {{ $this->formatShortUrl($link['shortCode']) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-950 dark:text-white">
                                        {{ number_format($link['visitsCount'], 0, ',', ' ') }}
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
