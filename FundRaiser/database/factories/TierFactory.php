<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class TierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Laravel',
                'Quantum Ducks',
                'Sunset_Logic',
                '404NotFound',
                'BackflipAPI',
                'CatOps',
                'NeonBugs',
                'CyberToast',
                'RetinaStorm',
                'CoffeeFirst',
                'PixelDust',
                'BetaBees',
                'GlitchKnight',
                'EchoChamber',
                'TinfoilHack',
                'WaffleStack',
                'AsyncDrama',
                'MiddlewareMadness',
                'NullHypothesis',
                'RainbowFork',
                'GigaMeow',
                'SudoMagic',
                'BoopLoop',
                'OctopusDB',
                'SleepyQuery',
                'SnackOverflow',
                'BugSprayer',
                'ParallelUniverse',
                '404Life',
                'MonochromeMode',
                'BananaCommit',
                'ConfettiRender',
                'FunkySchemas',
                'RocketFuel',
                'HoverBear',
                'InfiniteScrolls',
                'DeadPixel',
                'NightlyCrashes',
                'LatteLoop',
                'UnicornThread',
                'BlobProtocol',
                'MehEngine',
                'SpaghettiCode',
                'QuantumCSS',
                'BurntToast',
                'DragonSyntax',
                'ZebraLogic',
                'CloudKaraoke',
                'LegendaryLint',
                'PunchCardClub',
                'DarkModeOnly',
            ])
        ];
    }
}
