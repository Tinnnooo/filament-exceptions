<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions\Concerns;

use Closure;

trait HasLabels
{
<<<<<<< HEAD
    protected bool|Closure $isGloballySearchable = true;

    protected string|Closure|null $modelLabel = null;

    protected string|Closure|null $pluralModelLabel = null;

    protected bool|Closure $hasTitleCaseModelLabel = true;

    public function modelLabel(string|Closure|null $label): static
=======
    protected bool | Closure $isGloballySearchable = true;

    protected string | Closure | null $modelLabel = null;

    protected string | Closure | null $pluralModelLabel = null;

    protected bool | Closure $hasTitleCaseModelLabel = true;

    public function modelLabel(string | Closure | null $label): static
>>>>>>> v4
    {
        $this->modelLabel = $label;

        return $this;
    }

<<<<<<< HEAD
    public function pluralModelLabel(string|Closure|null $label): static
=======
    public function pluralModelLabel(string | Closure | null $label): static
>>>>>>> v4
    {
        $this->pluralModelLabel = $label;

        return $this;
    }

<<<<<<< HEAD
    public function titleCaseModelLabel(bool|Closure $condition = true): static
=======
    public function titleCaseModelLabel(bool | Closure $condition = true): static
>>>>>>> v4
    {
        $this->hasTitleCaseModelLabel = $condition;

        return $this;
    }

<<<<<<< HEAD
    public function globallySearchable(bool|Closure $condition = true): static
=======
    public function globallySearchable(bool | Closure $condition = true): static
>>>>>>> v4
    {
        $this->isGloballySearchable = $condition;

        return $this;
    }

    public function getModelLabel(): string
    {
        return $this->evaluate($this->modelLabel ?? __('filament-exceptions::filament-exceptions.labels.model'));
    }

    public function getPluralModelLabel(): string
    {
        return $this->evaluate($this->pluralModelLabel ?? __('filament-exceptions::filament-exceptions.labels.model_plural'));
    }

    public function hasTitleCaseModelLabel(): bool
    {
        return $this->evaluate($this->hasTitleCaseModelLabel);
    }

    public function canGloballySearch(): bool
    {
        return $this->evaluate($this->isGloballySearchable);
    }
}
