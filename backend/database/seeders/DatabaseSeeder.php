<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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

        $productImages = [
            // Sofá Milano Premium
            1 => [
                ['path' => 'https://img.freepik.com/free-photo/modern-luxury-domestic-room-with-comfortable-sofa-design-generated-by-ai_188544-40158.jpg?w=1380', 'alt_text' => 'Sofá Milano Premium - Vista frontal', 'is_primary' => true, 'sort_order' => 1],
                ['path' => 'https://img.freepik.com/free-photo/interior-design-with-photoframes-sofa_23-2149385437.jpg?w=1380', 'alt_text' => 'Sofá Milano Premium - Ambiente', 'is_primary' => false, 'sort_order' => 2],
                ['path' => 'https://img.freepik.com/free-photo/3d-rendering-loft-luxury-living-room-with-bookshelf-near-bookshelf_105762-2175.jpg?w=1380', 'alt_text' => 'Sofá Milano Premium - Detalhe', 'is_primary' => false, 'sort_order' => 3],
            ],
            // Poltrona Versailles
            2 => [
                ['path' => 'https://img.freepik.com/free-photo/interior-design-with-armchair-plant_23-2149385449.jpg?w=1380', 'alt_text' => 'Poltrona Versailles - Vista frontal', 'is_primary' => true, 'sort_order' => 1],
                ['path' => 'https://img.freepik.com/free-photo/scandinavian-living-room-interior-design-zoom-background_53876-143147.jpg?w=1380', 'alt_text' => 'Poltrona Versailles - Ambiente', 'is_primary' => false, 'sort_order' => 2],
            ],
            // Mesa de Jantar Carrara
            3 => [
                ['path' => 'https://img.freepik.com/free-photo/dining-table-house_1203-1914.jpg?w=1380', 'alt_text' => 'Mesa de Jantar Carrara - Vista superior', 'is_primary' => true, 'sort_order' => 1],
                ['path' => 'https://img.freepik.com/free-photo/stylish-dining-room-interior-design_23-2151934545.jpg?w=1380', 'alt_text' => 'Mesa de Jantar Carrara - Ambiente', 'is_primary' => false, 'sort_order' => 2],
                ['path' => 'https://img.freepik.com/free-photo/luxury-dining-room-with-golden-table-marble-floor_1258-177693.jpg?w=1380', 'alt_text' => 'Mesa de Jantar Carrara - Detalhe mármore', 'is_primary' => false, 'sort_order' => 3],
            ],
            // Candeeiro Cascata Dourado
            4 => [
                ['path' => 'https://img.freepik.com/free-photo/luxury-chandelier-illuminated-modern-home-interior-generated-by-ai_188544-42474.jpg?w=1380', 'alt_text' => 'Candeeiro Cascata Dourado - Vista geral', 'is_primary' => true, 'sort_order' => 1],
                ['path' => 'https://img.freepik.com/free-photo/golden-luxury-chandelier-vintage-style_181624-41169.jpg?w=1380', 'alt_text' => 'Candeeiro Cascata Dourado - Detalhe cristais', 'is_primary' => false, 'sort_order' => 2],
            ],
            // Espelho Art Deco Grand
            5 => [
                ['path' => 'https://img.freepik.com/free-photo/decorative-mirror-with-round-shape_23-2149872019.jpg?w=1380', 'alt_text' => 'Espelho Art Deco Grand - Vista frontal', 'is_primary' => true, 'sort_order' => 1],
                ['path' => 'https://img.freepik.com/free-photo/design-interior-with-frames-mirror_23-2149385466.jpg?w=1380', 'alt_text' => 'Espelho Art Deco Grand - No ambiente', 'is_primary' => false, 'sort_order' => 2],
            ],
            // Cama King Royal
            6 => [
                ['path' => 'https://img.freepik.com/free-photo/3d-rendering-beautiful-luxury-bedroom-suite-hotel-with-tv_105762-2167.jpg?w=1380', 'alt_text' => 'Cama King Royal - Vista geral', 'is_primary' => true, 'sort_order' => 1],
                ['path' => 'https://img.freepik.com/free-photo/luxury-bedroom-hotel_1150-10836.jpg?w=1380', 'alt_text' => 'Cama King Royal - Ambiente quarto', 'is_primary' => false, 'sort_order' => 2],
                ['path' => 'https://img.freepik.com/free-photo/interior-modern-comfortable-hotel-room_1232-1822.jpg?w=1380', 'alt_text' => 'Cama King Royal - Detalhe cabeceira', 'is_primary' => false, 'sort_order' => 3],
            ],
        ];

        foreach ($products as $index => $prod) {
            $product = Product::create($prod);

            if (isset($productImages[$index + 1])) {
                foreach ($productImages[$index + 1] as $imageData) {
                    $product->images()->create($imageData);
                }
            }
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
