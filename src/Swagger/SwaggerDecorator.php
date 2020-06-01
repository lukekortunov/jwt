<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private NormalizerInterface $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $docs['components']['schemas']['Token'] = [
            'type'       => 'object',
            'properties' => [
                'token' => [
                    'type'     => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['Credentials'] = [
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

        $docs['components']['schemas']['CredentialsRefresh'] = [
            'type'       => 'object',
            'properties' => [
                'refresh_token' => [
                    'type' => 'string',
                    'example' => '',
                ],
            ],
        ];

        $tokenDocumentation = [
            'paths' => [
                '/api/auth/token' => [
                    'post' => [
                        'tags'        => ['Auth'],
                        'operationId' => 'postCredentialsItem',
                        'summary'     => 'Get JWT token to login.',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content'     => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Credentials',
                                    ],
                                ],
                            ],
                        ],
                        'responses'   => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content'     => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/auth/refresh' => [
                    'post' => [
                        'tags'          => ['Auth'],
                        'operationId'   => 'refreshCredentialsItem',
                        'summary'       => 'Exchange refresh token on new JWT + Refresh pair.',
                        'requestBody'   => [
                            'description'   => 'Refresh JWT token',
                            'content'     => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/CredentialsRefresh',
                                    ],
                                ],
                            ],
                        ],
                        'responses'     => [
                            Response::HTTP_OK => [
                                'description' => 'Refresh JWT token',
                                'content'     => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $tokenDocumentation);
    }
}
