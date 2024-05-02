Feature: Secrets wallet
    In order to play the game As a user
    I need to be able to put found secrets into a wallet
    Scenario: Finding a single secret
        Given there is an "amber"
        When I add the "amber" to the wallet
        Then I should have 1 secret in the wallet
    Scenario: Finding two secrets
        Given there is an "amber"
        And there is a "diamond"
        When I add the "amber" to the wallet
        And I add the "diamond" to the wallet
        Then I should have 2 secrets in the wallet