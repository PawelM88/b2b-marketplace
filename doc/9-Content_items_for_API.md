# Glue API: Retrieve specific Content item

New endpoint allows retrieving information about specific content item based on its key.

To retrieve information about a content item, send the request:

```http request
http://glue.de.spryker.local/content-items/{{content_item_key}}
```

Parameter `{{content_item_key}}` is a unique identifier of the content item to retrieve.

## Get the content item key

Sending the following requests will give the content of the Cms Pages or Page. There can be found content item key.

```http request
http://glue.de.spryker.local/cms-pages
```

or

```http request
http://glue.de.spryker.local/cms-pages/10014bd9-4bba-5a54-b84f-31b4b7efd064
```

## Response

Response sample: retrieve content item with key `apl-4`
```json
{
    "data": {
        "type": "content-items",
        "id": null,
        "attributes": {
            "idContent": 17,
            "term": "Abstract Product List",
            "parameters": {
                "id_product_abstracts": [
                    298,
                    69,
                    140,
                    237,
                    239,
                    258
                ]
            }
        },
        "links": {
            "self": "http://glue.de.spryker.local/content-items?api_key=aec41f71dcef3a0d63922b0af5b46765"
        }
    }
}
```
## Possible errors
| Code                        | Reason                       | 
|-----------------------------|------------------------------|
| 2201                        | Content item not found.      | 
| 2202                        | Content item key is missing. |
