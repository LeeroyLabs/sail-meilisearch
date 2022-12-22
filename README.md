# SailCMS - MeiliSearch Adapter

This is the official MeiliSearch adapter for SailCMS. This adapters works like every other adapters for search. For the documentation on that, please read the search section of the SailCMS documentation.



## Installing

```bash
php sail install:official leeroy/sail-meilisearch
```

This will install the package using composer and then update your composer file to autoload the package.

If you wish to install it manually, you and perform the following

```bash
composer require leeroy/sail-meilisearch
```

After that, you can add `Leeroy\\Search\\MeiliSearch` to the search section of the sailcms property of your composer.json file. It should look something like this:

```json
"sailcms": {
  "containers": ["Spec"],
  "modules": [],
  "search": {
    "meilisearch": "Leeroy\\Search\\MeiliSearch\\Adapter"
  }
}
```



## Configuration

When installed, you need to add the following to your `.env` file.

```
SEARCH_ENGINE=meilisearch
MEILI_HOST=yourmeilihost
MEILI_PORT=7700
MEILI_INDEX=default_index
MEILI_MASTER_KEY=your_master_key
```



You can now enjoy meilisearch on your site.
