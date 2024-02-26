<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Filters;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    abstract public function title(): string;

    /**
     * filters.{key}.{index}
     */
    abstract public function key(): string;

    abstract public function apply(Builder $query);

    public function values(): array
    {
        return [];
    }

    abstract public function view(): string;

    /**
     * filters.{key}.{index}
     */
    public function requestValue(?string $index = null, mixed $default = null): mixed
    {
        return request('filters.' . $this->key() . ($index ? ".$index" : $index), $default);
    }

    /**
     * Returns full string for form name attributes. Example: filters.[key].[{index}]
     */
    public function name(?string $index = null): string
    {
        return str('filters')
            ->append("[{$this->key()}]")
            ->when($index, fn ($str) => $str->append("[$index]"))
            ->value();
    }

    public function id(string $index = null): string
    {
        return str($this->name($index))
            ->slug('_');
    }

    public function __toString(): string
    {
        return view($this->view())
            ->with(array_merge(['filter' => $this], $this->values()))
            ->render();
    }

    public function __invoke(Builder $query, Closure $next)
    {
        $this->apply($query);

        return $next($query);
    }
}
