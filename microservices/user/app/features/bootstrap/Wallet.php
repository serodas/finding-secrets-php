<?php
final class Wallet implements \Countable
{
    private array $secrets;
    public function __construct(private SecretsCache $secretsCache)
    {
        $this->secretsCache = $secretsCache;
    }

    public function addSecret($secret): void
    {
        $this->secrets[] = $secret;
    }

    public function count(): int
    {
        return count($this->secrets);
    }
}
