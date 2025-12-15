<?php

declare(strict_types=1);

namespace BezhanSalleh\FilamentExceptions;

use BezhanSalleh\FilamentExceptions\QueryRecorder\QueryRecorder;
use Filament\Clusters\Cluster;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Throwable;

class FilamentExceptions
{
    protected static ?string $model = null;

    /** @var class-string<Cluster> | null */
    protected static ?string $cluster = null;

    public function __construct(
        protected Request $request
    ) {}

    /**
     * @throws Throwable
     */
    public static function report(Throwable $exception): void
    {
        try {
            if (! static::shouldCapture($exception)) {
                return;
            }

            $reporter = new self(request());
            $reporter->reportException($exception);
        } catch (Throwable) {
            //
        }
    }

    /**
     * Determine if the exception should be captured.
     */
    public static function shouldCapture(Throwable $exception): bool
    {
        $file = $exception->getFile();
        $message = $exception->getMessage();

        // Skip empty/invalid file paths
        if (blank($file) || ! str($file)->endsWith('.php')) {
            return false;
        }

        // Skip eval'd code
        if (str_contains($file, "eval()'d code")) {
            return false;
        }

        // Skip empty messages
        if (blank($message)) {
            return false;
        }

        // Skip VSCode Laravel extension noise
        if (str_contains($message, '__VSCODE_LARAVEL_')) {
            return false;
        }

        // Skip invalid line numbers
        if ($exception->getLine() <= 0) {
            return false;
        }

        return true;
    }

    public static function cluster(string $cluster): void
    {
        static::$cluster = $cluster;
    }

    public static function getCluster(): ?string
    {
        return static::$cluster;
    }

    public static function getModel(): ?string
    {
        return static::$model;
    }

    public static function model(string $model): void
    {
        static::$model = $model;
    }

    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function reportException(Throwable $exception): void
    {
        $data = [
            'method' => request()->getMethod(),
            'ip' => implode(' ', json_decode(json_encode(request()->getClientIps()))),
            'path' => request()->path(),
            'query' => app()->make(QueryRecorder::class)->getQueries(),
            'body' => request()->getContent(),
            'cookies' => request()->cookies->all(),
            'headers' => Arr::except(request()->headers->all(), 'cookie'),

            'type' => $exception::class,
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        $data = $this->stringify($data);

        $this->store($data);
    }

    public function stringify($data): array
    {
        return array_map(fn ($item): string | false => is_array($item) ? json_encode($item, JSON_OBJECT_AS_ARRAY) : (string) $item, $data);
    }

    public function store(array $data): bool
    {
        try {
            static::getModel()::create($data);

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
