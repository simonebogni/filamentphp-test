<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class QrCode extends Field
{
    protected string $view = 'forms.components.qr-code';
    protected \Closure|int|null $size = null;
    protected \Closure|string|null $imageUrl = '';

    public function size(int | \Closure | null $size): static
    {
        $this->size = $size;
        return $this;

    }

    public function getSize(): ?int
    {
        return $this->evaluate($this->size);

    }

    public function imageUrl(string | \Closure | null $imageUrl): static
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }


}
