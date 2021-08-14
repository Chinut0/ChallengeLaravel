<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name =  $this->faker->randomElement([
            'Mouse 1',
            'Mouse 2',
            'Mouse 3',
            'MousePad 1',
            'MousePad 2',
            'MousePad 3',
            'Soporte',
        ]);

        return [
            'name' => $name,
            'description' => $this->selectData($name)[1],
            // 'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(2000, 4000),
            'status' => $this->faker->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE]),
            'image' => $this->selectData($name)[0],
        ];
    }


    public function selectData($product)
    {
        $attributes = [
            'Mouse 1' => ['1.jpg', 'El sensor HERO de próxima generación del ratón inalámbrico para gaming G305 LIGHTSPEED ofrece un rendimiento de 12.000 dpi'],
            'Mouse 2' => ['2.jpg', 'Mouse de juego Logitech G Series Lightsync G203 negro'],
            'Mouse 3' => ['3.jpg', 'Mouse de juego inalámbrico Logitech  G Series Lightspeed G305 black'],
            'MousePad 1' => ['4.jpg', 'Mouse Pad Gamer Xl 78x25cm Grande Nhp | Rick And Morty 00'],
            'MousePad 2' => ['5.jpg', 'Mousepad Textura Xxl 90x40cm Gammer'],
            'MousePad 3' => ['6.jpg', 'Mousepad Rick & Morty Xxl 90x40cm Gammer L:'],
            'Soporte' => ['7.jpg', 'Pro Desk ® Mesa Portátil Soporte Notebook'],
        ];
        return $attributes[$product];
    }
}
