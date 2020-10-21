<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command;
use App\Traits\T4able;

class GroupAttach extends Command
{
    use T4able;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:attach {group} {users*}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Attaches a list of users to a group';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $groupDetail = $this->argument('group');
        $userDetail = $this->argument('users');

        // Get the group info
        $group = $this->getDetails('group', $groupDetail);
        $group = $group->first();
        $url = __('api.group.show', ['group' => $group['id']]);
        $groupMetaDataDTO = $this->sendRequest($url);

        $existingMembers = collect($groupMetaDataDTO['members']);
        $existingMembers = $existingMembers->values();

        $users = $this->getDetails('user', $userDetail);
        $users = $users->map(function ($user) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'authLevel' => $user['authLevel'],
                'emailAddress' => $user['emailAddress'],
            ];
        });
        
        $newMembers = $existingMembers->merge($users);

        $newMembers = $newMembers->unique(function($member) {
            return $member['id'];
        });

        $data = $this->sendRequest($url, 'put', [
            'id' => $group['id'],
            'name' => $group['name'],
            'description' => $group['description'],
            'members' => $newMembers
        ]);

        $this->info("Success: Updated group " . $group['name']);
    }

}
