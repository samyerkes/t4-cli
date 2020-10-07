# T4 CLI

| Command          | Description                    | Arguments                            | Flags                      | Default Format |
| ---------------- |--------------------------------|--------------------------------------|----------------------------|----------------|
| t4 configure     | Configures the CLI             |                                      |                            | None           |
| t4 channel:get   | Gets details about a channel   | {channel}                            | --fields --format          | table          |
| t4 channel:list  | List channel                   |                                      | --fields --filter --format | table          |
| t4 group:create  | Creates a group                | {groupname} {description?}           |                            |                |
| t4 group:delete  | Delets a group                 | {groupname}                          |                            |                |
| t4 group:list    | Lists groups                   | {user?}                              | --fields --filter --format | table          |
| t4 group:members | Returns the members of a group | {groupname}                          | --fields --filter --format | table          |
| t4 schedule:list | Lists schedules                |                                      | --fields --filter --format | table          |
| t4 user:get      | Gets details about a user      | {user}                               | --fields --format          | table          |
| t4 user:list     | List users                     |                                      | --fields --filter --format | table          |

## Output

You have the ability to format output from commands with the following options:

* count - returns the number of results
* csv - returns the results as a comma deliniated rows
* id - returns only the ids of the results. If selected you must either not use the fields option (sticking with the defaults) or ensure to include the id as a field.
* json - returns the results json encoded
* table - returns the results in an easy to read table.