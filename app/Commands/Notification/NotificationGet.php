<?php

namespace App\Commands\Notification;

use App\Command;
use App\Factories\NotificationFactory;

class NotificationGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'notification:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of notifications';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'notification',
        'notifications',
        'notifications:get'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        "id",
        "user",
        "notificationType",
        "notificationStatus",
        "createdTime",
        "executionTime",
        "completionTime"
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "scheduled",
        "log",
        "type"
    ];

    protected $timestamps = [
        'createdTime',
        'executionTime',
        'completionTime'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->getDetails('notification', $this->argument('details'));

        $factory = new NotificationFactory();
        $notifications = $factory->generate($data);
        
        $this->print($notifications, $this->timestamps);
    }

}
