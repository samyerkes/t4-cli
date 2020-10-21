# T4 CLI

Command architecture inspired by the [WP-CLI](https://wp-cli.org/) and [AWS-CLI](https://docs.aws.amazon.com/cli/index.html) projects.

The focus of this tool is the management of the SiteManager CMS from Terminalfour. No one wants to create content from a CLI, that sounds awful.

| Command              | Description                                    | Arguments                            | Flags                                     | Default Format |
| -------------------- |------------------------------------------------|--------------------------------------|-------------------------------------------|----------------|
| t4 about             | Get details about the application, host and os |                                      | --fields --format                         | Table          |
| t4 channel:get       | Gets details about a channel                   | {channel}                            | --fields --format                         | Table          |
| t4 channel:list      | List channel                                   |                                      | --fields --filter --format --order --sort | Table          |
| t4 configure         | Configures the CLI                             |                                      |                                           | None           |
| t4 contenttypes:get  | Gets details about a content type              | {contentTypeDetails*}                | --fields --format --order --sort          | Table          |
| t4 contenttypes:list | List content types                             |                                      | --fields --filter --format --order --sort | Table          |
| t4 group:attach      | Attaches a list of users to a group            | {group} {users*}                     |                                           | None           |
| t4 group:create      | Creates a group                                | {groupname} {description?}           |                                           | None           |
| t4 group:delete      | Deletes a group                                | {group}                              |                                           | None           |
| t4 group:detach      | Detaches a list of users from a group          | {group} {users*}                     |                                           | None           |
| t4 group:list        | Lists groups                                   | {user?}                              | --fields --filter --format --order --sort | Table          |
| t4 group:members     | Returns the members of a group                 | {groupname}                          | --fields --filter --format --order --sort | Table          |
| t4 key:list          | List API keys                                  |                                      | --fields --filter --format --order --sort | Table          |
| t4 schedule:list     | Lists schedules                                |                                      | --fields --filter --format --order --sort | Table          |
| t4 transfer:list     | Lists transfers                                |                                      | --fields --filter --format --order --sort | Table          |
| t4 user:get          | Gets details about a user                      | {users*}                             | --fields --format --order --sort          | Table          |
| t4 user:list         | List users                                     |                                      | --fields --filter --format --order --sort | Table          |
| t4 whoami            | Displays information about the auth'd user     |                                      | --fields --format                         | Table          |

## Output

Using the --format flag, you have the ability to format output with the following options:

* count - returns the number of results
* csv - returns the results as a comma deliniated rows
* id - returns only the ids of the results. If selected you must either not use the fields option (sticking with the defaults) or ensure to include the id as a field.
* json - returns the results json encoded
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