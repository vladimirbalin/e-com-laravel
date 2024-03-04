<?php
declare(strict_types=1);

namespace Src\Domain\Order\States;

use Src\Domain\Order\Events\OrderStatusChangedEvent;
use Src\Domain\Order\Models\Order;

abstract class OrderState
{
    public function __construct(
        protected Order $order
    ) {
    }

    protected array $allowedTransitions = [
    ];

    public static function getStates(): array
    {
        return [
        ];
    }

    abstract public function canBeChanged(): bool;

    abstract public function value(): string;

    abstract public function humanValue(): string;

    public function transitionTo(OrderState $state): void
    {
        if (! $this->canBeChanged()) {
            throw new \InvalidArgumentException('Status can\'t be changed');
        }

        if (! in_array(get_class($state), $this->allowedTransitions)) {
            throw new \InvalidArgumentException(
                "No transition for {$this->order->status->value()} to {$state->value()}");
        }

        $this->order->updateQuietly(['status' => $state->value()]);

        event(new OrderStatusChangedEvent($this->order, $this, $state));
    }
}
