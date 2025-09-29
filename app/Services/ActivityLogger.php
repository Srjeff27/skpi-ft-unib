<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable as User;

class ActivityLogger
{
    public static function log(User $user, string $action, $subject = null, array $properties = []): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $user->getAuthIdentifier(),
            'action' => $action,
            'subject_type' => is_object($subject) ? get_class($subject) : null,
            'subject_id' => is_object($subject) && method_exists($subject, 'getKey') ? $subject->getKey() : null,
            'properties' => $properties,
        ]);
    }
}

