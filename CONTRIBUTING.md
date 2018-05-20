# How to Contribute

If you're interested in contributing, take a look at the general [contributor's guide](https://github.com/Microsoft/ApplicationInsights-Home/blob/master/CONTRIBUTING.md) first.

## Build and Test locally

1. Run `compose install` to install all dependencies.
2. Change to docker directory: `cd docker`
3. Run `docker-compose up -d`. This step assumes you have docker installed and configured.
4. Configure WordPress and Application Insights plugin at http://localhost:8000
    a. Activate the plugin through the 'Plugins' menu in WordPress.
    b. Go to Settings -> Application Insights and enter the Instrumentation Key you received from http://portal.azure.com. Use direct link https://ms.portal.azure.com/#create/Microsoft.AppInsights to create a new Application Insights resource



## Shutdown and cleanup
The command `docker-compose down` removes the containers and default network, but preserves your WordPress database.

The command `docker-compose down --volumes` removes the containers, default network, and the WordPress database.


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