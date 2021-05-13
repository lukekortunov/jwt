<?php

declare(strict_types=1);

namespace App\Swagger;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;

final class JWTDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = [
            'type'       => 'object',
            'properties' => [
                'token' => [
                    'type'     => 'string',
                    'readOnly' => true,
                ],
                'refresh_token' => [
                    'type'      => 'string',
                    'readOnly'  => true,
                ]
            ],
        ];
        $schemas['Credentials'] = [
            'type'       => 'object',
            'properties' => [
                'email' => [
                    'type'    => 'email',
                    'example' => 'email@email1.test',
                ],
                'password' => [
                    'type'    => 'string',
                    'example' => 'email@email1.test',
                ],
            ],
        ];
        $schemas['CredentialsRefresh'] = [
            'type'       => 'object',
            'properties' => [
                'refresh_token' => [
                    'type'    => 'string',
                    'example' => '',
                ],
            ],
        ];

        $openApi->getPaths()->addPath('/api/auth/token', $this->releaseTokenItem());
        $openApi->getPaths()->addPath('/api/auth/refresh', $this->refreshTokenItem());

        return $openApi;
    }

    private function releaseTokenItem(): PathItem
    {
        $operationID    = 'postCredentialsItem';
        $tags           = ['Auth'];
        $summary        = 'Get JWT token to login.';
        $description    = '';

        $request        = new RequestBody(
            'Generate new JWT Token',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Credentials',
                    ],
                ],
            ]),
        );
        $responses      = [
            '200' => [
                'description' => 'Get JWT token',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Token',
                        ],
                    ],
                ],
            ],
        ];

        return new PathItem('Release JWT Token', '', '', null, null, new Operation(
            $operationID,
            $tags,
            $responses,
            $summary,
            $description,
            null,
            [],
            $request
        ));
    }

    private function refreshTokenItem(): PathItem
    {
        $operationID    = 'refreshCredentialsItem';
        $tags           = ['Auth'];
        $summary        = 'Exchange refresh token on new JWT + Refresh pair.';
        $description    = '';

        $request = new RequestBody(
            'Refresh JWT Token',
            new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/CredentialsRefresh',
                    ],
                ],
            ]),
        );

        $responses = [
            '200' => [
                'description' => 'Refresh JWT token',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Token',
                        ],
                    ],
                ],
            ],
        ];

        return new PathItem('Refresh JWT Token', '', '', null, null, new Operation(
            $operationID,
            $tags,
            $responses,
            $summary,
            $description,
            null,
            [],
            $request
        ));
    }
}
