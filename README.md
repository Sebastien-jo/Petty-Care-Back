# Petty-Care-Back
![image](https://user-images.githubusercontent.com/73281588/173239149-6cb44457-b5f8-4961-b54c-6d89119def65.png)

## Prerequisites
- [PHP 8.1](https://www.php.net/downloads.php)
- [Docker](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download)

## How to install project
- clone this repo `git clone https://github.com/Sebastien-jo/Petty-Care-Back/tree/back/master`
- use the command `make install`
(*This command will create all containers needed, start your locale server and migrate all enttities in your database*)

## Workflow
### Branch naming
- For each task, create a branch with a prefix "back/" and define the task (ex: `git checkout -b back/create-new-file`)
### Commits
- Try to have only one commit per branch
- name your commit with a short explanation of what this commit do (ex: `git commit -m "create Makefile"`)
### PR
- When you make a PR try to be clear in your description
- Ask reviewers concerned by this PR (team back)
