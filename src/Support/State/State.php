<?php
declare(strict_types=1);

namespace Src\Support\State;

use Illuminate\Database\Eloquent\Model;

abstract class State
{
    public function __construct(
        protected Model $model
    ) {
    }

    protected array $allowedTransitions = [
    ];

    public static function getStates(): array
    {
        return [
        ];
    }

    abstract public function getStateColumnName(): string;

    abstract public function stateChangedEvent(): ?string;

    abstract public function canBeChanged(): bool;

    abstract public function value(): string;

    abstract public function humanValue(): string;

    public function transitionTo(State $state): void
    {
        if (! $this->canBeChanged()) {
            throw new \InvalidArgumentException('Status can\'t be changed');
        }

        if (! in_array(get_class($state), $this->allowedTransitions)) {
            throw new \InvalidArgumentException(
                "No transition for {$this->model->{$this->getStateColumnName()}->value()} to {$state->value()}");
        }

        $this->model->updateQuietly(['status' => $state->value()]);

        if ($event = $this->stateChangedEvent()) {
            event(new $event($this->model, $this, $state));
        }
    }
}
