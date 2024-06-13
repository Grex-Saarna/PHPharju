<?php
class Auto {
    public $värv;
    public $tootja;
    public $kiirus;

    public function __construct($värv = "punane", $tootja = "Audi", $kiirus = 0) {
        $this->värv = $värv;
        $this->tootja = $tootja;
        $this->kiirus = $kiirus;
    }

    public function kiirendus() {
        while ($this->kiirus < 100) {
            echo "Hetke kiirus: " . $this->kiirus . " km/h<br>";
            $this->kiirus += 10;
            if ($this->kiirus >= 100) {
                echo "Kiirus on saavutanud maksimumväärtuse 100 km/h.";
                break;
            }
        }
    }
}

// Loo uus auto objekt
$minu_auto = new Auto();
echo "Uus auto loodud. Värv: " . $minu_auto->värv . ", Tootja: " . $minu_auto->tootja . "<br>";
echo "Alustan kiirendamist...<br>";
$minu_auto->kiirendus();
?>