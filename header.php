<?php
const ENV_PATH =  '.env';

class ReadAndParseEnvException extends Exception{};

//
 // @throws ReadAndParseEnvException
 //
function env(string $pair): string{
    $config = parse_ini_file(dirname(__FILE__,1) . '/' . ENV_PATH);

    if($config === false){
        throw new ReadAndParseEnvException();
    }

    return $config[$pair];
}

printf("Local database username: %s\n", env('DATABASE_USER'));
printf("Local database password (hashed): %s\n", password_hash(env('DATABASE_USER_PASSWORD'), PASSWORD_DEFAULT));
