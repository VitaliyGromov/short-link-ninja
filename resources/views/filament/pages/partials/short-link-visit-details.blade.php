@if ($visits === [])
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Переходов по этой ссылке пока нет.
    </p>
@else
    <div class="w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10">
        <table class="w-full table-fixed divide-y divide-gray-200 dark:divide-white/10">
            <colgroup>
                <col style="width: 50%">
                <col style="width: 50%">
            </colgroup>
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-950 dark:text-white">
                        IP-адрес
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-950 dark:text-white">
                        Время посещения
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900">
                @foreach ($visits as $visit)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-950 dark:text-white">
                            {{ $visit['ipAddress'] }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-950 dark:text-white">
                            {{ $visit['visitedAt'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
