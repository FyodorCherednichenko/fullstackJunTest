<?php
abstract class deliveryService
{

    public float $delivery_cost;
    abstract public function delivery_cost_calc(float $package_weight);

    public function __construct(
        float $package_weight,
        public string $name = 'delivery_service'
    ) {
       $this->delivery_cost = $this->delivery_cost_calc($package_weight);
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_delivery_cost(): float
    {
        return $this->delivery_cost;
    }

    public function set_name($name): void
    {
        $this->name = $name;

    }
}

class DHL extends deliveryService
{
    public function delivery_cost_calc($package_weight): float
    {
        return $this->delivery_cost = 100 * $package_weight;
    }
}

class RusPostOffice extends deliveryService
{
    public function delivery_cost_calc($package_weight): float
    {
        $package_weight > 10 ? $this->delivery_cost = 1000 : $this->delivery_cost = 100;
        return $this->delivery_cost;
    }
}

class SDEK extends deliveryService
{
    public function delivery_cost_calc($package_weight): float
    {
        return $this->delivery_cost = $package_weight * 200;
    }
}

$DHL = new DHL(10, 'DHL');
$rus_post_office = new RusPostOffice(5, 'RusPostOffice');
$SDEK = new SDEK(19.5, 'SDEK');
var_dump($SDEK);
var_dump($DHL);
var_dump($rus_post_office);
