<?php

namespace Database\Factories;

use App\Models\Personal_chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "sender_id" => User::factory(),
            "recipient_id" => User::factory(),
            "chat_id" => Personal_chat::factory(),
            "message" => fake()->realText(),
            "status" => fake()->text()

        ];
    }
}
