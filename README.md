# T4 CLI

Command architecture inspired by the [WP-CLI](https://wp-cli.org/) and [AWS-CLI](https://docs.aws.amazon.com/cli/index.html) projects.

| Command              | Description                                       | Arguments                                                   | Command Specific Flags                                                         | Default Format |
| -------------------- |---------------------------------------------------|-------------------------------------------------------------|--------------------------------------------------------------------------------|----------------|
| t4 about             | Get details about the application, host and os    |                                                             |                                                                                | Table          |
| t4 channel:get       | Get a list of channels                            | {details?*}                                                 | -m --microsite                                                                 | Table          |
| t4 configure         | Configures the CLI                                |                                                             |                                                                                | None           |
| t4 contenttypes:get  | Gets details about a content type                 | {details?*}                                                 |                                                                                | Table          |
| t4 group:attach      | Attaches a list of users to a group               | {group} {users*}                                            |                                                                                | None           |
| t4 group:create      | Creates a group                                   | {groupname} {description?}                                  |                                                                                | None           |
| t4 group:delete      | Deletes a group                                   | {group}                                                     |                                                                                | None           |
| t4 group:detach      | Detaches a list of users from a group             | {group} {users*}                                            |                                                                                | None           |
| t4 group:get         | Gets details about a group                        | {details?*}                                                 |                                                                                | Table          |
| t4 group:members     | Returns the members of a group                    | {details*}                                                  |                                                                                | Table          |
| t4 group:update      | Updates details about a group                     | {details?*}                                                 | --name --description --emailAddress --defaultPreviewChannel --enabled          | Success        |
| t4 key:get           | Get a list of API keys                            | {details?*}                                                 |                                                                                | Table          |
| t4 layout:get        | Get a list of layouts                             | {details?*}                                                 |                                                                                | Table          |
| t4 navigation:get    | Get a list of navigation items                    | {details?*}                                                 |                                                                                | Table          |
| t4 schedule:get      | Get a list of scheduled jobs                      | {details?*}                                                 |                                                                                | Table          |
| t4 transfer:get      | Get a list of transfers                           | {details?*}                                                 |                                                                                | Table          |
| t4 user:create       | Creates a new user                                | {firstName} {lastName} {username} {password} {emailAddress} | --role --authentication --enabled --defaultLang                                | Success        |
| t4 user:get          | Gets details about a user                         | {details?*}                                                 |                                                                                | Table          |
| t4 user:delete       | Deletes one or more users                         | {details?*}                                                 |                                                                                | Success        |
| t4 user:group        | Gets group details for one or more users.         | {details?*}                                                 |                                                                                | Table          |
| t4 user:update       | Updates details about a user                      | {details?*}                                                 | --firstName --lastName --emailAddress --defaultLang --enabled --role --deleted | Success        |
| t4 whoami            | Displays information about the authenticated user |                                                             |                                                                                | Table          |

## Global flags

### Dry run

Use the `--dry-run` flag to run the operation and show the output, but not send requests that may modify application records.

```
t4 group:create my-test-group "My test group" --dry-run
```

### Fields

Use the `--fields` flag to return specific fields from a request. Using this flag will override whatever default fields are set to be returned by each command. See `--labels` to understand which fields are available for each command.

```
t4 users:get --fields=id,username,firstName,lastName,emailAddress
```

### Filter

Use the `--filter` flag to return only certain records that match a particular filter.

```
t4 users:get --filter=role:admin
```
### Format

Using the `--format` flag you have the ability to format output with the following options:

* count - returns the number of results
* csv - returns the results as comma deliniated rows
* id - returns only the ids of the results (ensure you are returning the id field of each record)
* json - returns the results json encoded
* table - returns the results in an easy to read table
* text - returns the results for the first attribute of each returned record as text

```
t4 users:get --format=count
```

### Labels

Each `get` type of command comes with default returned fields, but there may be circumstances where you need to use other fields. To find out the available fields for a particular command pass the `-l` or `--labels` flag.

```
t4 users:get --labels
```

### Order

Use the `--order` flag to order the returned records in asc or desc order. This is used in combination with the `--sort` flag. By default the order will be `desc` so you'll only really need to use this flag when needing to be purposefully explicit or when ordering in `asc` order.

```
t4 users:get --sort=username --order=asc
```

### Profile

If you have user accounts on different instances of T4 you can use the `--profile` flag to run a command against a specific profile. Profiles are defined in a `.t4` configuration file. By default this tool will use the configuration under a profile named, "default." 

Additional profiles can be appended in the `.t4` file and defined as:

```
[profileName]
t4_url="https://cms.school.edu"
t4_webapi="https://cms.school.edu/terminalfour/rs"
t4_token="xxxxxxxxx"
```

To switch your profile set a new `T4_PROFILE` environment variable as the profile you want to use.

```
export T4_PROFILE=profileName
```

Alternatively you can use the `--profile=` or `-p` flag to switch your profile for a one off command.

An inline command option for profile will take precence over an environment variable, if neither the inline profile or environment variable is set the 'default' profile will be used.

```
t4 users:get -p profileName
```

### Sort

Use the `--sort` flag to sort the returned records based on a specified field.

```
t4 users:get --sort=username
```

## Command chaining

The commands have been architected so you can do some interesting chaining using the --format=id and --format=text option. Here are some ideas to get you started.


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

Add a user to the same groups that another user is a part of
```
for group in $(t4 user:groups user1 --format=id); do t4 group:attach $group user2; done
```