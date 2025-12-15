<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions\Trace;

<<<<<<< HEAD
use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use SplFileObject;

class Frame
{
    protected ?array $attributes = [];

    protected array|CodeBlock|null $code = [];

    public function __construct(protected ?string $frame = '')
    {
        $this->extract();
    }

    public function extract(): ?array
    {
        preg_match('/#\d+\s([^:]+):?\s?(.*)/', (string) $this->frame, $matches);
        $this->parseFileAndLine($matches[1] ?? '');
        $this->parseCall($matches[2] ?? '');
        $this->fetchCodeBlock();

        return $this->attributes;
    }

    public function parseFileAndLine($str): void
    {
        if (str()->startsWith($str, '/')) {
            preg_match('/^([^(]+)\((\d+)\)/', (string) $str, $matches);
            [, $this->attributes['file'], $this->attributes['line']] = $matches;
        } else {
            $this->attributes['name'] = $str;
        }
    }

    public function parseCall($str): void
    {
        if (empty($str)) {
            return;
        }
        if (preg_match('/^[^(]+(->|::)/', (string) $str, $m)) {
            preg_match('/([^:-]+)(?:->|::)([^(]+)\((.*)\)/', (string) $str, $matches);
            $this->attributes['class'] = $matches[1];
            $this->attributes['method'] = $matches[2];
            $this->attributes['args'] = $this->extractArgs($matches[3]);
            if (str()->contains($matches[2], ['{closure}']) && Arr::get($this->attributes, 'name') == '[internal function]') {
                $this->attributes['name'] .= " $matches[1]->$matches[2]";
            }
            // class method call
        } else {
            preg_match('/([^(]+)\((.*)\)/', (string) $str, $matches);
            $this->attributes['function'] = $matches[1];
            $this->attributes['args'] = $this->extractArgs($matches[2]);
        }
    }

