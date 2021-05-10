# T4 CLI

Command architecture inspired by the [WP-CLI](https://wp-cli.org/) and [AWS-CLI](https://docs.aws.amazon.com/cli/index.html) projects.

The focus of this tool is the management of the SiteManager CMS from Terminalfour. No one wants to create content from a CLI, that sounds awful.

| Command              | Description                                    | Arguments                                                   | Flags                                                                          | Default Format |
| -------------------- |------------------------------------------------|-------------------------------------------------------------|--------------------------------------------------------------------------------|----------------|
| t4 about             | Get details about the application, host and os |                                                             | --fields --format                                                              | Table          |
| t4 channel:get       | Get a list of channels                         | {details?*}                                                 | --fields --filter --format -m|--microsite --order --sort                       | Table          |
| t4 configure         | Configures the CLI                             |                                                             |                                                                                | None           |
| t4 contenttypes:get  | Gets details about a content type              | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 group:attach      | Attaches a list of users to a group            | {group} {users*}                                            |                                                                                | None           |
| t4 group:create      | Creates a group                                | {groupname} {description?}                                  |                                                                                | None           |
| t4 group:delete      | Deletes a group                                | {group}                                                     |                                                                                | None           |
| t4 group:detach      | Detaches a list of users from a group          | {group} {users*}                                            |                                                                                | None           |
| t4 group:get         | Gets details about a group                     | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 group:members     | Returns the members of a group                 | {details*}                                                  | --fields --filter --format --order --sort                                      | Table          |
| t4 group:update      | Updates details about a group                  | {details?*}                                                 | --name --description --emailAddress --defaultPreviewChannel --enabled          | Success        |
| t4 key:get           | Get a list of API keys                         | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 layout:get        | Get a list of layouts                          | {details?*}                                                 | --fields, --filter, --format, --l|labels, --sort, --order                      | Table          |
| t4 navigation:get    | Get a list of navigation items                 | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 schedule:get      | Get a list of scheduled jobs                   | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 transfer:get      | Get a list of transfers                        | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 user:create       | Creates a new user                             | {firstName} {lastName} {username} {password} {emailAddress} | --role --authentication --enabled --defaultLang                                | Success        |
| t4 user:get          | Gets details about a user                      | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 user:delete       | Deletes one or more users                      | {details?*}                                                 |                                                                                | Success        |
| t4 user:group        | Gets group details for one or more users.      | {details?*}                                                 | --fields --filter --format --order --sort                                      | Table          |
| t4 user:update       | Updates details about a user                   | {details?*}                                                 | --firstName --lastName --emailAddress --defaultLang --enabled --role --deleted | Success        |
| t4 whoami            | Displays information about the auth'd user     |                                                             | --fields --format                                                              | Table          |

## Global options

### Output

Using the --format flag, you have the ability to format output with the following options:

* count - returns the number of results
* csv - returns the results as a comma deliniated rows
* id - returns only the ids of the results. If selected you must either not use the fields option (sticking with the defaults) or ensure to include the id as a field.
* json - returns the results json encoded
* table - returns the results in an easy to read table.
* text - returns the results for the first text attribute of each returned record. This is similar to the id format.

### Profile

You can use multiple instances of T4 by utilizing the profile option. By default the application will read your .t4 file and use the configuration under a profile named, "default." 

Additional profiles can be defined in your .t4 file as:

```
[name]
t4_url="https://cms.school.edu"
t4_webapi="https://cms.school.edu/terminalfour/rs"
t4_token="xxxxxxxxx"
```

To switch your profile set a new `T4_PROFILE` environment variable as the profile you want to use.

```export T4_PROFILE=profileName```

Or you can use the `--profile=` or `-p` flag to switch your profile for a one off command.

An inline command option for profile will take precence over an environment variable, if neither the inline profile or environment variable is set the 'default' profile will be used.

## Command chaining

The commands have been architected so you can do some interesting chaining using the --format=id and --format=text option. Here are some interesting ideas to get you started.


Get all channels that have a transfer attached to them.
```
t4 transfer:get --fields=channelID --format=text | xargs t4 channel:get -m
```

Get all the users that are in the same groups as person1 user.
```
t4 user:group person1 --format=id | xargs t4 group:members
```

Change the role level of all users in a particular group.
```
t4 group:members "My group" --format=id | xargs t4 user:update --role=contributor
```

Delete all users that belong to a particular group
```
t4 user delete $(t4 group:members "My group" --format=id)
```

## Labels

Each `get` command comes with default returned attributes, but there may be circumstances where you need to use other fields. To find out the available fields you can use, pass the `-l` or `--labels` option to print the fields available to that command.