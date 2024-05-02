<?php

final class SecretsCache
{
    private array $secretsMap = [];
    public function setSecret($secret): void
    {
        $this->secretsMap[$secret] = $secret;
    }

    public function getSecret($secret): string
    {
        return $this->secretsMap[$secret];
    }
}
