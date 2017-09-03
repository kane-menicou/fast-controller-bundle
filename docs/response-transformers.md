# Response Transformers

Response transformers are custom transformer which transform entities into valid responses for your routes.

The bundle comes with the following preconfigured:

| Format      | returnType | API? |
|-------------|------------|------|
| JSON        | Json       | Yes  |
| Xml         | Xml        | Yes  |
| HTML (Twig) | TwigHtml   | No   |

## Adding a custom Response Transformer

Create your response transformer

For APIs:
```php
<?php

namespace AppBundle\ResponseTransformer;

use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;

class MyCustomResponseTransformer implements ApiResponseTransformerInterface
{
        /**
         * {@inheritdoc}
         */
        public function transform(array $dataArray): string
        {
            return json_encode($dataArray);
        }
    
        /**
         * @param string $data
         *
         * @return array
         */
        public function reverseTransform(string $data): array
        {
            return json_decode($data, true);
        }
    
        /**
         * @return string
         */
        public function getName(): string
        {
            return 'MyCustomResponseTransformer';
        }
}
```

For HTML views:
```php
<?php

namespace AppBundle\ResponseTransformer;

use KaneMenicou\FastControllerBundle\Model\ViewResponseTransformerInterface;

class MyCustomResponseTransformer implements ViewResponseTransformerInterface
{
        /**
         * {@inheritdoc}
         */
        public function transform(array $dataArray, string $method): string
        {
            return json_encode($dataArray);
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return 'MyCustomResponseTransformer';
        }
}
```

Then define your custom response transformer in the service container (services.yml|.xml|.php).

For APIs:
```yaml
    app_bundle.response_transformer.json:
        class: AppBundle\ResponseTransformer\MyCustomResponseTransformer
        tags:
          - { name: fast_controller.api_response_transformer }
```

For HTML views:
```yaml
    app_bundle.response_transformer.json:
        class: AppBundle\ResponseTransformer\MyCustomResponseTransformer
        tags:
          - { name: fast_controller.view_response_transformer }
```

Then in the return type for your crud route you will be able to use the name you defined earlier.

```yaml
post:
    resource: 'AppBundle\Entity\Post'
    type: crudApi
        defaults:
            config:
                returnType: MyCustomResponseTransformer
                entity: 'AppBundle\Entity\Post'
                api: true
```
