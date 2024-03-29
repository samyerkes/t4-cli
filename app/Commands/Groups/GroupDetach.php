<?php

namespace App\Commands\Groups;

use App\Command;

class GroupDetach extends Command
{  

    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'group:detach {group} {users*}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Detaches a list of users from a group';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'groups:detach',
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

        // Get the existing members of the group
        $existingMembers = collect($groupMetaDataDTO['members']);
        $existingMembers = $existingMembers->values();

        $membersToRemove = $this->getDetails('user', $userDetail);
        $membersToRemove = $membersToRemove->map(function ($user) {
                return $user['id'];
            })
            ->values()
            ->toArray();
        
        $newMembers = $existingMembers->filter(function($user) use ($membersToRemove) {
                return in_array($user['id'], $membersToRemove) ? false : true;
            })
            ->values()
            ->toArray();

        $data = $this->sendRequest($url, 'put', [
            'id' => $group['id'],
            'name' => $group['name'],
            'description' => $group['description'],
            'members' => $newMembers
        ]);

        $this->info(__('actions.update', ['model' => 'Group', 'detail' => $group['name']]));
    }

}
