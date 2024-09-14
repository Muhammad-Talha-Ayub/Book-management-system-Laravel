<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpseclib\Crypt\RSA;
use Illuminate\Support\Facades\File;

class GenerateRSAKeys extends Command
{
    protected $signature = 'generate:rsa-keys';

    protected $description = 'Generate RSA keys';

    public function handle()
    {
        $directoryPath = storage_path('private_keys');
                if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
        $rsa = new RSA();
        $keys = $rsa->createKey();
        $publicKey = $keys['publickey'];
        $privateKey = $keys['privatekey'];
        File::put(storage_path('private_keys/public.pem'), $publicKey);
        File::put(storage_path('private_keys/private.pem'), $privateKey);

        $this->info('RSA keys generated successfully.');
    }
}
