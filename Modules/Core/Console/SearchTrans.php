<?php

namespace Modules\Core\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SearchTrans extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:trans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command should help in generating file contains all trans words used in the project by __() function ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $baseFile = resource_path('lang/ar.json');
        $words = ! File::exists($baseFile) ? [] : json_decode(file_get_contents($baseFile), true);
        $files = File::allFiles('./Modules');
        $newWords = [];
        foreach ($files as $file) {
            if ($file->getFileName() === 'SearchTrans.php') {
                continue;
            }
            Str::of($file->getContents())->matchAll("/__\(['\"].*?['\"]\)/")->each(static function (
                $item
            ) use (
                &$words,
                &$newWords
            ) {
                $word = (string) Str::of((string) $item)
                    ->replace("__('", '')
                    ->replace("')", '')
                    ->replace('__("', '')
                    ->replace('")', '');
                if (! isset($words[$word])&&  !Str::contains($word, '::')) {
                    $newWords[$word] = $word;
                }
            });
        }
        $file = 'trans_locale_'.time().'.json';
        file_put_contents(resource_path('lang/'.$file), json_encode($newWords));
        echo 'exporting language done successfully '.$file.PHP_EOL;

        return 0;
    }
}
