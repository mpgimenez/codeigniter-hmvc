<?php
class Troco
{
    public $notasDisponiveis = [100, 50, 20, 10, 5, 2, 1, 0.5, 0.25, 0.10, 0.05, 0.01];
    public function getQtdeNotas( $value ): array
    {
        $return = [];

        foreach( $this->notasDisponiveis as $nota ){
            $qty = floor($value / $nota );
            $return[ (string) $nota ] = $qty;

            $value -= $qty * $nota;
            $value = round($value, 2);
        }

        return $return;
    }
}

$troco = new Troco();
$notas = $troco->getQtdeNotas(289.99);
print_r($notas);
