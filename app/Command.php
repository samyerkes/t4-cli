<?php

namespace App;

use App\Traits\Customizable;
use App\Traits\T4able;
use LaravelZero\Framework\Commands\Command as LaravelCommand;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use XdgBaseDir\Xdg;

class Command extends LaravelCommand
{
    use Customizable, T4able;

    protected $configurationFile = '.t4';

    protected $fields = ['id'];
    
    protected $optionalFields = [];

    protected $aliases = [];

    protected $format = 'table';

    protected $order = 'desc';

    protected $profile = 'default';
    
    protected $sort = 'id';

    public function configure()
    {
        $this->setAliases($this->aliases);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['details', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Narrow the search to specific ids or names'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     * https://laravel.com/docs/4.2/commands
     */
    public function getOptions()
    {
        return [
            ['fields', null, InputOption::VALUE_OPTIONAL, 'Return specific fields from a record', $this->fields],
            ['filters', null, InputOption::VALUE_OPTIONAL, 'Return only certain records that match a particular filter'],
            ['format', null, InputOption::VALUE_OPTIONAL, 'Return the records in a specific format', $this->format],
            ['labels', '-l', InputOption::VALUE_NONE, 'Return all default and optional fields for a command'],
            ['order', null, InputOption::VALUE_OPTIONAL, 'Order the returned records in asc or desc order', $this->order],
            ['profile', '-p', InputOption::VALUE_OPTIONAL, 'Use a specific profile for this particular command'],
            ['sort', null, InputOption::VALUE_OPTIONAL, 'Sort the returned records based on a field', $this->sort]
        ];
    }

    private function getProfileCredentials()
    {
        $xdg = new \XdgBaseDir\Xdg();
        $homedir = $xdg->getHomeDir();

        $configurationFileContents = file_get_contents($homedir . '/' . $this->configurationFile);

        // a inline command option for profile will take precence over an environment var, if nothing is set 'default' will be used.
        $profileShortKey = $this->option('profile') ?? getenv('T4_PROFILE') ?? $this->profile;

        $profileChunks = explode("\n\n", $configurationFileContents);

        $regex = "/(\[$profileShortKey\])/";

        $profile = preg_grep($regex, $profileChunks);

        $profile = array_values($profile);

        $profile = $profile[0];

        $lines = explode("\n", $profile);

        $headings = [
            't4_url',
            't4_webapi',
            't4_token'
        ];

        $lines = array_filter($lines, array($this, 'isConfigurationLine'));

        list($base, $webapi, $token) = array_map(array($this, 'getValue'), $lines, $headings);

        return [
            'base' => $base,
            'webapi' => $webapi,
            'token' => $token
        ];

    }

    // Defaults to a get request if other arguments are not provided
    public function sendRequest($url, $method='get', $data=[]) {
        $credentials = $this->getProfileCredentials();

        $method = strtolower($method);
        
        $response = Http::withToken($credentials['token'])->$method($credentials['webapi'] . $url, $data);
        
        if (!$response->ok()) {
            $this->error($response);
            die();
        }

        return collect($response->json());
    }

    private function isConfigurationLine($value)
    {
        // If it's just an empty line return false, we don't need it.
        if ($value == "") return false;

        // if it matches the profile heading syntax return false, we don't need it.
        $regex = "/\[.*\]/";
        $matchesProfileHeadingSyntax = preg_match($regex, $value);
        return $matchesProfileHeadingSyntax ? false : true;
    }

    private function getValue($line, $key) {
        $regex = "/^{$key}=\"(.*)\"$/";
        $value = preg_match($regex, $line, $urlMatches);
        $value = $urlMatches[1];
        return $value;
    }

    public function print($data, $timestampFields = null)
    {
        if ($this->option('labels')) return $this->printLabels($this->fields, $this->optionalFields);
        
        if (count($data)) {

            $data = $this->getFilteredContent($data, $this->option('filters'));

            $data = $this->getFieldsOfContent($data, $this->option('fields'));

            if ($timestampFields) $data = $this->convertTimestampToHumanReadable($data, $timestampFields);
    
            $data = $this->sortContent($data, $this->option('sort'), $this->option('order'));
    
            $this->printWithFormatter($data, $this->option('format'));
        }
    }
    
}
