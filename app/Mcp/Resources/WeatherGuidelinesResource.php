<?php

namespace App\Mcp\Resources;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Resource;

class WeatherGuidelinesResource extends Resource
{
    /**
     * The resource's name.
     */
    protected string $name = 'weather-climate-docs';

    /**
     * The resource's title.
     */
    protected string $title = 'Weather vs Climate Documentation';

    protected string $uri = 'https://www.weather.gov/media/climateservices/WeatherAndClimate.pdf';

    protected string $mimeType = 'application/pdf';

    /**
     * The resource's description.
     */
    protected string $description = <<<'MARKDOWN'
        A resource that provides documentation on the differences between weather and climate, including definitions, examples, and implications for forecasting.
    MARKDOWN;

    /**
     * Handle the resource request.
     */
    public function handle(Request $request): Response
    {
        //

        return Response::text('The resource content.');
    }
}
