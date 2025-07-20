<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use Random\RandomException;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        $products = [
            "Camiseta Básica",
            "Calça Jeans",
            "Tênis Esportivo",
            "Sandália Feminina",
            "Bermuda Masculina",
            "Vestido Floral",
            "Blusa de Frio",
            "Jaqueta Jeans",
            "Camisa Social",
            "Saia Midi",
            "Shorts Jeans",
            "Regata Algodão",
            "Meia Cano Baixo",
            "Boné Aba Curva",
            "Óculos de Sol",
            "Relógio de Pulso",
            "Cinto de Couro",
            "Mochila Escolar",
            "Bolsa Feminina",
            "Carteira Masculina",
            "Chinelo de Dedo",
            "Sapato Social",
            "Tênis Casual",
            "Body Feminino",
            "Macacão Jeans",
            "Legging Fitness",
            "Jaqueta Corta-Vento",
            "Touca de Lã",
            "Luvas Térmicas",
            "Cachecol Xadrez",
            "Pijama Algodão",
            "Cueca Boxer",
            "Sutiã Renda",
            "Calcinha Algodão",
            "Lingerie Conjunto",
            "Tênis Infantil",
            "Sandália Infantil",
            "Camisa Polo",
            "Camiseta Estampada",
            "Calça Legging",
            "Bota Cano Curto",
            "Chapéu Panamá",
            "Blazer Masculino",
            "Blusa Manga Longa",
            "Vestido Longo",
            "Saia Jeans",
            "Shorts de Praia",
            "Maiô Feminino",
            "Biquíni Cortininha",
            "Top Fitness",
            "Calça Jogger",
            "Tênis de Corrida",
            "Tênis Skate",
            "Sapatilha Feminina",
            "Oxford Masculino",
            "Camisa Xadrez",
            "Camisa Listrada",
            "Regata Cavada",
            "Short Saia",
            "Cropped Feminino",
            "Jardineira Jeans",
            "Vestido Tubinho",
            "Blusa de Tricô",
            "Cardigan Feminino",
            "Camisa Regata",
            "Bermuda de Moletom",
            "Moletom Canguru",
            "Tênis Casual Infantil",
            "Tênis com LED",
            "Blusa Ciganinha",
            "Conjunto Moletom",
            "Cueca Slip",
            "Blusa de Seda",
            "Casaco de Lã",
            "Jaqueta de Couro",
            "Sapato de Salto",
            "Tamanco Feminino",
            "Sandália Anabela",
            "Rasteirinha Feminina",
            "Meia Soquete",
            "Meia Calça",
            "Tênis All Star",
            "Camiseta Gola V",
            "Camiseta Gola Alta",
            "Chinelo Slide",
            "Mule Feminino",
            "Sapato Loafer",
            "Colete Jeans",
            "Colete Puffer",
            "Pantufa Pelúcia",
            "Boné Snapback",
            "Tênis Plataforma",
            "Tênis Meia",
            "Tênis Chunky",
            "Tênis Cano Alto",
            "Conjunto Infantil",
            "Vestido Infantil",
            "Calça Sarja",
            "Camiseta Dry Fit",
            "Tênis de Treino",
            "Tênis Running",
            "Sandália Gladiadora",
            "Sapato Derby Masculino"
        ];

        return [
            'name' => $products[random_int(0,99)],
            'description' => $this->faker->sentence(10),
            'code' => strtoupper(Str::random(8)),
            'amount' => $this->faker->randomFloat(2, 10, 150),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $product->variances()->createMany(
                \App\Models\ProductVariance::factory()->count(rand(1, 3))->make()->toArray()
            );
        });
    }
}
