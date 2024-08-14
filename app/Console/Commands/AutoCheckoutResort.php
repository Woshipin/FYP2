<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingResort;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoCheckoutResort extends Command
{
    protected $signature = 'resort:auto-checkout';
    protected $description = 'Automatically checkout resorts if users forget to do so';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);
        $bookings = BookingResort::where('checkout_date', '<=', $threeDaysAgo)
                                 ->where('payment_status', 1) // assuming 1 means checked in but not yet checked out
                                 ->get();

        foreach ($bookings as $booking) {
            // 执行 checkout 逻辑
            $this->checkoutResort($booking);
            Log::info("Auto checked out resort with ID: {$booking->id}");
        }

        return Command::SUCCESS;
    }

    private function checkoutResort($booking)
    {
        try {
            DB::beginTransaction();

            $user = $booking->user;
            $userWallet = MyWallet::firstOrNew(['user_id' => $user->id]);
            $adminWallet = AdminWallet::where('verify_code', $booking->verify_code)->firstOrFail();

            $userWallet->profit += $adminWallet->balance;
            $userWallet->balance += $adminWallet->balance;
            $adminWallet->refund_user_balance = $adminWallet->balance;
            $adminWallet->balance = 0;
            $adminWallet->transferred_status = 1;

            $userWallet->refund_deposit += $adminWallet->user_deposit;
            $adminWallet->refund_user_deposit = $adminWallet->user_deposit;
            $adminWallet->user_deposit = 0;

            $userWallet->save();
            $adminWallet->save();

            $booking->payment_status = 2;
            $booking->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Auto checkout failed: ' . $e->getMessage());
        }
    }
}

