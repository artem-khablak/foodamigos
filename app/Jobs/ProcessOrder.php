<?php

namespace App\Jobs;

use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        app(OrderRepositoryInterface::class)->update($this->orderId, ['status' => 'processed']);

        $adminEmail = config('mail.admin_address');
        Mail::raw('An order has been processed.', function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                ->subject('Order Processed');
        });
    }
}
