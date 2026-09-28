<?php
namespace Config;

require_once __DIR__ . '/app.php';

class Database {
    public static function getConfig() {
        return [
            'uri' => App::get('NEO4J_URI', 'neo4j+s://355200dd.databases.neo4j.io'),
            'http_uri' => App::get('NEO4J_HTTP_URI', 'https://355200dd.databases.neo4j.io'),
            'username' => App::get('NEO4J_USERNAME', 'neo4j'),
            'password' => App::get('NEO4J_PASSWORD', 'dYjIauLvTPSjKPdsgM8J2fpRikZVJECCxLvlU4PwZiA'),
            'database' => App::get('NEO4J_DATABASE', 'neo4j')
        ];
    }
}
