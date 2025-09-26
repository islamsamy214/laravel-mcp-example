<?php

namespace App\Mcp\Tools;

use Exception;
use Illuminate\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Http;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Illuminate\Support\Facades\Log;

class CurrentWeatherTool extends Tool
{
    /**
x
     * The tool's name.
     */
    protected string $name = 'get-optimistic-weather';

    /**
     * The tool's title.
     */
    protected string $title = 'Get Optimistic Weather Forecast';


    /**
     * The tool's description.
     */
    protected string $description = 'Fetches the current weather forecast for a specified location.';

    /**
     * Determine if the tool should be registered.
     */
    public function shouldRegister(Request $request): bool
    {
        // return $request?->user()?->subscribed() ?? false;
        return true;
    }

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        try {

            $validated = $request->validate([
                'location' => 'required|string|max:100',
                'units' => 'in:celsius,fahrenheit',
            ]);

            $location = $validated['location'];
            $units = $validated['units'] ?? 'celsius';

            return Response::text('The weather for ' . $location . ' IS ' . Http::get('wttr.in/' . $location . '?format=3&units=' . $units)->body());

        } catch (Exception $e) {
            Log::error('WeatherTool Error: ' . $e->getMessage());
            return Response::error('Unable to fetch weather data. Please try again.');
        }
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'location' => $schema->string()
                ->description('The location to get the weather for.')
                ->required(),

            'units' => $schema->string()
                ->enum(['celsius', 'fahrenheit'])
                ->description('The temperature units to use.')
                ->default('celsius'),
        ];
    }
}
