[Home](index.md)
#Routes

How to add CRUD routes for doctrine entities.

##Adding a CRUD routes

Firstly in your applications routing you need to specify the entities you would like to generate CRUD routes for.

```yaml
post_api:
    resource: 'AppBundle\Entity\Post'
    type: crudApi
    prefix: /api
        defaults:
            config:
                returnType: Json
                entity: 'AppBundle\Entity\Post'
                api: true
    
post_views:
    resource: 'AppBundle\Entity\Post'
    type: crud
    defaults:
        config:
            returnType: TwigHtml
            entity: 'AppBundle\Entity\Post'
            api: false
```
The config above adds the crud routes for an JSON api and website for an entity called Post. 

Then like that you will have CRUD actions for the entity though the following routes:

New `/blog/new` and `/api/blog/new`

View `/blog/1` and `/api/blog/1`

Update/edit `/blog/1/edit` and `/api/blog/1/edit`

Delete `/blog/1/delete` and `/api/blog/1/delete`

Index `/blog` and `/api/blog`

##Black listing routes

To remove routes for a certain entity do following.

Go into your `config.yml` and specify the following config

```yaml
fast_controller:
    api:
        entities:
            'AppBundle\Entity\Post':
                black_listed_routes: ['view']

    view:
        entities:
            'AppBundle\Entity\Post':
                black_listed_routes: ['edit', 'delete']
```

The config above disable the api routes for viewing the Post entity and disables the edit and delete routes for views.

To black list other routes just enter there key in array on the `black_listed_routes` key.

Here is a list of the keys:

| Route Name | key    |
|------------|--------|
| View       | view   |
| Delete     | delete |
| New        | new    |
| Edit       | edit   |
| Index      | index  |
