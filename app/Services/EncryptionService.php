<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EncryptionService
{
    /**
     * Encrypt an ID for URL use
     */
    public static function encryptId($id)
    {
        return Crypt::encrypt($id);
    }

    /**
     * Decrypt an ID from URL
     */
    public static function decryptId($encryptedId)
    {
        try {
            return Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }

    /**
     * Get encrypted route parameter
     */
    public static function getEncryptedRouteKey($model)
    {
        return self::encryptId($model->id);
    }
}