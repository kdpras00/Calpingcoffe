<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Category;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Truncate Menus Table to start fresh
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Menu::truncate();
        Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Ensure Categories Exist
        $categories = [
            'Signature Coffee' => Category::firstOrCreate(['name' => 'Signature Coffee']),
            'Classic Coffee' => Category::firstOrCreate(['name' => 'Classic Coffee']),
            'Non-Coffee' => Category::firstOrCreate(['name' => 'Non-Coffee']),
            'Main Course' => Category::firstOrCreate(['name' => 'Main Course']),
            'Snacks' => Category::firstOrCreate(['name' => 'Snacks']),
        ];

        $menus = [
            // Signature Coffee
            [
                'category_id' => $categories['Signature Coffee']->id,
                'name' => 'Calping Aren Latte',
                'description' => 'Our signature espresso with premium palm sugar and fresh milk.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 50,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Signature Coffee']->id,
                'name' => 'Creamy Pandan Latte',
                'description' => 'Aromatic pandan infused latte with a creamy texture.',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 45,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Signature Coffee']->id,
                'name' => 'Caramel Macchiato',
                'description' => 'Espresso with vanilla syrup, steamed milk, and caramel drizzle.',
                'price' => 30000,
                'image' => 'https://images.unsplash.com/photo-1599398054066-846f28917f38?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 40,
                'is_available' => true,
            ],

            // Classic Coffee
            [
                'category_id' => $categories['Classic Coffee']->id,
                'name' => 'Caffe Latte',
                'description' => 'Rich espresso with steamed milk and a light layer of foam.',
                'price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1595434091143-b375ced5fe5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 100,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Classic Coffee']->id,
                'name' => 'Cappuccino',
                'description' => 'Espresso with equal parts steamed milk and milk foam.',
                'price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 100,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Classic Coffee']->id,
                'name' => 'Americano',
                'description' => 'Espresso shots topped with hot water.',
                'price' => 18000,
                'image' => 'https://mocktail.net/wp-content/uploads/2022/03/homemade-Iced-Americano-recipe_1.jpg',
                'stock' => 100,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Classic Coffee']->id,
                'name' => 'Espresso',
                'description' => 'A concentrated shot of full-bodied coffee.',
                'price' => 15000,
                'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 100,
                'is_available' => true,
            ],

            // Non-Coffee
            [
                'category_id' => $categories['Non-Coffee']->id,
                'name' => 'Matcha Latte',
                'description' => 'Premium Japanese matcha green tea with steamed milk.',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'stock' => 60,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Non-Coffee']->id,
                'name' => 'Classic Chocolate',
                'description' => 'Rich and creamy chocolate drink, hot or iced.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 70,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Non-Coffee']->id,
                'name' => 'Red Velvet',
                'description' => 'Minuman Red Velvet yang creamy dengan perpaduan rasa cokelat dan vanilla yang mewah.',
                'price' => 26000,
                'image' => 'img/menu/menu3.png',
                'stock' => 50,
                'is_available' => true,
            ],

            // Main Course
            [
                'category_id' => $categories['Main Course']->id,
                'name' => 'Nasi Goreng Special',
                'description' => 'Indonesian fried rice with chicken, egg, and crackers.',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 30,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Main Course']->id,
                'name' => 'Spaghetti Carbonara',
                'description' => 'Creamy pasta with smoked beef and parmesan cheese.',
                'price' => 38000,
                'image' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 25,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Main Course']->id,
                'name' => 'Beef Burger',
                'description' => 'Juicy beef patty with fresh vegetables and cheese.',
                'price' => 45000,
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 20,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Main Course']->id,
                'name' => 'Chicken Katsu Curry',
                'description' => 'Crispy chicken katsu with japanese curry sauce and rice.',
                'price' => 40000,
                'image' => 'https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 25,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Main Course']->id,
                'name' => 'Rice Bowl',
                'description' => 'Porsi nasi hangat dengan topping lezat yang mengenyangkan dan kaya rasa.',
                'price' => 32000,
                'image' => 'img/menu/menu2.png',
                'stock' => 30,
                'is_available' => true,
            ],

            // Snacks
            [
                'category_id' => $categories['Snacks']->id,
                'name' => 'French Fries',
                'description' => 'Crispy golden potato fries.',
                'price' => 20000,
                'image' => 'https://images.unsplash.com/photo-1630384060421-cb20d0e0649d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 80,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Snacks']->id,
                'name' => 'Butter Croissant',
                'description' => 'Flaky and buttery french pastry.',
                'price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 30,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Snacks']->id,
                'name' => 'Churros',
                'description' => 'Fried dough pastry with cinnamon sugar and chocolate dip.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1624371414361-e670edf4898d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 40,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Snacks']->id,
                'name' => 'Mix Platter',
                'description' => 'Combination of fries, nuggets, and sausages.',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'stock' => 20,
                'is_available' => true,
            ],
            [
                'category_id' => $categories['Snacks']->id,
                'name' => 'Cake',
                'description' => 'Kue lembut dengan rasa manis yang pas, sempurna untuk menemani waktu santai Anda.',
                'price' => 25000,
                'image' => 'img/menu/menu1.png',
                'stock' => 20,
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
