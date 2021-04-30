<?php

namespace App\Commands\Groups;

use App\Command;

class GroupAttach extends Command
{ 

    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'group:attach {group} {users*}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Attaches a list of users to a group';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'groups:attach',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $group = $this->argument('details')[0];
        $userDetail = $this->argument('details')[1];

        // Get the group info
        $group = $this->getDetails('group', $group)->first();
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

        $this->info(__('actions.update', ['model' => 'Group', 'detail' => $group['name']]));

        $data = $this->sendRequest($url, 'put', [
            'id' => $group['id'],
            'name' => $group['name'],
            'description' => $group['description'],
            'members' => $newMembers
        ]);
        
    }

}
