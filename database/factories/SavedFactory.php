<?php

namespace Database\Factories;

use App\Models\post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\saved>
 */
class SavedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::get('id')->random(),
            'post_id' => post::get('id')->random(),
        ];
    }
}
