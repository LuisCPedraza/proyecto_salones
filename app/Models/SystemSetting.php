<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Obtener un valor de configuración
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'json' => json_decode($setting->value, true),
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            default => $setting->value,
        };
    }

    /**
     * Establecer un valor de configuración
     */
    public static function setValue(string $key, $value, string $type = 'string'): self
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->type = $type;
        
        $setting->value = match ($type) {
            'json' => json_encode($value),
            'boolean' => (int) $value,
            'integer' => (int) $value,
            default => (string) $value,
        };

        $setting->save();
        return $setting;
    }
}
