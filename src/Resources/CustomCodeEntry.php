<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions\Resources;

use Closure;
use Filament\Infolists\Components\Entry;
use Filament\Support\Components\Contracts\HasEmbeddedView;
use Filament\Support\Concerns\CanBeCopied;
use Illuminate\Support\Js;
use Phiki\Grammar\Grammar;
use Phiki\Phiki;
use Phiki\Theme\Theme;
use Phiki\Transformers\Decorations\LineDecoration;

class CustomCodeEntry extends Entry implements HasEmbeddedView
{
    use CanBeCopied;

<<<<<<< HEAD
    protected string|Grammar|Closure|null $grammar = null;

    protected string|Theme|Closure|null $lightTheme = null;

    protected string|Theme|Closure|null $darkTheme = null;
=======
    protected string | Grammar | Closure | null $grammar = null;

    protected string | Theme | Closure | null $lightTheme = null;

    protected string | Theme | Closure | null $darkTheme = null;
>>>>>>> v4

    protected int $focusLine = 1;

    protected int $startLine = 1;

    public function focusLine(int $focusLine): static
    {
        $this->focusLine = $focusLine;

        return $this;
    }

    public function startLine(int $startLine): static
    {
        $this->startLine = $startLine;

        return $this;
    }

    public function getFocusLine(): int
    {
        return $this->evaluate($this->focusLine);
    }

    public function getStarLine(): int
    {
        return $this->evaluate($this->startLine);
    }

<<<<<<< HEAD
    public function grammar(string|Grammar|Closure|null $grammar): static
=======
    public function grammar(string | Grammar | Closure | null $grammar): static
>>>>>>> v4
    {
        $this->grammar = $grammar;

        return $this;
    }

<<<<<<< HEAD
    public function getGrammar(): string|Grammar|null
=======
    public function getGrammar(): string | Grammar | null
>>>>>>> v4
    {
        return $this->evaluate($this->grammar);
    }

<<<<<<< HEAD
    public function lightTheme(string|Theme|Closure|null $theme): static
=======
    public function lightTheme(string | Theme | Closure | null $theme): static
>>>>>>> v4
    {
        $this->lightTheme = $theme;

        return $this;
    }

<<<<<<< HEAD
    public function getLightTheme(): string|Theme|null
=======
    public function getLightTheme(): string | Theme | null
>>>>>>> v4
    {
        return $this->evaluate($this->lightTheme);
    }

<<<<<<< HEAD
    public function darkTheme(string|Theme|Closure|null $theme): static
=======
    public function darkTheme(string | Theme | Closure | null $theme): static
>>>>>>> v4
    {
        $this->darkTheme = $theme;

        return $this;
    }

<<<<<<< HEAD
    public function getDarkTheme(): string|Theme|null
=======
    public function getDarkTheme(): string | Theme | null
>>>>>>> v4
    {
        return $this->evaluate($this->darkTheme);
    }

    public function toEmbeddedHtml(): string
    {
        $state = $this->getState();

        $attributes = $this->getExtraAttributeBag()
            ->class([
                'fi-in-code',
            ]);

        if (blank($state)) {
            $attributes = $attributes
                ->merge([
                    'x-tooltip' => filled($tooltip = $this->getEmptyTooltip())
                        ? '{
<<<<<<< HEAD
                            content: '.Js::from($tooltip).',
=======
                            content: ' . Js::from($tooltip) . ',
>>>>>>> v4
                            theme: $store.theme,
                        }'
                        : null,
                ], escape: false);

            $placeholder = $this->getPlaceholder();

            ob_start(); ?>

            <div <?= $attributes->toHtml() ?>>
                <?php if (filled($placeholder !== null)) { ?>
                    <p class="fi-in-placeholder">
                        <?= e($placeholder) ?>
                    </p>
                <?php } ?>
            </div>

<<<<<<< HEAD
        <?php return $this->wrapEmbeddedHtml(ob_get_clean());
=======
            <?php return $this->wrapEmbeddedHtml(ob_get_clean());
>>>>>>> v4
        }

        $phiki = new Phiki;
        $grammar = $this->getGrammar();
        $lightTheme = $this->getLightTheme();
        $darkTheme = $this->getDarkTheme();

        if (is_array($state)) {
            $state = json_encode($state, flags: JSON_PRETTY_PRINT);
            $grammar ??= Grammar::Json;
        }

        $grammar ??= Grammar::Html;
        $lightTheme ??= Theme::GithubLight;
        $darkTheme ??= Theme::GithubDarkHighContrast;

        $isCopyable = $this->isCopyable($state);

        $copyableStateJs = $isCopyable
            ? Js::from($this->getCopyableState($state) ?? $state)
            : null;
        $copyMessageJs = $isCopyable
            ? Js::from($this->getCopyMessage($state))
            : null;
        $copyMessageDurationJs = $isCopyable
            ? Js::from($this->getCopyMessageDuration($state))
            : null;

        $attributes = $attributes
            ->merge([
                'x-on:click' => $isCopyable
                    ? <<<JS
                        window.navigator.clipboard.writeText({$copyableStateJs})
                        \$tooltip({$copyMessageJs}, {
                            theme: \$store.theme,
                            timeout: {$copyMessageDurationJs},
                        })
                        JS
                    : null,
                'x-tooltip' => filled($tooltip = $this->getTooltip($state))
                    ? '{
<<<<<<< HEAD
                        content: '.Js::from($tooltip).',
=======
                        content: ' . Js::from($tooltip) . ',
>>>>>>> v4
                        theme: $store.theme,
                    }'
                    : null,
            ], escape: false)
            ->class([
                'fi-copyable' => $isCopyable,
            ]);

        ob_start(); ?>

        <div <?= $attributes->toHtml() ?>>
            <?= (string) $phiki
                ->codeToHtml($state, $grammar, [
                    'light' => $lightTheme,
                    'dark' => $darkTheme,
                ])
                ->withGutter()
                ->startingLine($this->getStarLine())
                ->decoration(
                    LineDecoration::forLine($this->getFocusLine() - $this->getStarLine())
                        ->class('bg-primary-400/20', 'dark:bg-primary/20'),
                )

        ?>
        </div>

<<<<<<< HEAD
<?php return $this->wrapEmbeddedHtml(ob_get_clean());
=======
        <?php return $this->wrapEmbeddedHtml(ob_get_clean());
>>>>>>> v4
    }
}
