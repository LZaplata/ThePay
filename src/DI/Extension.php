<?php


namespace LZaplata\ThePay\DI;


use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class Extension extends CompilerExtension
{
    /**
     * @return Schema
     */
    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            "demo" => Expect::bool()->default(true),
            "merchantId" => Expect::string(),
            "projectId" => Expect::int(),
            "apiPassword" => Expect::string(),
        ]);
    }

    /**
     * @return void
     */
    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $config = $builder->addDefinition($this->prefix("config"))
            ->setFactory("ThePay\ApiClient\TheConfig", [
                $this->config->merchantId,
                $this->config->projectId,
                $this->config->apiPassword,
                $this->config->demo ? "https://demo.api.thepay.cz/" : "https://api.thepay.cz/",
                $this->config->demo ? "https://demo.gate.thepay.cz/" : "https://gate.thepay.cz/",
            ]);

        $client = $builder->addDefinition($this->prefix("client"))
            ->setFactory("ThePay\ApiClient\TheClient", [
                $config,
            ]);

        $builder->addDefinition($this->prefix("service"))
            ->setFactory("LZaplata\ThePay\Service");
    }
}