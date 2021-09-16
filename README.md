<p align="center">
    <img title="Nova CLI" height="100" src="https://nova-cdn.snapt.net/img/nova-color-logo.png" />
</p>

<h4> <center>This is the <bold>official</bold> Snapt Nova command line helper</center></h4>

Nova is an any-cloud, multi-location, centralized platform for deploying, controlling, and monitoring load balancers and web app firewalls at scale.

The nova-cli helper provides easy access to our open API, and includes the following features:
- ```adcs:list``` - List all ADCs on your account
- ```adcs:stats``` - Get detailed statistics for a single ADC
- ```nodes:create``` - Add a new Nova Node
- ```nodes:delete``` - Delete a Nova Node
- ```nodes:list``` - List all the Nova Nodes on your account
- ```waf:list``` - List all the WAF Profiles on your account
- ```waf:ruleset``` - List or alter the IP based rulesets for your WAF

------

## Installation

Run the below to install nova-cli globally. You can then run "nova-cli" 
```
composer global require snapt/nova-cli
```

Save your API token from Nova like so:
```
echo "YOUR_API_TOKEN" > ~/.nova-api-key
```

## Usage

You can run "nova-cli" for all the available commands, and view the requirements by adding "-h" as shown in the example below:
```
❯ ./nova-cli waf:ruleset -h
Description:
  Interact with the rulesets in a WAF profile

Usage:
  waf:ruleset <profile_id> <action> [<list> [<ip>]]

Arguments:
  profile_id            the WAF profile ID
  action                list|add|remove
  list                  allowed|blocked for when adding or removing an IP to a list
  ip                    the IP/cidr to add or remove if action is add|remove
```

## Snapt Nova

To sign up for a free Nova account go to [https://nova.snapt.net](https://nova.snapt.net)

## Usage

nova-cli is free to use for any Snapt Nova users or clients. 