    public function fetchCodeBlock(): void
    {
        $filename = Arr::get($this->attributes, 'file');
        $lineNo = Arr::get($this->attributes, 'line');
        $class = Arr::get($this->attributes, 'class');
        $method = Arr::get($this->attributes, 'method');
        if ((! $filename || ! $lineNo) && ($class && $method)) {
            if (! class_exists($class)) {
                return;
            }
            $classReflection = new ReflectionClass($class);
            $filename = $classReflection->getFileName();
            if (! $classReflection->hasMethod($method)) {
                return;
            }
            $methodReflection = $classReflection->getMethod($method);

            $lineNo = $methodReflection->getStartLine();
        }
        if (! $filename || ! $lineNo) {
=======
use SplFileObject;
use Throwable;

class Frame
{
    protected string $file = '';

    protected int $line = 0;

    protected ?string $class = null;

    protected ?string $method = null;

    protected bool $isApplicationFrame = true;

    protected ?CodeBlock $codeBlock = null;

    /**
     * Create a Frame from array data (spatie/backtrace format).
     *
     * @param  array<string, mixed>  $data
     */
    public function __construct(array $data = [])
    {
        try {
            $this->file = (string) ($data['file'] ?? '');
            $this->line = (int) ($data['line'] ?? 0);
            $this->class = $data['class'] ?? null;
            $this->method = $data['method'] ?? null;
            $this->isApplicationFrame = (bool) ($data['isApplicationFrame'] ?? $this->detectApplicationFrame());

            $this->fetchCodeBlock();
        } catch (Throwable) {
            // Silent fail - ensure frame is always safe to use
        }
    }

    public function file(): string
    {
        return $this->file;
    }

    public function line(): int
    {
        return $this->line;
    }

    public function class(): ?string
    {
        return $this->class;
    }

    public function method(): string
    {
        return $this->method ?? '';
    }

    public function isApplicationFrame(): bool
    {
        return $this->isApplicationFrame;
    }

    public function isVendorFrame(): bool
    {
        return ! $this->isApplicationFrame;
    }

    public function getCodeBlock(): CodeBlock
    {
        return $this->codeBlock ?? new CodeBlock;
    }

    /**
     * Get a shortened file path relative to base path.
     */
    public function shortFilePath(): string
    {
        try {
            $basePath = base_path() . '/';

            return str_starts_with($this->file, $basePath)
                ? substr($this->file, strlen($basePath))
                : $this->file;
        } catch (Throwable) {
            return $this->file;
        }
    }

    /**
     * Get just the filename without path.
     */
    public function filename(): string
    {
        return basename($this->file);
    }

    /**
     * Detect if this frame is an application frame (not vendor).
     */
    protected function detectApplicationFrame(): bool
    {
        if (blank($this->file)) {
            return false;
        }

        // Vendor directory = not application frame
        if (str_contains($this->file, '/vendor/')) {
            return false;
        }

        // CLI tools are considered vendor frames
        return ! str_ends_with($this->file, 'artisan') && ! str_ends_with($this->file, 'please');
    }

    /**
     * Fetch code block around the line.
     */
    protected function fetchCodeBlock(): void
    {
        if (blank($this->file) || $this->line <= 0) {
            return;
        }

        if (! file_exists($this->file) || ! is_readable($this->file)) {
>>>>>>> v4
            return;
        }

        try {
<<<<<<< HEAD
            $file = new SplFileObject($filename);
            $target = max(0, ($lineNo - (5 + 1)));
            $file->seek($target);

            $curLineNo = $target + 1;
            $line = $prefix = $suffix = '';

            while (! $file->eof()) {
                if ($curLineNo == $lineNo) {
                    $line .= $file->current();
                } elseif ($curLineNo < $lineNo) {
                    $prefix .= $file->current();
                } elseif ($curLineNo > $lineNo) {
                    $suffix .= $file->current();
                }
                $curLineNo++;
                if ($curLineNo > $lineNo + 5) {
                    break;
                }
                $file->next();
            }
            $this->code = new CodeBlock($target + 1, $line, $prefix, $suffix);
            $this->attributes['file'] = $filename;
            $this->attributes['line'] = $lineNo;
        } catch (RuntimeException) {
            return;
        }
    }

    public function getCodeBlock(): array|CodeBlock
    {
        return empty($this->code) ? new CodeBlock : $this->code;
    }

    public function method()
    {
        return Arr::get($this->attributes, 'method', Arr::get($this->attributes, 'function', ''));
    }

    /**
     * @throws ReflectionException
     */
    public function args(): array
    {
        if (empty($this->attributes['args'])) {
            return [];
        }
        $args = [];
        $names = $this->getParameterNames();
        foreach ($this->attributes['args'] as $key => $val) {
            $args[Arr::get($names, $key, "param$key")] = $val;
        }

        return $args;
    }

    /**
     * @throws ReflectionException
     */
    public function getParameterNames(): array
    {
        $names = [];
        $class = Arr::get($this->attributes, 'class');
        $method = Arr::get($this->attributes, 'method');
        if (class_exists($class) && isset($method)) {
            $classReflection = new ReflectionClass($class);
            if (! $classReflection->hasMethod($method)) {
                return $names;
            }
            foreach ($classReflection->getMethod($method)->getParameters() as $reflection) {
                $names[] = $reflection->getName();
            }
        }

        return $names;
    }

    protected function extractArgs($args): array
    {
        if (empty($args)) {
            return [];
        }
        $args = explode(',', (string) $args);

        return array_map('trim', $args);
    }

    public function line()
    {
        return Arr::get($this->attributes, 'line', 0);
    }

    public function __call($method, $arguments = [])
    {
        return Arr::get($this->attributes, $method, '');
    }

    public function __get($key)
    {
        return Arr::get($this->attributes, $key, '');
    }
=======
            $contextLines = 5;
            $file = new SplFileObject($this->file);
            $startLine = max(0, $this->line - $contextLines - 1);
            $file->seek($startLine);

            $currentLine = $startLine + 1;
            $focusLine = '';
            $prefix = '';
            $suffix = '';

            while (! $file->eof() && $currentLine <= $this->line + $contextLines) {
                $lineContent = $file->current();

                if ($currentLine === $this->line) {
                    $focusLine = $lineContent;
                } elseif ($currentLine < $this->line) {
                    $prefix .= $lineContent;
                } else {
                    $suffix .= $lineContent;
                }

                $currentLine++;
                $file->next();
            }

            $this->codeBlock = new CodeBlock($startLine + 1, $focusLine, $prefix, $suffix);
        } catch (Throwable) {
            // Silent fail - code block is optional
        }
    }
>>>>>>> v4
}
