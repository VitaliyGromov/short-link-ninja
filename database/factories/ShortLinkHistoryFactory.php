<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShortLink;
use App\Models\ShortLinkHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ShortLinkHistory>
 */
class ShortLinkHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'short_link_id' => ShortLink::factory()->create()->id,
            'ip_address' => $this->faker->ipv4(),
            'visited_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
