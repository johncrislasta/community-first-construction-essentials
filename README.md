# Community First Construction Essentials

Custom Gutenberg blocks and essential functions for the Community First Construction website.

## Requirements
- WordPress 5.8+
- PHP 7.4+

## Development
- Place plugin in `wp-content/plugins/community-first-construction-essentials/`
- Activate from WP Admin > Plugins

## Automatic Updates (without Appsero)
This plugin uses the [Plugin Update Checker (PUC)](https://github.com/YahnisElsts/plugin-update-checker) library to fetch updates directly from a Git repository (e.g., GitHub).

### 1) Add the PUC library
Option A: Manual
- Download the library from https://github.com/YahnisElsts/plugin-update-checker
- Place it into: `wp-content/plugins/community-first-construction-essentials/plugin-update-checker/`
- Ensure the file exists: `plugin-update-checker/plugin-update-checker.php`

Option B: Composer (if you use Composer)
```bash
composer require yahnis-elsts/plugin-update-checker
```
Then require Composer's autoload or adjust the path accordingly.

Option C: Git Submodule
```bash
git submodule add https://github.com/YahnisElsts/plugin-update-checker.git plugin-update-checker
```

### 2) Configure repository URL
Edit `community-first-construction-essentials.php` and set your repo URL:
```php
$cfce_repo_url = 'https://github.com/YOUR_ORG/YOUR_REPO/';
$update_checker->setBranch( 'main' ); // Change if your default branch differs
```
- For private repos, uncomment `setAuthentication('YOUR_GITHUB_TOKEN')`. Do NOT commit your token.

### 3) Release workflow
- Bump the Version header in `community-first-construction-essentials.php` (e.g., 1.0.1).
- Commit and push.
- Create a GitHub release or tag that matches your version (e.g., `v1.0.1` or `1.0.1`).
- Go to WP Admin > Dashboard > Updates and click "Check Again". The update should appear.

Notes:
- Ensure the plugin folder name matches the slug `community-first-construction-essentials`.
- Consider setting the `Update URI` header to a non-wp.org value to opt out of wp.org updates.

## Gutenberg Blocks
- The core class sets up a hook to register blocks. Add your blocks in `build/` and register via `register_block_type()`.
- You can use `@wordpress/scripts` for building blocks.

## License
GPL v2 or later
