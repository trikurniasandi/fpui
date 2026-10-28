<?php

namespace App\Console\Commands;

use App\Models\InstagramSetting;
use App\Services\InstagramFeedService;
use Illuminate\Console\Command;

class RefreshInstagramToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:refresh-token
                            {--force : Perbarui token meskipun masa berlakunya masih lama}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perbarui long-lived access token semua akun Instagram';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $accounts = InstagramSetting::query()->ordered()->get();

        if ($accounts->isEmpty()) {
            $this->warn('Belum ada akun Instagram yang dikonfigurasi.');

            return self::SUCCESS;
        }

        $failed = false;

        foreach ($accounts as $account) {
            $name = $account->displayName();
            $result = InstagramFeedService::for($account)->refreshToken(
                force: (bool) $this->option('force')
            );

            if ($result['success']) {
                $this->info($name.': '.$result['message']);
            } elseif ($result['skipped']) {
                $this->warn($name.': '.$result['message']);
            } else {
                $this->error($name.': '.$result['message']);
                $failed = true;
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
