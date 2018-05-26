# How to Contribute

If you're interested in contributing, take a look at the general [contributor's guide](https://github.com/Microsoft/ApplicationInsights-Home/blob/master/CONTRIBUTING.md) first.

## Build and Test locally

1. Run `composer install` to install all dependencies.
2. Change to docker directory: `cd docker`
3. Run `docker-compose up -d`. This step assumes you have docker installed and configured.
4. Configure WordPress and Application Insights plugin at http://localhost:8000
    a. Activate the plugin through the 'Plugins' menu in WordPress.
    b. Go to Settings -> Application Insights and enter the Instrumentation Key you received from http://portal.azure.com. Use direct link https://ms.portal.azure.com/#create/Microsoft.AppInsights to create a new Application Insights resource

## Development alongside the PHP SDK

1. Replace `"microsoft/application-insights": ">=0.4.2"` with `"microsoft/application-insights": "@dev"` in `composer.json`.
2. Add to `composer.json`:
    ``` json
        "repositories": {
        "dev-package": {
          "type": "path",
          "url": "../php",
          "options": {
            "symlink": false
          }
        }
      }
    ```
3. Ensure that path in `"url": "../php"` points to the root of Application Insights PHP SDK.
4. Run `composer update` after every change you want to take from PHP SDK repository.
    **Note:** mirroring is set for wordpress running in docker being able to pick up files correctly.

## Changelog

Please include changelog update with every pull request. Changelog is tracked in [README.txt](README.txt).

## Shutdown and cleanup

The command `docker-compose down` removes the containers and default network, but preserves your WordPress database.

The command `docker-compose down --volumes` removes the containers, default network, and the WordPress database.

## How to release a new version

This is a section for maintainers.

See instructions here: https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/

```
svn co https://plugins.svn.wordpress.org/application-insights application-insights
cd application-insights/
rm -rf trunk/
mkdir trunk
cp -r ../../wordpress/ trunk/
cd trunk/
rm -rf .gitignore 
rm -rf .gitattributes
rm -rf .git
svn add trunk/*
svn ci -m "updated to the latest version" --username ApplicationInsights --password ""
```

## Contributing

This project welcomes contributions and suggestions. Most contributions require you to
agree to a Contributor License Agreement (CLA) declaring that you have the right to,
and actually do, grant us the rights to use your contribution. For details, visit
https://cla.microsoft.com.

When you submit a pull request, a CLA-bot will automatically determine whether you need
to provide a CLA and decorate the PR appropriately (e.g., label, comment). Simply follow the
instructions provided by the bot. You will only need to do this once across all repositories using our CLA.

This project has adopted the [Microsoft Open Source Code of Conduct](https://opensource.microsoft.com/codeofconduct/).
For more information see the [Code of Conduct FAQ](https://opensource.microsoft.com/codeofconduct/faq/)
or contact [opencode@microsoft.com](mailto:opencode@microsoft.com) with any additional questions or comments.