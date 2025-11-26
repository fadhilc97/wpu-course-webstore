<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
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
            SpatieMediaLibraryFileUpload::make('cover')->collection('cover')->disk('public'),
            SpatieMediaLibraryFileUpload::make('gallery')->collection('gallery')->multiple()->disk('public'),
            TextInput::make('name')->label('Product Name'),
            TextInput::make('sku')->label('SKU')->unique(),
            TextInput::make('slug')->unique(),
            SpatieTagsInput::make('tags')->type('collection')->label('Collection'),
            TextInput::make('stock')->numeric()->default(0),
            TextInput::make('price')->numeric()->prefix('Rp'),
            TextInput::make('weight')->numeric()->suffix('gram'),
            MarkdownEditor::make('description')
          ])->columnSpanFull()
      ]);
  }
}
