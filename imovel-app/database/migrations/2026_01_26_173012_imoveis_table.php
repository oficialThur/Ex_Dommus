<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imovels', function (Blueprint $table): void
        {
            $table->id();
            $table->string('descricao', 255);
            $table->decimal('preco', 10, 2);
            $table->enum('disponibilidade', ['DISPONIVEL', 'VENDIDO']);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

        });
    }    

    public function down(): void
    {
        Schema::dropIfExists('imovels');
    }
};
