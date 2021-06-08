<?php
/**
 *InstallBlogPackage
 * @author tan bing
 * @date 2021-06-03 10:15
 */


namespace Tanbing\BlogPackage\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallBlogPackage extends Command
{
    protected $hidden = true;

    protected $signature = 'blogpackage:install';

    protected $description = 'Install the BlogPackage';

    public function handle()
    {
        $this->info('Installing BlogPackage...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('blogpackage.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed BlogPackage');
    }

    /**
     * 检测文件是否已存在.
     * @param $fileName
     * @return bool
     * @author tan bing
     * @date 2021-06-03 10:19
     */
    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Tanbing\BlogPackage\BlogPackageServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = '';
        }

        $this->call('vendor:publish', $params);
    }
}