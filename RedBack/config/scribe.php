<?php

use Knuckles\Scribe\Extracting\Strategies;
use Knuckles\Scribe\Config\Defaults;
use Knuckles\Scribe\Config\AuthIn;
use function Knuckles\Scribe\Config\{removeStrategies, configureStrategy};

return [
    // The HTML <title> for the generated documentation.
    'title' => config('app.name') . ' API Documentation',

    // A short description of your API. Will be included in the docs webpage, Postman collection and OpenAPI spec.
    'description' => 'Documentación automática de la API de REDVEL Framework. Generada automáticamente desde las rutas y controladores.',

    // Text to place in the "Introduction" section, right after the `description`. Markdown and HTML are supported.
    'intro_text' => <<<INTRO
        Esta documentación proporciona toda la información necesaria para trabajar con nuestra API.

        <aside>Mientras navegas, verás ejemplos de código para trabajar con la API en diferentes lenguajes de programación en el área oscura a la derecha (o como parte del contenido en móvil).
        Puedes cambiar el lenguaje usado con las pestañas en la parte superior derecha (o desde el menú de navegación en la parte superior izquierda en móvil).</aside>
    INTRO,

    // The base URL displayed in the docs.
    'base_url' => env('APP_URL', config("app.url")),

    // Routes to include in the docs
    'routes' => [
        [
            'match' => [
                // Match only routes whose paths match this pattern (use * as a wildcard to match any characters).
                'prefixes' => ['api/*'],

                // Match only routes whose domains match this pattern (use * as a wildcard to match any characters).
                'domains' => ['*'],
            ],

            // Include these routes even if they did not match the rules above.
            'include' => [
                // 'users.index', 'POST /new', '/auth/*'
            ],

            // Exclude these routes even if they matched the rules above.
            'exclude' => [
                // 'GET /health', 'admin.*'
            ],
        ],
    ],

    // The type of documentation output to generate.
    // - "static" will generate a static HTMl page in the /public/docs folder,
    // - "laravel" will generate the documentation as a Blade view, so you can add routing and authentication.
    'type' => 'laravel',

    // See https://scribe.knuckles.wtf/laravel/reference/config#theme for supported options
    'theme' => 'default',

    'static' => [
        // HTML documentation, assets and Postman collection will be generated to this folder.
        'output_path' => 'public/docs',
    ],

    'laravel' => [
        // Whether to automatically create a docs route for you to view your generated docs.
        'add_routes' => true,

        // URL path to use for the docs endpoint (if `add_routes` is true).
        'docs_url' => '/docs',

        // Directory within `public` in which to store CSS and JS assets.
        'assets_directory' => null,

        // Middleware to attach to the docs endpoint (if `add_routes` is true).
        // Usamos nuestro middleware personalizado para controlar acceso con API_DOC
        'middleware' => [\App\Http\Middleware\EnsureApiDocEnabled::class],
    ],

    'external' => [
        'html_attributes' => []
    ],

    'try_it_out' => [
        // Add a Try It Out button to your endpoints so consumers can test endpoints right from their browser.
        'enabled' => true,

        // The base URL to use in the API tester.
        'base_url' => env('APP_URL', config("app.url")),

        // [Laravel Sanctum] Fetch a CSRF token before each request.
        'use_csrf' => false,

        // The URL to fetch the CSRF token from (if `use_csrf` is true).
        'csrf_url' => '/sanctum/csrf-cookie',
    ],

    // How is your API authenticated? This information will be used in the displayed docs, generated examples and response calls.
    'auth' => [
        // Set this to true if ANY endpoints in your API use authentication.
        'enabled' => true,

        // Set this to true if your API should be authenticated by default.
        // Si es false, Scribe detectará automáticamente qué rutas requieren auth basándose en middleware
        'default' => false,

        // Where is the auth value meant to be sent in a request?
        'in' => AuthIn::BEARER->value,

        // The name of the auth parameter (e.g. token, key, apiKey) or header (e.g. Authorization, Api-Key).
        'name' => 'Authorization',

        // The value of the parameter to be used by Scribe to authenticate response calls.
        'use_value' => env('SCRIBE_AUTH_KEY', 'Bearer {token}'),

        // Placeholder your users will see for the auth parameter in the example requests.
        'placeholder' => ' {your-token-here}',

        // Any extra authentication-related info for your users.
        'extra_info' => 'Para obtener un token, realiza un POST a `/api/login` con tus credenciales. El token JWT será retornado en la respuesta.',
    ],

    // Example requests for each endpoint will be shown in each of these languages.
    'example_languages' => [
        'bash',
        'javascript',
        // 'php',
    ],

    // Generate a Postman collection (v2.1.0) in addition to HTML docs.
    'postman' => [
        'enabled' => true,

        'overrides' => [
            // 'info.version' => '2.0.0',
        ],
    ],

    // Generate an OpenAPI spec in addition to docs webpage.
    'openapi' => [
        'enabled' => true,

        // The OpenAPI spec version to generate.
        'version' => '3.0.3',

        'overrides' => [
            // 'info.version' => '2.0.0',
        ],

        // Additional generators to use when generating the OpenAPI spec.
        'generators' => [],
    ],

    'groups' => [
        // Endpoints which don't have a @group will be placed in this default group.
        'default' => 'Endpoints',

        // By default, Scribe will sort groups alphabetically, and endpoints in the order their routes are defined.
        'order' => [],
    ],

    // Custom logo path.
    'logo' => false,

    // Customize the "Last updated" value displayed in the docs.
    'last_updated' => 'Última actualización: {date:d/m/Y}',

    'examples' => [
        // Set this to any number to generate the same example values for parameters on each run.
        'faker_seed' => 1234,

        // With API resources and transformers, Scribe tries to generate example models to use in your API responses.
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'],
    ],

    // The strategies Scribe will use to extract information about your routes at each stage.
    'strategies' => [
        'metadata' => [
            // Nuestra estrategia personalizada primero para detectar JWT automáticamente
            \App\Extracting\Strategies\DetectJwtMiddleware::class,
            ...Defaults::METADATA_STRATEGIES,
        ],
        'headers' => [
            ...Defaults::HEADERS_STRATEGIES,
            Strategies\StaticData::withSettings(data: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]),
        ],
        'urlParameters' => [
            ...Defaults::URL_PARAMETERS_STRATEGIES,
        ],
        'queryParameters' => [
            ...Defaults::QUERY_PARAMETERS_STRATEGIES,
        ],
        'bodyParameters' => [
            // Prioridad: primero FormRequests, luego validaciones inline, luego docblocks
            ...Defaults::BODY_PARAMETERS_STRATEGIES,
            // Asegurar que GetFromInlineValidator esté activo para detectar $request->validate()
        ],
        'responses' => configureStrategy(
            Defaults::RESPONSES_STRATEGIES,
            Strategies\Responses\ResponseCalls::withSettings(
                only: ['GET *'],
                // Recommended: disable debug mode in response calls to avoid error stack traces in responses
                config: [
                    'app.debug' => false,
                ]
            )
        ),
        'responseFields' => [
            ...Defaults::RESPONSE_FIELDS_STRATEGIES,
        ]
    ],

    // For response calls, API resource responses and transformer responses,
    // Scribe will try to start database transactions, so no changes are persisted to your database.
    'database_connections_to_transact' => [config('database.default')],

    'fractal' => [
        // If you are using a custom serializer with league/fractal, you can specify it here.
        'serializer' => null,
    ],
];
