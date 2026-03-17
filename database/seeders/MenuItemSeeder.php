<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        MenuItem::insert([
            ['name' => '1, Pizza Margherita 32cm', 'description' => '450g, paradajkový základ, syr', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '2, Pizza Šunková 32cm', 'description' => '500g, paradajkový základ, syr, šunka', 'price' => 6.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '3, Pizza Salámová 32cm', 'description' => '500g, paradajkový základ, syr, saláma', 'price' => 6.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '4, Pizza Prosciutto funghi 32cm', 'description' => 'paradajkový základ, syr, šunka, šampiňóny', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '5, Pizza Funghi 32cm', 'description' => 'paradajkový základ, syr, šampiňóny', 'price' => 6.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '6, Pizza Vegi 32cm', 'description' => 'paradajkový základ, syr, cuketa, olivy, paradajky, kukurica, rukola', 'price' => 7.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '7, Pizza Pizza Quattro formaggi 32cm', 'description' => 'paradajkový základ, syr, syr Niva, syr Encián, údený syr', 'price' => 7.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '8, Pizza Tonno 32cm', 'description' => '550g, paradajkový základ, syr, tuniak, cibuľa, paprika', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza, Ryby', 'type' => 'Pizza malá'],
            ['name' => '9, Pizza Hawaii 32cm', 'description' => 'paradajkový základ, syr, šunka, ananás', 'price' => 7.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],
            ['name' => '10, Pizza American 32cm', 'description' => '600g, paradajkový základ, syr, šunka, saláma', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza malá'],

            ['name' => '1, Pizza Margherita 50cm', 'description' => 'paradajkový základ, syr', 'price' => 11.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '2, Pizza Šunková 50cm', 'description' => 'paradajkový základ, syr, šunka', 'price' => 12.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '3, Pizza Salámová 50cm', 'description' => 'paradajkový základ, syr, saláma', 'price' => 12.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '4, Pizza Prosciutto funghi 50cm', 'description' => 'paradajkový základ, syr, šunka, šampiňóny', 'price' => 13.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '5, Pizza Funghi 50cm', 'description' => 'paradajkový základ, syr, šampiňóny', 'price' => 12.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '6, Pizza Vegi 50cm', 'description' => 'paradajkový základ, syr, cuketa, olivy, paradajky, kukurica, rukola', 'price' => 13.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '7, Pizza Quattro formaggi 50cm', 'description' => 'paradajkový základ, syr, syr Niva, syr Encián, údený syr', 'price' => 14.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '8, Pizza Tonno 50cm', 'description' => 'paradajkový základ, syr, tuniak, cibuľa, paprika', 'price' => 14.00, 'alergens'=>'Glutén, Laktóza, Ryby', 'type' => 'Pizza veľká'],
            ['name' => '9, Pizza Hawaii 50cm', 'description' => 'paradajkový základ, syr, šunka, ananás', 'price' => 14.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],
            ['name' => '10, Pizza American 50cm', 'description' => 'paradajkový základ, syr, šunka, saláma', 'price' => 14.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza veľká'],

            ['name' => '11, Pizza Romana 32cm', 'description' => '600g, paradajkový základ, šunka, kukurica, šampiňóny', 'price' => 7.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '12, Pizza Quattro Stagioni 32cm', 'description' => '600g, paradajkový základ, syr, šunka, olivy, šampiňóny, paradajky', 'price' => 7.80, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '13, Pizza Verolaska srdce 32cm', 'description' => 'paradajkový základ, syr, šunka, syr Niva, cherry paradajky, paprika', 'price' => 8.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '14, Pizza Vajce 32cm', 'description' => 'paradajkový základ, syr, vajce s mix ciao bella', 'price' => 7.70, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '15, Pizza Diavola 32cm', 'description' => '550g, paradajkový základ, syr, pikantná saláma, klobása, feferóny', 'price' => 7.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '16, Pizza Gazdovská 32cm', 'description' => 'paradajkový základ, syr, slanina, klobása, cibuľa, feferóny', 'price' => 7.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '17, Pizza Prosciutto crudo 32cm', 'description' => 'paradajkový základ, syr, sušená šunka, rukola', 'price' => 8.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '18, Pizza Tvoja 32cm', 'description' => 'paradajkový základ, syr, 4 suroviny na výber', 'price' => 8.00, 'alergens'=>'Glutén, Ryby, Bôby, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '19, Pizza Bryndzova 32cm', 'description' => 'smotanový základ, syr, brokolica, kuracie mäso, bryndza', 'price' => 8.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],
            ['name' => '20, Pizza Bonavita 32cm', 'description' => 'smotanový základ, syr, slanina, cibuľa, bryndza, pažítka', 'price' => 7.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza malá'],

            ['name' => '11, Pizza Romana 50cm', 'description' => 'paradajkový základ, šunka, kukurica, šampiňóny', 'price' => 15.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '12, Pizza Quattro Stagioni 50cm', 'description' => 'paradajkový základ, syr, šunka, olivy, šampiňóny, paradajky', 'price' => 15.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '13, Pizza Verolaska srdce 50cm', 'description' => 'paradajkový základ, syr, šunka, syr Niva, cherry paradajky, paprika', 'price' => 15.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '14, Pizza Vajce 50cm', 'description' => 'paradajkový základ, syr, vajce s mix ciao bella', 'price' => 15.00, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '15, Pizza Diavola 50cm', 'description' => 'paradajkový základ, syr, pikantná saláma, klobása, feferóny', 'price' => 15.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '16, Pizza Gazdovská 50cm', 'description' => 'paradajkový základ, syr, slanina, klobása, cibuľa, feferóny', 'price' => 15.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '17, Pizza Prosciutto crudo 50cm', 'description' => 'paradajkový základ, syr, sušená šunka, rukola', 'price' => 15.80, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '18, Pizza Tvoja 50cm', 'description' => 'paradajkový základ, syr, 4 suroviny na výber', 'price' => 15.50, 'alergens'=>'Glutén, Ryby, Bôby, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '19, Pizza Bryndzova 50cm', 'description' => 'smotanový základ, syr, brokolica, kuracie mäso, bryndza', 'price' => 16.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],
            ['name' => '20, Pizza Bonavita 50cm', 'description' => 'smotanový základ, syr, slanina, cibuľa, bryndza, pažítka', 'price' => 16.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Super pizza veľká'],

            ['name' => '21, Pizza Kuracia 32cm', 'description' => 'paradajkový základ, syr, kuracie mäso, syr Niva, kukurica, paprika', 'price' => 8.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '22, Pizza Mix Cana 32cm', 'description' => 'paradajkový základ, syr, mäso beef, fazuľa, baranie rohy, paprika, syr Parmezán', 'price' => 9.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '23, Pizza Ciao bella 32cm', 'description' => 'paradajkový základ, syr, šampiňóny, olivy, cherry paradajky, sušená šunka, rukola, syr Parmezán', 'price' => 9.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '24, Pizza Beef exclusive 32cm', 'description' => '600g, paradajkový základ, syr, mäso beef, syr Cheddar, cibuľa, vajce', 'price' => 9.20, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '25, Pizza Jalapeňos 32cm', 'description' => 'paradajkový základ, syr, slanina, klobása, syr Niva, jalapeňos, fazuľa', 'price' => 8.70, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '26, Pizza Salmone 32cm', 'description' => 'paradajkový základ, syr, údený losos 110g, rukola, citrón', 'price' => 8.70, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '27, Pizza Dary mora 32cm', 'description' => 'paradajkový základ, syr, dary mora, cesnak', 'price' => 9.00, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '28, Pizza Kreveta 32cm', 'description' => '600g, paradajkový základ, syr, krevety, rukola, syr Parmezán', 'price' => 9.20, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '29, Pizza Bravčova 32cm', 'description' => 'paradajkový základ, syr, gyros, sušené paradajky, cibuľa', 'price' => 9.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza malá'],
            ['name' => '30, Pizza Pancetta 32cm', 'description' => 'paradajkový základ, syr, Gorgonzola syr, talianska pancetta, jarná cibuľka', 'price' => 9.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza malá'],

            ['name' => '21, Pizza Kuracia 32cm', 'description' => 'paradajkový základ, syr, kuracie mäso, syr Niva, kukurica, paprika', 'price' => 16.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '22, Pizza Mix Cana 32cm', 'description' => 'paradajkový základ, syr, mäso beef, fazuľa, baranie rohy, paprika, syr Parmezán', 'price' => 17.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '23, Pizza Ciao bella 32cm', 'description' => 'paradajkový základ, syr, šampiňóny, olivy, cherry paradajky, sušená šunka, rukola, syr Parmezán', 'price' => 17.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '24, Pizza Beef exclusive 32cm', 'description' => 'paradajkový základ, syr, mäso beef, syr Cheddar, cibuľa, vajce', 'price' => 18.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '25, Pizza Jalapeňos 32cm', 'description' => 'paradajkový základ, syr, slanina, klobása, syr Niva, jalapeňos, fazuľa', 'price' => 16.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '26, Pizza Salmone 32cm', 'description' => 'paradajkový základ, syr, údený losos 110g, rukola, citrón', 'price' => 17.00, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '27, Pizza Dary mora 32cm', 'description' => 'paradajkový základ, syr, dary mora, cesnak', 'price' => 18.50, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '28, Pizza Kreveta 32cm', 'description' => 'paradajkový základ, syr, krevety, rukola, syr Parmezán', 'price' => 18.00, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '29, Pizza Bravčova 32cm', 'description' => 'paradajkový základ, syr, gyros, sušené paradajky, cibuľa', 'price' => 17.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza veľká'],
            ['name' => '30, Pizza Pancetta 32cm', 'description' => 'paradajkový základ, syr, Gorgonzola syr, talianska pancetta, jarná cibuľka', 'price' => 17.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Exclusive pizza veľká'],

            ['name' => '1, Nivový posúch 32cm', 'description' => 'syr Mozzarella, syr Niva', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch malý'],
            ['name' => '2, Salámový posúch 32cm', 'description' => 'syr Mozzarella, saláma', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch malý'],
            ['name' => '3, Slaninový posúch 32cm', 'description' => 'syr Mozzarella, slanina', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch malý'],
            ['name' => '4, Klobásový posúch 32cm', 'description' => 'syr Mozzarella, klobása', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch malý'],
            ['name' => '5, Kebab posúch 32cm', 'description' => 'syr Mozzarella, kebab mäso', 'price' => 6.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch malý'],

            ['name' => '1, Nivový posúch 50cm', 'description' => 'syr Mozzarella, syr Niva', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch veľký'],
            ['name' => '2, Salámový posúch 50cm', 'description' => 'syr Mozzarella, saláma', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch veľký'],
            ['name' => '3, Slaninový posúch 50cm', 'description' => 'syr Mozzarella, slanina', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch veľký'],
            ['name' => '4, Klobásový posúch 50cm', 'description' => 'syr Mozzarella, klobása', 'price' => 6.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch veľký'],
            ['name' => '5, Kebab posúch 50cm', 'description' => 'syr Mozzarella, kebab mäso', 'price' => 6.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza posúch veľký'],

            ['name' => '6, Pizza štangle', 'description' => '280g, cesnakový dresing, oregano', 'price' => 4.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza štangle'],
            ['name' => '7, Pizza štangle s rozmarínom', 'description' => '300g, s cesnakom, omáčkou a paradajkami', 'price' => 5.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza štangle'],

            ['name' => '8, Di pollo pizza roll', 'description' => '500g, syr, kuracie mäso, brokolica, syr Niva', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza roll'],
            ['name' => '9, Di speck pizza roll', 'description' => '500g, slanina, syr Encián, šampiňóny', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza roll'],
            ['name' => '10, Duo Janka pizza roll', 'description' => '500g, šunka, saláma, kukurica', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza roll'],
            ['name' => '11, Vero vegi pizza roll', 'description' => '550g, syr, kukurica, brokolica, cibuľa, olivy, paprika', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza roll'],
            ['name' => '12, Galzona', 'description' => '600g, pomodoro, syr, šunka, šampiňóny, olivy, kukurica', 'price' => 7.00, 'alergens'=>'Glutén, Laktóza', 'type' => 'Pizza roll'],

            ['name' => '1, Klasik burger', 'description' => '400g, 100% hovädzie mäso, tatárska omáčka, cocktail omáčka, zeleninová obloha', 'price' => 7.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sója', 'type' => 'Burger'],
            ['name' => '2, Texas burge', 'description' => '450g, 100% hovädzie mäso, tatárska omáčka, cocktail omáčka, slanina, syr Cheddar, vajce, zeleninová obloha', 'price' => 8.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sója', 'type' => 'Burger'],
            ['name' => '3, California burger', 'description' => '450g, kuracie prsia, tatárska omáčka, cocktail omáčka, syr Cheddar, slanina, zeleninová obloha', 'price' => 8.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '4, Cheese burger', 'description' => '400g, vyprážaný syr Hermelín, tatárska omáčka, brusnice, zeleninová obloha', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '5, Veggie burger', 'description' => '400g, placka, zelenina, tatárska omáčka, cocktail omáčka, zeleninová obloha', 'price' => 7.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '6, Arnoldo burger', 'description' => '450g, 100% hovädzie mäso, syr Cheddar, slanina, tatárska omáčka, BBQ, ľadový šalát, zeleninova obloha, karamelová cibuľa', 'price' => 9.50, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '7, Crispy Martin', 'description' => '450g, vyprážaná kuracia placka, syr Cheddar, cocktail omáčka, BBQ, ľadový šalát, zeleninova obloha karamelová cibuľa', 'price' => 8.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '8, Hot Anglina', 'description' => '450g, 100% hovädzie mäso, jalapeňo, syr Cheddar, rukola, cocktail omáčka, sweet chilli, zeleninova obloha, karamelová cibuľa', 'price' => 9.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '9, Johnny dip', 'description' => '450g, 100% hovädzie mäso s syr, tatárska omáčka, cocktail omáčka, slanina, ananás, ľadový šalát, zeleninova obloha, , karamelová cibuľa', 'price' => 9.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],
            ['name' => '10, Black devil', 'description' => '450g, 100% hovädzie mäso, slanina, cibuľové krúžky, cocktail omáčka, sweet chilli, ľadový šalát, zeleninova obloha, karamelová cibuľa', 'price' => 9.00, 'alergens'=>'Glutén, Vajcia, Laktóza, Sezam', 'type' => 'Burger'],

            ['name' => '1, Špagety Carbonara', 'description' => '350g, špagety, smotana, slanina, vajce, syr Parmezán', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Cestoviny'],
            ['name' => '2, Špagety Aglio Oglio', 'description' => '250g, špagety, cesnak, olivový olej, chilli, syr Parmezán, petržlenová vňať', 'price' => 6.30, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Cestoviny'],
            ['name' => '3, Pasta Simka', 'description' => '400g, penne, smotana, kuracie mäso, brokolica, cibuľa, syr Parmezán', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Cestoviny'],
            ['name' => '4, Penne Bella Feta', 'description' => '350g, Feta syr, cherry paradajky, cesnak, čerstvé oregano, rukola', 'price' => 6.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Cestoviny'],
            ['name' => '5, Penne Bolognese', 'description' => '350g, penne, paradajková omáčka, hovädzie mäso, syr Parmezán', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Cestoviny'],

            ['name' => '1, Selim basha', 'description' => '400g, rizoto s kari, kuracie mäso, syr Parmezán, hrozienka', 'price' => 7.30, 'alergens'=>'Glutén, Laktóza', 'type' => 'Rizoto'],
            ['name' => '2, Ciao bella', 'description' => '400g, rizoto s BBQ, krevety, syr Parmezán, arašídy', 'price' => 7.50, 'alergens'=>'Glutén, Ryby, Laktóza', 'type' => 'Rizoto'],
            ['name' => '3, Nakshi rizoto', 'description' => '400g, zeleninové soté, syr Parmezán, rukola', 'price' => 6.80, 'alergens'=>'Glutén, Laktóza', 'type' => 'Rizoto'],
            ['name' => '4, Cuketové rizoto', 'description' => '400g, cuketa, kuracie mäso, syr Parmezán', 'price' => 7.30, 'alergens'=>'Glutén, Laktóza', 'type' => 'Rizoto'],
            ['name' => '5, Cviklové rizoto', 'description' => '400g, cvikla, balkánsky syr, špenát', 'price' => 7.30, 'alergens'=>'Glutén, Laktóza', 'type' => 'Rizoto'],

            ['name' => 'Slepačí vývar', 'description' => '0,33l, 2ks pizza štangle', 'price' => 2.90, 'alergens'=>'Glutén, Laktóza', 'type' => 'Polievky'],
            ['name' => 'Cesnaková polievka', 'description' => '0,33l, 2ks pizza štangle', 'price' => 2.90, 'alergens'=>'Glutén, Laktóza', 'type' => 'Polievky'],
            ['name' => 'Pomodoro polievka', 'description' => '0,33l, 2ks pizza štangle', 'price' => 3.20, 'alergens'=>'Glutén, Laktóza', 'type' => 'Polievky'],

            ['name' => '1, Cézar šalát', 'description' => '400g, kuracie mäso, slanina, krutóny, ľadový šalát, syr Parmezán, dressing', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Šaláty'],
            ['name' => '2, Grécky šalát', 'description' => '400g, paradajky uhorka, paprika, ľadový šalát, cibuľa, olivy, balkánsky syr, olivový olej, oregano', 'price' => 6.80, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Šaláty'],
            ['name' => '3, Ciao bella šalát', 'description' => '400g, paradajky, uhorka, olivy, paprika, kuracie mäso, ananás, cesnakový dresing, syr Parmezán', 'price' => 7.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Šaláty'],
            ['name' => '4, Grilovaný syr Hermelín', 'description' => '120g, s brusnicovým gélom', 'price' => 6.50, 'alergens'=>'Glutén, Laktóza', 'type' => 'Šaláty'],

            ['name' => '1, Fish and chips', 'description' => '400g, ryba, tatárska omáčka, citrón, hranolky, 2 ks štangle', 'price' => 7.50,  'alergens'=>'Glutén, Ryby, Vajcia, Laktóza', 'type' => 'Ciao snack'],
            ['name' => '2, Chicken wings', 'description' => '6 kúskov BBQ kuracieho mäsa, hranolky, coleslaw šalát', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Ciao snack'],
            ['name' => '3, Cibuľové krúžky', 'description' => '5ks, cibuľové krúžky, coleslaw, sweet potato', 'price' => 6.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Ciao snack'],
            ['name' => '4, Kuracie nugetky', 'description' => '150g, kuracie mäso, hranolky, kečup', 'price' => 6.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Ciao snack'],
            ['name' => '6, Pečené bravčové rebrá', 'description' => '500g, uhorky, feferóny, baranie rohy, horčica, chren, štangle', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia', 'type' => 'Ciao snack'],
            ['name' => '7, Kurací cordon bleu', 'description' => '300g, kurací rezeň plnený šunkou a syrom, hranolky, Cheddarová omáčka', 'price' => 7.50, 'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Ciao snack'],
            ['name' => '8, Vyprážaný karfiol a mozzarella steak', 'description' => '400g', 'price' => 6.50,  'alergens'=>'Laktóza', 'type' => 'Ciao snack'],
            ['name' => '9, Párty box', 'description' => '2800g, pečené rebrá, 400g kuracie nugetky, 400g kuracie v BBQ omáčke, 200g cibuľové krúžky, 200g hranolky, 200g sweet potato, 250g štangle, 500 grilovaná kukurica, 400g grilovaná zelenina, 3ks omáčka - BBQ, tatárska omáčka, kečup', 'price' => 35.00,  'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Ciao snack'],

            ['name' => '1, Palacinky s nutelou a šľahačkou', 'description' => '260g', 'price' => 5.00,  'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Dezerty'],
            ['name' => '2, Palacinky s džemom a šľahačkou', 'description' => '260g', 'price' => 5.00,  'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Dezerty'],
            ['name' => '3, Palacinky Biscoff Lotus so šľahačkou', 'description' => '260g', 'price' => 5.00,  'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Dezerty'],
            // ['name' => '5, Baklava', 'description' => '1ks', 'price' => 1.20,  'alergens'=>'Glutén, Laktóza', 'type' => 'Dezerty'],
            ['name' => '6, Lávový koláčik', 'description' => '110g', 'price' => 2.80,  'alergens'=>'Glutén, Vajcia, Laktóza', 'type' => 'Dezerty'],

            ['name' => 'Kofola originál', 'description' => '0,25l', 'price' => 1.70, 'alergens'=>'', 'type' => 'Nápoje'],
            ['name' => 'Vinea biela', 'description' => '0,5l', 'price' => 1.90, 'alergens'=>'', 'type' => 'Nápoje'],
            ['name' => 'Vinea červená', 'description' => '0,25l', 'price' => 1.90, 'alergens'=>'', 'type' => 'Nápoje'],
            ['name' => 'Red bull', 'description' => '0,25l', 'price' => 3.00, 'alergens'=>'', 'type' => 'Nápoje'],
            ['name' => 'Birell', 'description' => '0,5l', 'price' => 1.80, 'alergens'=>'', 'type' => 'Nápoje'],
            ['name' => 'Pivo', 'description' => '0,5l', 'price' => 2.00, 'alergens'=>'', 'type' => 'Nápoje'],
            ['name' => 'Hamsik winery víno', 'description' => '', 'price' => 12.00, 'alergens'=>'', 'type' => 'Nápoje'],

            ['name' => 'Cesnakový dresing', 'description' => '', 'price' => 1.30, 'alergens'=>'', 'type' => 'Omáčky'],
            ['name' => 'Pesto', 'description' => '', 'price' => 1.30, 'alergens'=>'', 'type' => 'Omáčky'],
            ['name' => 'Sweet chilli', 'description' => '', 'price' => 1.30, 'alergens'=>'', 'type' => 'Omáčky'],
            ['name' => 'Tzatziki', 'description' => '', 'price' => 1.30, 'alergens'=>'', 'type' => 'Omáčky'],
            ['name' => 'BBQ', 'description' => '', 'price' => 1.60, 'alergens'=>'', 'type' => 'Omáčky'],
            ['name' => 'Kečup', 'description' => '', 'price' => 0.90, 'alergens'=>'', 'type' => 'Omáčky'],
            ['name' => 'Tatarská omáčka', 'description' => '', 'price' => 0.90, 'alergens'=>'', 'type' => 'Omáčky'],
        ]);
    }
}
