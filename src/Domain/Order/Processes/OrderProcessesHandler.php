<?php
declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use DomainException;
use Illuminate\Pipeline\Pipeline;
use Src\Domain\Order\Models\Order;
use Src\Support\Transaction;
use Throwable;

class OrderProcessesHandler
{
    protected array $processes = [];

    public function __construct(
        protected Order $order,

    ) {
    }

    public function processes(array $processes): static
    {
        $this->processes = $processes;

        return $this;
    }

    public function handle(): Order
    {
        return Transaction::run(function () {
            return app(Pipeline::class)
                ->send($this->order)
                ->through($this->processes)
                ->thenReturn();
        }, function (Order $order) {
            flash()->info('Заказ' . $order->id . 'успешно создан');
        }, function (Throwable $e) {
            throw new DomainException(app()->isProduction()
                ? 'Заказ не был создан'
                : $e->getMessage());
        });
    }
}
