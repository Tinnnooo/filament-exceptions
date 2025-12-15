<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages;

use BezhanSalleh\FilamentExceptions\Resources\ExceptionResource;
<<<<<<< HEAD
use BezhanSalleh\FilamentExceptions\Trace\Parser;
=======
use BezhanSalleh\FilamentExceptions\StoredException;
>>>>>>> v4
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
<<<<<<< HEAD
use Phiki\Theme\Theme;
=======
use Illuminate\Contracts\Support\Htmlable;
use Throwable;
>>>>>>> v4

class ViewException extends ViewRecord
{
    protected static string $resource = ExceptionResource::class;

    protected string $view = 'filament-exceptions::view-exception';

<<<<<<< HEAD
    protected ?array $cachedFrames = null;

    public function getFramesProperty(): ?array
    {
        if (blank($this->cachedFrames)) {
            $trace = "#0 {$this->record->file}({$this->record->line})\n";
            $frames = (new Parser($trace.$this->record->trace))->parse();
            array_pop($frames);

            $this->cachedFrames = $frames;
        }

        return $this->cachedFrames;
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function renderFrame(int $frameIndex, bool $isDark = false): string
    {
        $frames = $this->frames;

        if (! isset($frames[$frameIndex])) {
            return '<div class="text-red-500">Frame not found</div>';
        }

        $frame = $frames[$frameIndex];
        $theme = $isDark ? Theme::GithubDark : Theme::GithubLight;

        return $frame->getCodeBlock()->output($frame->line(), $theme);
=======
    protected ?StoredException $storedException = null;

    /**
     * Get the stored exception instance for rendering with Laravel's components.
     */
    public function getStoredException(): StoredException
    {
        if ($this->storedException !== null) {
            return $this->storedException;
        }

        try {
            $this->storedException = new StoredException($this->record);
        } catch (Throwable) {
            // If something goes wrong, create with a fresh record
            $this->storedException = new StoredException($this->record);
        }

        return $this->storedException;
    }

    public function getHeading(): string | Htmlable | null
    {
        return null; // $this->heading ?? $this->getTitle();
>>>>>>> v4
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return [
            'fi-resource-view-record-page',
<<<<<<< HEAD
            'fi-resource-'.str_replace('/', '-', $this->getResource()::getSlug(Filament::getCurrentOrDefaultPanel())),
            "fi-resource-record-{$this->getRecord()->getKey()}",
        ];
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
=======
            'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug(Filament::getCurrentOrDefaultPanel())),
            'fi-resource-record-' . $this->getRecord()->getKey(),
        ];
    }

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::SixExtraLarge;
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
>>>>>>> v4
    }
}
