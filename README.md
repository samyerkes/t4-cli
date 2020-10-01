# T4 CLI

| Command          | Description                    | Arguments                            | Flags             |
| ---------------- |--------------------------------|--------------------------------------|-------------------|
| t4 group:create  | Creates a group                | {groupname} {description} (optional) |                   |
| t4 group:delete  | Delets a group                 | {groupname}                          |                   |
| t4 group:list    | Lists groups                   | {user} (optional)                    | --fields --filter |
| t4 group:members | Returns the members of a group | {groupname}                          | --fields --filter |
| t4 schedule:list | Lists schedules                |                                      | --fields --filter |
| t4 user:get      | Gets details about a user      | {user}                               | --fields          |
| t4 user:list     | List users                     |                                      | --fields --filter |