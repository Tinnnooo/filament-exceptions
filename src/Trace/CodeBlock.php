<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions\Trace;

use Phiki\Grammar\Grammar;
use Phiki\Phiki;
use Phiki\Theme\Theme;
use Phiki\Transformers\Decorations\LineDecoration;
<<<<<<< HEAD

class CodeBlock
{
    public function __construct(protected mixed $startLine = 1, protected mixed $line = '', protected mixed $prefix = '', protected mixed $suffix = '') {}

    public function getStartLine()
=======
use Throwable;

class CodeBlock
{
    public function __construct(
        protected int $startLine = 1,
        protected string $line = '',
        protected string $prefix = '',
        protected string $suffix = ''
    ) {}

    public function getStartLine(): int
>>>>>>> v4
    {
        return $this->startLine;
    }

<<<<<<< HEAD
    public function getLine()
=======
    public function getLine(): string
>>>>>>> v4
    {
        return $this->line;
    }

<<<<<<< HEAD
    public function getSuffix()
=======
    public function getSuffix(): string
>>>>>>> v4
    {
        return $this->suffix;
    }

<<<<<<< HEAD
    public function getPrefix()
=======
    public function getPrefix(): string
>>>>>>> v4
    {
        return $this->prefix;
    }

    public function codeString(): string
    {
<<<<<<< HEAD
        return once(fn (): string => $this->prefix.$this->line.$this->suffix);
    }

    public function output($focusLine, Theme $theme = Theme::GithubLight): string
    {
        return (new Phiki)
            ->codeToHtml(
                code: $this->codeString(),
                grammar: Grammar::Php,
                theme: $theme,
            )
            ->withGutter()
            ->startingLine($this->getStartLine())
            ->decoration(
                LineDecoration::forLine($focusLine - $this->getStartLine())
                    ->class('bg-primary-400/20', 'dark:bg-primary/20'),
            )
            ->toString();
=======
        return $this->prefix . $this->line . $this->suffix;
    }

    public function output(int $focusLine, Theme $theme = Theme::GithubLight): string
    {
        try {
            $code = $this->codeString();

            if (blank($code)) {
                return '';
            }

            // LineDecoration expects 0-based index within the code block
            $lineIndex = $focusLine - $this->startLine;

            return (string) (new Phiki)
                ->codeToHtml(
                    code: $code,
                    grammar: Grammar::Php,
                    theme: $theme,
                )
                ->withGutter()
                ->startingLine($this->startLine)
                ->decoration(
                    LineDecoration::forLine($lineIndex)
                        ->class('bg-primary-400/20!', 'dark:bg-primary/20!', 'highlighted-line'),
                );
        } catch (Throwable) {
            // Fallback to plain text if Phiki fails
            return '<pre class="p-4 bg-gray-100 dark:bg-gray-800 rounded overflow-x-auto"><code>'
                . e($this->codeString())
                . '</code></pre>';
        }
>>>>>>> v4
    }
}
