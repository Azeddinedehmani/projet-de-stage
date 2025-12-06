<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get the value with proper type casting
     */
    public function getTypedValueAttribute()
    {
        return match($this->type) {
            'boolean' => (bool) $this->value,
            'integer' => (int) $this->value,
            'float' => (float) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value
        };
    }

    /**
     * Set value with proper type handling
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = match($this->type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value
        };
    }

    /**
     * Get setting by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $setting->typed_value;
    }

    /**
     * Set setting by key
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $description = null)
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->type = $type;
        $setting->group = $group;
        
        if ($description) {
            $setting->description = $description;
        }
        
        $setting->save();
        
        return $setting;
    }

    /**
     * Get settings by group
     */
    public static function getGroup($group)
    {
        return static::where('group', $group)->get()->pluck('typed_value', 'key');
    }

    /**
     * Scope for public settings
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Get all settings as key-value array
     */
    public static function getAllSettings()
    {
        return static::all()->pluck('typed_value', 'key')->toArray();
    }

    /**
     * Get password validation rules based on system settings
     */
    public static function getPasswordValidationRules($field = 'password')
    {
        $minLength = static::get('password_min_length', 8);
        $requireUppercase = static::get('password_require_uppercase', false);
        $requireLowercase = static::get('password_require_lowercase', false);
        $requireNumbers = static::get('password_require_numbers', false);
        $requireSymbols = static::get('password_require_symbols', false);

        $rules = [
            'required',
            'string',
            "min:{$minLength}",
            'confirmed'
        ];

        // Custom validation rule for password complexity
        if ($requireUppercase || $requireLowercase || $requireNumbers || $requireSymbols) {
            $rules[] = function ($attribute, $value, $fail) use ($requireUppercase, $requireLowercase, $requireNumbers, $requireSymbols) {
                $errors = [];

                if ($requireUppercase && !preg_match('/[A-Z]/', $value)) {
                    $errors[] = 'au moins une lettre majuscule';
                }

                if ($requireLowercase && !preg_match('/[a-z]/', $value)) {
                    $errors[] = 'au moins une lettre minuscule';
                }

                if ($requireNumbers && !preg_match('/[0-9]/', $value)) {
                    $errors[] = 'au moins un chiffre';
                }

                if ($requireSymbols && !preg_match('/[^A-Za-z0-9]/', $value)) {
                    $errors[] = 'au moins un caractère spécial';
                }

                if (!empty($errors)) {
                    $fail('Le mot de passe doit contenir ' . implode(', ', $errors) . '.');
                }
            };
        }

        return $rules;
    }

    /**
     * Validate password against system requirements
     */
    public static function validatePassword($password)
    {
        $minLength = static::get('password_min_length', 8);
        $requireUppercase = static::get('password_require_uppercase', false);
        $requireLowercase = static::get('password_require_lowercase', false);
        $requireNumbers = static::get('password_require_numbers', false);
        $requireSymbols = static::get('password_require_symbols', false);

        $errors = [];

        // Length check
        if (strlen($password) < $minLength) {
            $errors[] = "Le mot de passe doit contenir au moins {$minLength} caractères.";
        }

        // Character requirements
        if ($requireUppercase && !preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
        }

        if ($requireLowercase && !preg_match('/[a-z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre minuscule.';
        }

        if ($requireNumbers && !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un chiffre.';
        }

        if ($requireSymbols && !preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un caractère spécial.';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Get password strength score (0-100)
     */
    public static function getPasswordStrength($password)
    {
        $score = 0;
        $minLength = static::get('password_min_length', 8);

        // Length scoring
        if (strlen($password) >= $minLength) $score += 25;
        if (strlen($password) >= 12) $score += 15;
        if (strlen($password) >= 16) $score += 10;

        // Character variety scoring
        if (preg_match('/[a-z]/', $password)) $score += 10;
        if (preg_match('/[A-Z]/', $password)) $score += 10;
        if (preg_match('/[0-9]/', $password)) $score += 15;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score += 15;

        return min($score, 100);
    }

    /**
     * Get password requirements as human-readable text
     */
    public static function getPasswordRequirementsText()
    {
        $requirements = [];
        
        $minLength = static::get('password_min_length', 8);
        $requirements[] = "Au moins {$minLength} caractères";

        if (static::get('password_require_uppercase', false)) {
            $requirements[] = "Au moins une lettre majuscule";
        }

        if (static::get('password_require_lowercase', false)) {
            $requirements[] = "Au moins une lettre minuscule";
        }

        if (static::get('password_require_numbers', false)) {
            $requirements[] = "Au moins un chiffre";
        }

        if (static::get('password_require_symbols', false)) {
            $requirements[] = "Au moins un caractère spécial";
        }

        return $requirements;
    }

    /**
     * Check if user needs to change password based on system settings
     */
    public static function userNeedsPasswordChange($user)
    {
        // Global force change setting
        if (static::get('force_password_change', false)) {
            return true;
        }

        // Individual user force change
        if ($user->force_password_change) {
            return true;
        }

        // Password age check
        $maxPasswordAge = static::get('password_max_age_days', null);
        if ($maxPasswordAge && $user->password_changed_at) {
            return $user->password_changed_at->addDays($maxPasswordAge)->isPast();
        }

        return false;
    }

    /**
     * Initialize default settings (used in seeder and migration)
     */
    public static function initializeDefaults()
    {
        $seeder = new \Database\Seeders\SystemSettingsSeeder();
        $seeder->run();
    }
}