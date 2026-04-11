<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Faustino',
            'email' => 'admin@antonioaugustahome.pt',
            'password' => 'password',
        ]);

        // Categories
        $categories = [
            ['name' => 'Sofás & Poltronas', 'description' => 'Conforto e elegância para a sua sala de estar', 'sort_order' => 1],
            ['name' => 'Mesas & Secretárias', 'description' => 'Peças de design para refeições e trabalho', 'sort_order' => 2],
            ['name' => 'Iluminação', 'description' => 'Candeeiros e luminárias de design', 'sort_order' => 3],
            ['name' => 'Decoração', 'description' => 'Acessórios decorativos premium', 'sort_order' => 4],
            ['name' => 'Quartos', 'description' => 'Mobiliário de quarto sofisticado', 'sort_order' => 5],
            ['name' => 'Exterior', 'description' => 'Mobiliário de exterior de luxo', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Sample Products
        $products = [
            ['name' => 'Sofá Milano Premium', 'short_description' => 'Elegância italiana em puro couro natural', 'description' => 'O Sofá Milano Premium é uma peça de design italiano que combina conforto supremo com linhas elegantes. Fabricado em couro natural de primeira qualidade, este sofá é o centro de qualquer sala de estar sofisticada.', 'price' => 4890.00, 'category_id' => 1, 'is_featured' => true, 'materials' => 'Couro Natural, Madeira de Carvalho', 'dimensions' => '240 x 95 x 82 cm'],
            ['name' => 'Poltrona Versailles', 'short_description' => 'Inspiração clássica, conforto contemporâneo', 'description' => 'A Poltrona Versailles reinventa o clássico com materiais contemporâneos. Estrutura em madeira de nogueira com estofamento em veludo premium.', 'price' => 1890.00, 'category_id' => 1, 'is_featured' => true, 'materials' => 'Veludo, Madeira de Nogueira', 'dimensions' => '78 x 82 x 95 cm'],
            ['name' => 'Mesa de Jantar Carrara', 'short_description' => 'Mármore italiano e design atemporal', 'description' => 'Mesa de jantar com tampo em mármore Carrara genuíno e base em aço escovado. Uma peça que transforma qualquer refeição num momento especial.', 'price' => 6490.00, 'category_id' => 2, 'is_featured' => true, 'materials' => 'Mármore Carrara, Aço Escovado', 'dimensions' => '220 x 100 x 76 cm'],
            ['name' => 'Candeeiro Cascata Dourado', 'short_description' => 'Luz que inspira', 'description' => 'Candeeiro de teto com acabamento dourado e cascata de cristais. Peça statement para halls de entrada e salas de jantar.', 'price' => 2290.00, 'category_id' => 3, 'is_featured' => true, 'materials' => 'Latão Dourado, Cristal', 'dimensions' => 'Ø60 x 80 cm'],
            ['name' => 'Espelho Art Deco Grand', 'short_description' => 'Reflexo de bom gosto', 'description' => 'Espelho decorativo inspirado no estilo Art Deco, com moldura em madeira lacada dourada. Perfeito para halls e salas de estar.', 'price' => 890.00, 'category_id' => 4, 'is_featured' => false, 'materials' => 'Madeira Lacada, Espelho Biselado', 'dimensions' => '120 x 80 cm'],
            ['name' => 'Cama King Royal', 'short_description' => 'Noites de realeza', 'description' => 'Cama king-size com cabeceira estofada em tecido premium. Design contemporâneo com acabamentos de luxo.', 'price' => 3890.00, 'category_id' => 5, 'is_featured' => true, 'materials' => 'Tecido Bouclé, Madeira de Freixo', 'dimensions' => '200 x 200 x 130 cm'],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // Sample Projects
        $projects = [
            ['title' => 'Penthouse Vista Mar', 'description' => 'Projeto completo de decoração para penthouse de 300m² com vista oceano. Tons neutros, materiais nobres e peças exclusivas criam um ambiente de serenidade luxuosa.', 'location' => 'Luanda, Angola', 'is_featured' => true, 'completed_at' => '2024-06-15'],
            ['title' => 'Villa Contemporânea', 'description' => 'Decoração integral de villa moderna no Algarve. Fusão perfeita entre interior e exterior, com materiais naturais e design biofílico.', 'location' => 'Algarve, Angola', 'is_featured' => true, 'completed_at' => '2024-03-20'],
            ['title' => 'Apartamento Chiado', 'description' => 'Renovação e decoração de apartamento histórico no coração de Luanda. Respeito pela arquitetura original com toques de modernidade.', 'location' => 'Luanda, Angola', 'is_featured' => true, 'completed_at' => '2024-01-10'],
        ];

        foreach ($projects as $proj) {
            Project::create($proj);
        }
    }
}
