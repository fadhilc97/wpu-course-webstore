<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ProductForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
          Section::make()->schema([
            TextInput::make('name')->label('Product Name'),
            TextInput::make('sku')->label('SKU')->unique(),
            TextInput::make('slug')->unique(),
            TextInput::make('stock')->numeric()->default(0),
            TextInput::make('price')->numeric()->prefix('Rp'),
            TextInput::make('weight')->numeric()->suffix('gram')
          ])->columnSpanFull()
      ]);
  }
}
