<?php

namespace Database\Factories;

use App\Models\CasinoGift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CasinoGiftFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CasinoGift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => self::getRandomName(),
            'amount' => mt_rand(1,10)
        ];
    }

    private function getRandomName ()
    {
        static $names = [
            'POC Obex BC SPIN',
            '1More Stylish',
            'Fellow Carter Mug, 16 oz.',
            'Tern HSD S8i',
            'Tile Sticker',
            'ZSA Planck EZ',
            'One Eleven SWII Solar Three-Hand rPet Watch',
            'Cybex e-Priam',
            'Fujifilm Instax Mini LiPlay',
            'Timbuk2 Tech Tote',
            'IK Multimedia Uno Drum',
            'Industry West 1L Carafe',
            'Anden Cameo Mirror',
            'Roku Smart Soundbar',
            'Civil Doppio 65',
            'Giant Microbes Waterbear',
            'Razer Blade 15',
            'Tecnica Plasma S GTX',
            'Frank DePaula FrankOne Coffee Maker',
            'Form Leather Laptop Case',
            'Nintendo Switch Lite',
            'Sonos Move',
            'DJI Robomaster S1',
            'Denon DP-450USB',
            'Am I Overthinking This?',
            'Sphero Mini Activity Kit',
            'Onewheel Pint',
            'Garmin Fenix 6S Pro',
            'BioLite Headlamp 330',
            'JBL L100 Classic',
            'Master &amp; Dynamic MW65',
            'Sensel Morph With Buchla Thunder Overlay',
            'Craighill Venn Puzzle',
            'Leica Q2',
            'BedJet 3',
            'Yubico YubiKey 5Ci',
            'Vizio P-Series Quantum 4K 65-Inch',
            'Yuki Otoko “Snow Yeti” Sake, 24 oz.',
            'SmartWool  Women\'s Smartloft-X 60 Hoodie Full Zip',
            'Gantri Buddy Light',
            'Google Nest Hub Max',
            'Sandworm',
            'SteelSeries Arctis 1 Wireless',
            'Breville Super Q',
            'OnePlus 7T',
            'Form Swim Goggles (With Display)',
            'Stellar Factory Peek & Push',
            'Raspberry Pi 4',
            'Amazon Kindle',
            'Roka Olso',
            'Black &amp; Decker Furbuster'
        ];
        static $index = 0;

        if (!$index)
            shuffle($names);

        if (++$index >= count($names))
            return Str::random(20);

        return $names[$index];
    }
}
