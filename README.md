# T4 CLI

Command architecture inspired by the [WP-CLI](https://wp-cli.org/) and [AWS-CLI](https://docs.aws.amazon.com/cli/index.html) projects.

The focus of this tool is the management of the SiteManager CMS from Terminalfour. No one wants to create content from a CLI, that sounds awful.

| Command              | Description                                    | Arguments                  | Flags                                                    | Default Format |
| -------------------- |------------------------------------------------|----------------------------|----------------------------------------------------------|----------------|
| t4 about             | Get details about the application, host and os |                            | --fields --format                                        | Table          |
| t4 channel:get       | Gets details about a channel                   | {channels?*}               | --fields --filter --format -m|--microsite --order --sort | Table          |
| t4 configure         | Configures the CLI                             |                            |                                                          | None           |
| t4 contenttypes:get  | Gets details about a content type              | {contenttypes?*}           | --fields --filter --format --order --sort                | Table          |
| t4 group:attach      | Attaches a list of users to a group            | {group} {users*}           |                                                          | None           |
| t4 group:create      | Creates a group                                | {groupname} {description?} |                                                          | None           |
| t4 group:delete      | Deletes a group                                | {group}                    |                                                          | None           |
| t4 group:detach      | Detaches a list of users from a group          | {group} {users*}           |                                                          | None           |
| t4 group:get         | Gets details about a group                     | {groups?*}                 | --fields --filter --format --order --sort                | Table          |
| t4 group:members     | Returns the members of a group                 | {groups*}                  | --fields --filter --format --order --sort                | Table          |
| t4 key:get           | Get a list of API keys                         | {keys?*}                   | --fields --filter --format --order --sort                | Table          |
| t4 schedule:get      | Get a list of scheduled jobs                   | {schedules?*}              | --fields --filter --format --order --sort                | Table          |
| t4 transfer:get      | Get a list of transfers                        | {transfers?*}              | --fields --filter --format --order --sort                | Table          |
| t4 user:get          | Gets details about a user                      | {users?*}                  | --fields --filter --format --order --sort                | Table          |
| t4 whoami            | Displays information about the auth'd user     |                            | --fields --format                                        | Table          |

## Output

Using the --format flag, you have the ability to format output with the following options:

* count - returns the number of results
* csv - returns the results as a comma deliniated rows
* id - returns only the ids of the results. If selected you must either not use the fields option (sticking with the defaults) or ensure to include the id as a field.
* json - returns the results json encoded
* single - returns the results for the first single attribute of each returned record. This is similar to the id format.
* table - returns the results in an easy to read table.

## Profile

By default the application will use a profile named, "default."

If you want to use multiple instances of T4 you can define additional profiles in your .t4 file. Each profile is defined as:

```
[name]
t4_url="https://cms.school.edu"
t4_webapi="https://cms.school.edu/terminalfour/rs"
t4_token="xxxxxxxxx"
```

To switch your profile just export a new `T4_PROFILE` variable.

```export T4_PROFILE=profileName```

## Command chaining

The commands have been architected so you can do some interesting chaining using the --format=id option. Here are some interesting ideas to get you started.

Get all group members from a list of groups.
```
t4 group:get "Group 1" "Group 2" --format=id | xargs t4 group:members
```

Get all channels that have a transfer attached to them.
```
t4 transfer:get --fields=channelID --format=single | xargs t4 channel:get -m
```