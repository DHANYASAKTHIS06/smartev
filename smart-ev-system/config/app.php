<?php
namespace Config;

class App {
    public static function initEnv() {
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                list($key, $val) = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val);
                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    putenv("$key=$val");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }
    }

    public static function get($key, $default = null) {
        self::initEnv();
        $val = getenv($key);
        return $val !== false ? $val : $default;
    }
}

App::initEnv();
