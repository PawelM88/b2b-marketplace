# Request to external system from Zed layer

Modules in the Client, Glue, Yves and Zed layers.

The module name is OutboundRequest and for Glue it is OutboundRequestsRestApi.

The task of these modules is to send a request from Yves and Glue to the external system and display the response. This
is possible thanks to the connection of Yves and Glue with Zed using a common Client. The Zed business layer makes an
external request to the mocked server. The response is mapped and returned to Yves and Glue.

## Steps:

1. First, create Transfer Object for request and response. Create outbound_request.transfer.xml file in
   Pyz\Shared\OutboundRequest\Transfer folder.

* Remember to run: console transfer:generate

2. Create Yves module with all its content: Controller, Plugin nad Theme

* Remember to register route in Pyz\Yves\Router\RouterDependencyProvider

3. Create Client module for both Yves nad Glue.
4. Create Zed module with all its content.

* The external server URL, default method and timeout connect should be entered at the bottom of the config_default file
  located in config\Shared

````
# URLs and misc. config
$config[OutboundRequestConstants::OUTBOUND_REQUEST_GET_DATA_URL] = 'https://26c96adf-b4d3-4db2-9924-5333bce298d5.mock.pstmn.io/outboundRequest/test';
$config[OutboundRequestConstants::OUTBOUND_REQUEST_DEFAULT_METHOD] = 'GET';
$config[OutboundRequestConstants::OUTBOUND_REQUEST_CONNECT_TIMEOUT] = ['connect_timeout' => 5];
````

* Then You have to create OutboundRequestConstants Interface in Pyz\Shared\OutboundRequest

````
public const OUTBOUND_REQUEST_GET_DATA_URL = 'OUTBOUND_REQUEST_GET_DATA_URL';
public const OUTBOUND_REQUEST_DEFAULT_METHOD = 'OUTBOUND_REQUEST_DEFAULT_METHOD';
public const OUTBOUND_REQUEST_CONNECT_TIMEOUT = 'OUTBOUND_REQUEST_CONNECT_TIMEOUT';
````

5. Create Transfer Object for Glue response. Create outbound_requests_rest_api.transfer.xml file in
   Pyz\Shared\OutboundRequestRestApi\Transfer folder.

* Remember to run: console transfer:generate

6. Create Glue module with all its content.

* Remember the naming convention (plural form and RestApi suffix)
* Remember to register route in Pyz\Glue\GlueApplication\GlueApplicationDependencyProvider
* Endpoint for Postman GET:
  http://glue.de.spryker.local/outbound-request

## Tests

1. Test for OutboundRequest in Zed layer.

* After creating codeception.yml file run console: <b>docker/sdk cli -t</b> and then <b>codecept build -c
  tests/PyzTest/Zed/OutboundRequest</b>
* To run test, type: codecept run -c tests/PyzTest/Zed/OutboundRequest

## Troubleshooting

- It is possible that there may be error with the
  Pyz\Glue\OutboundRequestsRestApi\OutboundRequestsRestApiDependencyProvider class. This is because the getLocator()
  function cannot connect to the Client. To fix this you need to run console command:
  console dev:ide:generate-glue-auto-completion
- Sometimes it is good to clear cache. Run: console cache:empty-all
