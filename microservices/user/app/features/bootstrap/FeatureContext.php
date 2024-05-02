<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $secretsCache;
    private $wallet;
    public function __construct()
    {
        $this->secretsCache = new SecretsCache();
        $this->wallet       = new Wallet($this->secretsCache);
    }

    /**
     * @Given there is a(n) :secret
     */
    public function thereIsA(string $secret): void
    {
        $this->secretsCache->setSecret($secret);
    }

    /**
     * @When I add the :secret to the wallet
     */
    public function iAddTheToTheWallet(string $secret): void
    {
        $this->wallet->addSecret($secret);
    }

    /**
     * @Then I should have :count secret(s) in the wallet
     */
    public function iShouldHaveSecretInTheWallet($count)
    {
        Assert::assertCount(intval($count), $this->wallet);
    }
}
