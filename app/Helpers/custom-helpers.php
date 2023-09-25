<?php

declare(strict_types=1);

use App\Models\Tenant;

if (!function_exists('tenant')) {
    function tenant(): ?Tenant
    {
        return session('tenant');
    }
}

if (!function_exists('subdomain')) {
    function subdomain(): string
    {
        $host = request()->host();

        return str($host)->explode('.')[0] ?? '';
    }
}

if (!function_exists('subdomain_url')) {
    function subdomain_url(string $subdomain, string $path = ''): string
    {
        if (filled($path)) {
            $path = str($path)->start('/')->toString();
        }

        $appUrl = config('app.url');

        $baseUrl = str($appUrl)
            ->replace('http://', '')
            ->replace('https://', '')
            ->toString();

        if (app()->isProduction() === true) {
            $subdomainUrl =  "https://{$subdomain}.{$baseUrl}{$path}";
        }

        if (app()->isProduction() === false) {
            $subdomainUrl =  "http://{$subdomain}.{$baseUrl}{$path}";
        }


        return $subdomainUrl;
    }
}

if (!function_exists('sanitize')) {
    function sanitize(string $data): string
    {
        return clean_string($data);
    }
}

if (!function_exists('clean_string')) {
    function clean_string(string $string): string
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $string);
    }
}

if (!function_exists('check_cpf')) {
    function check_cpf(string $cpf): bool
    {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
