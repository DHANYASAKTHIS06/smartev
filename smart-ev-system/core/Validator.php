<?php
namespace Core;

class Validator {
    public static function email($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function batteryPct($pct): bool {
        return is_numeric($pct) && $pct >= 0 && $pct <= 100;
    }

    public static function positiveNumber($val): bool {
        return is_numeric($val) && $val > 0;
    }

    public static function required(array $data, array $fields): array {
        $missing = [];
        foreach ($fields as $f) {
            if (!isset($data[$f]) || trim((string)$data[$f]) === '') {
                $missing[] = $f;
            }
        }
        return $missing;
    }
}
