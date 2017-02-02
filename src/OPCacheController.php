<?php

namespace FreWillems\OPCache;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OPCacheController
{
    private $hasher;

    public function __construct(BcryptHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function clear(Request $request)
    {
        if (!$request->has('token'))
        {
            return new JsonResponse(['message' => 'Invalid request'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $token = $request->input('token');

        if ($this->hasher->check(config('opcache.salt') . config('app.key'), $token))
        {
            if (!function_exists('opcache_reset'))
            {
                return new JsonResponse(['message' => 'PHP has no OPcache support'], JsonResponse::HTTP_NOT_IMPLEMENTED);
            }
            else if (opcache_reset())
            {
                return new JsonResponse(['message' => 'OPcache reset done'], JsonResponse::HTTP_OK);
            }
        }

        return new JsonResponse(['message' => 'Something went wrong'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}