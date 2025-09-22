# Community First Construction Essentials

Custom Gutenberg blocks and essential functions for the Community First Construction website.

## Requirements
- WordPress 5.8+
- PHP 7.4+

## Development
- Place plugin in `wp-content/plugins/community-first-construction-essentials/`
- Activate from WP Admin > Plugins

## Automatic Updates
This plugin already includes the Plugin Update Checker (PUC) library and is configured in `community-first-construction-essentials.php` to fetch updates from the repository:
- File: `wp-content/plugins/community-first-construction-essentials/community-first-construction-essentials.php`
- Configured repo URL: `https://github.com/johncrislasta/community-first-construction-essentials`
- Branch: `main`
- For private repos, you can optionally set a Personal Access Token via `$update_checker->setAuthentication( 'YOUR_GITHUB_TOKEN' );` (classic token with repo scope). Do NOT commit your token.

### Release workflow
- Bump the `Version` header and the `CFCE_VERSION` constant in `community-first-construction-essentials.php` (e.g., 1.0.2.4).
- Commit and push your changes to the configured branch.
- Create a GitHub release or tag that matches your version (e.g., `v1.0.2.4` or `1.0.2.4`).
- In WordPress Admin, go to Dashboard > Updates and click "Check Again". The update should appear for this plugin.

Notes:
- Ensure the plugin folder name matches the slug `community-first-construction-essentials`.
- Consider setting the `Update URI` header to a non-wp.org value to opt out of wp.org updates.

## Gutenberg Blocks
- The core class sets up a hook to register blocks. Add your blocks in `build/` and register via `register_block_type()`.
- You can use `@wordpress/scripts` for building blocks.

## License
GPL v2 or later
