# T4 CLI

Command architecture inspired by the [WP-CLI](https://wp-cli.org/) project.

| Command          | Description                                | Arguments                            | Flags                                     | Default Format |
| ---------------- |--------------------------------------------|--------------------------------------|-------------------------------------------|----------------|
| t4 configure     | Configures the CLI                         |                                      |                                           | None           |
| t4 channel:get   | Gets details about a channel               | {channel}                            | --fields --format                         | Table          |
| t4 channel:list  | List channel                               |                                      | --fields --filter --format --order --sort | Table          |
| t4 group:create  | Creates a group                            | {groupname} {description?}           |                                           | None           |
| t4 group:delete  | Delets a group                             | {groupname}                          |                                           | None           |
| t4 group:list    | Lists groups                               | {user?}                              | --fields --filter --format --order --sort | Table          |
| t4 group:members | Returns the members of a group             | {groupname}                          | --fields --filter --format --order --sort | Table          |
| t4 key:list      | List API keys                              |                                      | --fields --filter --format --order --sort | Table          |
| t4 schedule:list | Lists schedules                            |                                      | --fields --filter --format --order --sort | Table          |
| t4 transfer:list | Lists transfers                            |                                      | --fields --filter --format --order --sort | Table          |
| t4 user:get      | Gets details about a user                  | {userDetails*}                       | --fields --format --order --sort          | Table          |
| t4 user:list     | List users                                 |                                      | --fields --filter --format --order --sort | Table          |
| t4 whoami        | Displays information about the auth'd user |                                      | --fields --format                         | Table          |

## Output

Using the --format flag, you have the ability to format output with the following options:

* count - returns the number of results
* csv - returns the results as a comma deliniated rows
* id - returns only the ids of the results. If selected you must either not use the fields option (sticking with the defaults) or ensure to include the id as a field.
* json - returns the results json encoded
* table - returns the results in an easy to read table.