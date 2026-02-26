<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Generate a JWT token
 */
function generateJWT(array $userData): string
{
    // CI4's env() function properly reads from .env
    $key = env('JWT_SECRET_KEY', 'LabControl_S3cr3t_K3y_2025_x9Qp4mWz7rLf8nBvTjYhKcGs');
    
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600 * 8; // 8 hours

    $payload = [
        'iss'  => 'LabControl',
        'iat'  => $issuedAt,
        'exp'  => $expirationTime,
        'data' => [
            'id'         => $userData['id_usuario'],
            'nombre'     => $userData['nombre'],
            'correo'     => $userData['correo'],
            'id_rol'     => $userData['id_rol'],
            'rol_nombre' => $userData['rol_nombre'] ?? '',
        ],
    ];

    return JWT::encode($payload, $key, 'HS256');
}

/**
 * Validate a JWT token and return payload
 */
function validateJWT(string $token): ?object
{
    $key = env('JWT_SECRET_KEY', 'LabControl_S3cr3t_K3y_2025_x9Qp4mWz7rLf8nBvTjYhKcGs');

    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return $decoded;
    } catch (\Exception $e) {
        log_message('error', 'JWT Validation Error: ' . $e->getMessage());
        return null;
    }
}
