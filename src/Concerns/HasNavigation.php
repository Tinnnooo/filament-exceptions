<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions\Concerns;

use Closure;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;

trait HasNavigation
{
    /** @var class-string<Cluster> | Closure | null */
<<<<<<< HEAD
    protected string|Closure|null $cluster = null;

    protected bool|Closure $shouldEnableNavigationBadge = false;

    protected string|array|Closure|null $navigationBadgeColor = null;

    protected string|Closure|null $navigationGroup = null;

    protected string|Closure|null $navigationParentItem = null;

    protected string|Closure|null $navigationIcon = null;

    protected string|Closure|null $activeNavigationIcon = null;

    protected string|Closure|null $navigationLabel = null;

    protected int|Closure|null $navigationSort = null;

    protected string|Closure|null $slug = null;

    protected bool|Closure $shouldRegisterNavigation = true;

    protected SubNavigationPosition|Closure $subNavigationPosition = SubNavigationPosition::Start;

    // Setters
    public function cluster(string|Closure|null $cluster): static
=======
    protected string | Closure | null $cluster = null;

    protected bool | Closure $shouldEnableNavigationBadge = false;

    protected string | array | Closure | null $navigationBadgeColor = null;

    protected string | Closure | null $navigationGroup = null;

    protected string | Closure | null $navigationParentItem = null;

    protected string | Closure | null $navigationIcon = null;

    protected string | Closure | null $activeNavigationIcon = null;

    protected string | Closure | null $navigationLabel = null;

    protected int | Closure | null $navigationSort = null;

    protected string | Closure | null $slug = null;

    protected bool | Closure $shouldRegisterNavigation = true;

    protected SubNavigationPosition | Closure $subNavigationPosition = SubNavigationPosition::Start;

    // Setters
    public function cluster(string | Closure | null $cluster): static
>>>>>>> v4
    {
        $this->cluster = $cluster;

        return $this;
    }

<<<<<<< HEAD
    public function navigationBadge(bool|Closure $condition = true): static
=======
    public function navigationBadge(bool | Closure $condition = true): static
>>>>>>> v4
    {
        $this->shouldEnableNavigationBadge = $condition;

        return $this;
    }

<<<<<<< HEAD
    public function navigationBadgeColor(string|array|Closure $color): static
=======
    public function navigationBadgeColor(string | array | Closure $color): static
>>>>>>> v4
    {
        $this->navigationBadgeColor = $color;

        return $this;
    }

<<<<<<< HEAD
    public function navigationGroup(string|Closure|null $group): static
=======
    public function navigationGroup(string | Closure | null $group): static
>>>>>>> v4
    {
        $this->navigationGroup = $group;

        return $this;
    }

<<<<<<< HEAD
    public function navigationParentItem(string|Closure|null $item): static
=======
    public function navigationParentItem(string | Closure | null $item): static
>>>>>>> v4
    {
        $this->navigationParentItem = $item;

        return $this;
    }

<<<<<<< HEAD
    public function navigationIcon(string|Closure|null $icon): static
=======
    public function navigationIcon(string | Closure | null $icon): static
>>>>>>> v4
    {
        $this->navigationIcon = $icon;

        return $this;
    }

<<<<<<< HEAD
    public function activeNavigationIcon(string|Closure|null $icon): static
=======
    public function activeNavigationIcon(string | Closure | null $icon): static
>>>>>>> v4
    {
        $this->activeNavigationIcon = $icon;

        return $this;
    }

<<<<<<< HEAD
    public function navigationLabel(string|Closure|null $label): static
=======
    public function navigationLabel(string | Closure | null $label): static
>>>>>>> v4
    {
        $this->navigationLabel = $label;

        return $this;
    }

<<<<<<< HEAD
    public function navigationSort(int|Closure|null $sort): static
=======
    public function navigationSort(int | Closure | null $sort): static
>>>>>>> v4
    {
        $this->navigationSort = $sort;

        return $this;
    }

<<<<<<< HEAD
    public function slug(string|Closure|null $slug): static
=======
    public function slug(string | Closure | null $slug): static
>>>>>>> v4
    {
        $this->slug = $slug;

        return $this;
    }

<<<<<<< HEAD
    public function registerNavigation(bool|Closure $shouldRegisterNavigation): static
=======
    public function registerNavigation(bool | Closure $shouldRegisterNavigation): static
>>>>>>> v4
    {
        $this->shouldRegisterNavigation = $shouldRegisterNavigation;

        return $this;
    }

<<<<<<< HEAD
    public function subNavigationPosition(SubNavigationPosition|Closure $subNavigationPosition): static
=======
    public function subNavigationPosition(SubNavigationPosition | Closure $subNavigationPosition): static
>>>>>>> v4
    {
        $this->subNavigationPosition = $subNavigationPosition;

        return $this;
    }

    // Getters
    public function getSubNavigationPosition(): SubNavigationPosition
    {
        return $this->evaluate($this->subNavigationPosition);
    }

    public function shouldEnableNavigationBadge(): bool
    {
        return $this->evaluate($this->shouldEnableNavigationBadge);
    }

<<<<<<< HEAD
    public function getNavigationBadgeColor(): string|array|null
=======
    public function getNavigationBadgeColor(): string | array | null
>>>>>>> v4
    {
        return $this->evaluate($this->navigationBadgeColor);
    }

    public function getNavigationGroup(): ?string
    {
        return $this->evaluate($this->navigationGroup ?? __('filament-exceptions::filament-exceptions.labels.navigation_group'));
    }

    public function getNavigationParentItem(): ?string
    {
        return $this->evaluate($this->navigationParentItem);
    }

    public function getNavigationIcon(): string
    {
        return $this->evaluate($this->navigationIcon ?? 'heroicon-o-bug-ant');
    }

    public function getActiveNavigationIcon(): ?string
    {
        return $this->evaluate($this->activeNavigationIcon ?? 'heroicon-s-bug-ant');
    }

    public function getNavigationLabel(): string
    {
        return (string) $this->evaluate($this->navigationLabel ?? __('filament-exceptions::filament-exceptions.labels.navigation'));
    }

    public function getNavigationSort(): ?int
    {
        return $this->evaluate($this->navigationSort);
    }

    public function shouldRegisterNavigation(): bool
    {
        return $this->evaluate($this->shouldRegisterNavigation);
    }

    public function getSlug(): ?string
    {
        return $this->evaluate($this->slug);
    }

    /**
     * @return class-string<Cluster> | null
     */
    public function getCluster(): ?string
    {
        return $this->evaluate($this->cluster);
    }
}
