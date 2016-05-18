<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeDelivery\Models\OrderStatus::class)->create([
            'name' => 'Pendente', 
        ]);

        factory(\CodeDelivery\Models\OrderStatus::class)->create([
            'name' => 'Finalizado', 
        ]);

        factory(\CodeDelivery\Models\OrderStatus::class)->create([
            'name' => 'Cancelado', 
        ]);
    }
}
