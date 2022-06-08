# API documentation

[[_TOC_]]

## Authorization

### POST `/auth/login`

Parameters:

- phone (required)
- password (required)

Http request example:

```
{
	"phone": "901234567",
	"Password": "some_password"
}
```

Server response:

```
{
    "data": {
        "id": "96668bce-90b6-470a-8f40-180547c13fe3",
        "name": "John Doe",
        "phone": "901234567"
    },
    "meta": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9maW5hbmNlLWFwaVwvdjFcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjUzNzMzNDM5LCJleHAiOjE2NTM3MzcwMzksIm5iZiI6MTY1MzczMzQzOSwianRpIjoiTlBZZWFIa0RSZW5LTHIyWSIsInN1YiI6Ijk2NjY4YmNlLTkwYjYtNDcwYS04ZjQwLTE4MDU0N2MxM2ZlMyIsInBydiI6IjIxZjE4Y2Y0NTQxMDMyOTU0NWE2MzQwOWEyMmU0ODBlNjY0Yjc5ZWYifQ.7DweDFdphN-3tFxfXOblDyns8i6JfcATPxUH1V8irD4"
    }
}
```

### POST `/auth/logout`

without parameter

Server response:

```
{
    "message": "Successfully logged out"
}
```

### POST `/auth/refresh`

without parameter

Server response:

```
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9maW5hbmNlLWFwaVwvdjFcL2F1dGhcL3JlZnJlc2giLCJpYXQiOjE2NTM3MzM2MzEsImV4cCI6MTY1MzczNzI4NiwibmJmIjoxNjUzNzMzNjg2LCJqdGkiOiJDV1doVGlUQkR0Z05vakJHIiwic3ViIjoiOTY2NjhiY2UtOTBiNi00NzBhLThmNDAtMTgwNTQ3YzEzZmUzIiwicHJ2IjoiMjFmMThjZjQ1NDEwMzI5NTQ1YTYzNDA5YTIyZTQ4MGU2NjRiNzllZiJ9.AKNVc8kWoYtt_sczlUeQrpl5-z8txDcuY-GwgmfO3G8",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### POST `/auth/me`

without parameter

Server response:

```
{
    "data": {
        "id": "96668bce-90b6-470a-8f40-180547c13fe3",
        "name": "John Doe",
        "phone": "901234567",
        "lang": "en",
        "created_at": "2022-05-27 22:16:04",
        "created_by": null,
        "updated_at": "2022-05-27 22:16:04",
        "updated_by": null,
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "role": {
            "id": "96668bce-9edd-4e36-968f-72dc6a3f4b2a",
            "name": "CEO",
            "permissions": [
                {
                    "id": "96668bce-a7d7-4921-afad-bca0cff273e6",
                    "name": "See users"
                },
                {
                    "id": "96668bce-ad19-4292-a8e2-cbe6b45c9091",
                    "name": "Create user"
                },
                {
                    "id": "96668bce-b192-446d-a770-bcf69e4f93d9",
                    "name": "See user"
                },
                ...
            ]
        }
    }
}
```

## Administration of users

### GET `/users`

Parameters:

- search (optional, any string to search from phone and name fields)
- name (optional, for filtering by name)
- phone (optional, for filtering by phone)
- lang (optional, for filtering by language)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"name": "Some name",
	"phone": "901234567",
	"lang": "uz",
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        {
            "id": "9668005b-351b-45d5-b064-c1696c9f608d",
            "name": "New User",
            "phone": "912345678"
        },
		...
    ],
    "links": {
        "first": "<API_URL>/users?page=1",
        "last": "<API_URL>/users?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/users?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/v1/users",
        "per_page": "25",
        "to": 2,
        "total": 2
    }
}
```

### POST `/users`

Parameters:

- phone (required, integer, unique)
- name (required)
- password (required, min length 6)
- lang (optional, value can be one of 'uz','ru','en')
- role (required, value can be one of 'CEO', 'CFO', 'Manager', 'Cashier')

Http request example:

```
{
	"phone": "934567890",
	"name": "Some name",
	"password": "pas456",
    "lang": "uz",
    "role": "CFO
}
```

Server response:

```
{
    "data": {
        "id": "966802de-5321-4e1c-9c4f-cacab61e55d8",
        "name": "Some name",
        "phone": "934567890",
        "lang": null,
        "created_at": "2022-05-28 15:44:48",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 15:44:48",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "role": {
            "id": "96668bce-a082-42d1-99cc-1ee473c48e3d",
            "name": "CFO"
        }
    }
}
```

### GET `/users/{id}`

No params

Server response:

```
{
    "data": {
        "id": "966802de-5321-4e1c-9c4f-cacab61e55d8",
        "name": "Some name",
        "phone": "934567890",
        "lang": "en",
        "created_at": "2022-05-28 15:44:48",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 15:44:48",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "role": {
            "id": "96668bce-a082-42d1-99cc-1ee473c48e3d",
            "name": "CFO"
        }
    }
}
```

### PUT `/users/{id}`

Parameters:

- phone (optional, integer, unique)
- name (optional)
- password (optional, min length 6)
- lang (optional, value can be one of 'uz','ru','en')
- role (required, value can be one of 'CEO', 'CFO', 'Manager', 'Cashier')

Http request example:

```
{
	"phone": "945678901",
	"name": "Other User",
	"password": "pass789",
    "lang": "ru",
    "role": "Manager
}
```

Server response:

```
{
    "data": {
        "id": "966802de-5321-4e1c-9c4f-cacab61e55d8",
        "name": "Other User",
        "phone": "945678901",
        "lang": "ru",
        "created_at": "2022-05-28 15:44:48",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 15:49:27",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "role": {
            "id": "96668bce-a1c7-4477-b484-99fdb64232a2",
            "name": "Manager",
            "permissions": []
        }
    }
}
```

### DELETE `/users/{id}`

No params

Server response

```

```

## Seeing roles and permissions, syncing permissions to role

### GET `/roles`

Parameters:

- search (optional, any string to search from name field)
- with_permissions (optional, boolean, true)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"with_permissions": true,
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668bce-9edd-4e36-968f-72dc6a3f4b2a",
            "name": "CEO"
        },
        {
            "id": "96668bce-a082-42d1-99cc-1ee473c48e3d",
            "name": "CFO"
        },
        ...
    ],
    "links": {
        "first": "<API_URL>/roles?page=1",
        "last": "<API_URL>/roles?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/roles?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/roles",
        "per_page": "25",
        "to": 4,
        "total": 4
    }
}
```

### GET `/roles/{id}`

No params

Server response:

```
{
    "data": {
        "id": "96668bce-9edd-4e36-968f-72dc6a3f4b2a",
        "name": "CEO",
        "permissions": [
            {
                "id": "96668bce-a7d7-4921-afad-bca0cff273e6",
                "name": "See users"
            },
            {
                "id": "96668bce-ad19-4292-a8e2-cbe6b45c9091",
                "name": "Create user"
            },
            {
                "id": "96668bce-b192-446d-a770-bcf69e4f93d9",
                "name": "See user"
            },
            ...
        ]
    }
}
```

### GET `/roles/{id}/permissions`

Parameters:

- search (optional, any string to search from phone and name fields)
- with_roles (optional, boolean, true)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"with_roles": true,
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668bce-a7d7-4921-afad-bca0cff273e6",
            "name": "See users"
        },
        {
            "id": "96668bce-ad19-4292-a8e2-cbe6b45c9091",
            "name": "Create user"
        },
        {
            "id": "96668bce-b192-446d-a770-bcf69e4f93d9",
            "name": "See user"
        },
        ...
    ],
    "links": {
        "first": "<API_URL>/roles/96668bce-9edd-4e36-968f-72dc6a3f4b2a/permissions?page=1",
        "last": "<API_URL>/roles/96668bce-9edd-4e36-968f-72dc6a3f4b2a/permissions?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/roles/96668bce-9edd-4e36-968f-72dc6a3f4b2a/permissions?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/roles/96668bce-9edd-4e36-968f-72dc6a3f4b2a/permissions",
        "per_page": "25",
        "to": 19,
        "total": 19
    }
}
```

### PUT `/roles/{id}/permissions`

Parameters:

- permissions (required, comma separated permissions inside the string)

Http request example:

```
{
	"permissions":"See user,See roles,Delete user"
}
```

Server response:

```
{
    "data": {
        "id": "96668bce-a082-42d1-99cc-1ee473c48e3d",
        "name": "CFO",
        "permissions": [
            {
                "id": "96668bce-b192-446d-a770-bcf69e4f93d9",
                "name": "See user"
            },
            {
                "id": "96668bce-bc71-44d5-9dce-e73571a82bff",
                "name": "Delete user"
            },
            {
                "id": "96668bce-c1db-42d8-b4ac-9cef11113d64",
                "name": "See roles"
            }
        ]
    }
}
```

### GET `/permissions`

Parameters:

- search (optional, any string to search from phone and name fields)
- with_roles (optional, boolean, true)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"with_roles": true,
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668bce-a7d7-4921-afad-bca0cff273e6",
            "name": "See users"
        },
        {
            "id": "96668bce-ad19-4292-a8e2-cbe6b45c9091",
            "name": "Create user"
        },
        {
            "id": "96668bce-b192-446d-a770-bcf69e4f93d9",
            "name": "See user"
        },
		...
    ],
    "links": {
        "first": "<API_URL>/permissions?page=1",
        "last": "<API_URL>/permissions?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/permissions?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/permissions",
        "per_page": "25",
        "to": 19,
        "total": 19
    }
}
```

### GET `/permissions/{id}`

No params

Server response:

```
{
    "data": {
        "id": "96668bce-a7d7-4921-afad-bca0cff273e6",
        "name": "See users"
    }
}
```

## Administration of currencies

### GET `/currencies`

Parameters:

- search (optional, any string to search from code, ccy, ccynm_uz, ccynm_uzc, ccynm_ru and ccynm_en fields)
- code (optional, for filtering by code)
- ccy (optional, for filtering by ccy)
- ccynm_uz (optional, for filtering by ccynm_uz)
- ccynm_uzc (optional, for filtering by ccynm_uzc)
- ccynm_ru (optional, for filtering by ccynm_ru)
- ccynm_en (optional, for filtering by ccynm_en)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"code": 840,
	"ccy": "USD",
	"ccynm_uz": "AQSH dollari",
	"ccynm_uzc": "АҚШ доллари",
	"ccynm_ru": "Доллар США",
	"ccynm_en": "US Dollar",
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668bcf-1667-4c00-9e26-bd816c90f46a",
            "code": "860",
            "ccy": "UZS",
            "ccynm_uz": "O`zbek so`mi",
            "ccynm_uzc": "Ўзбек сўми",
            "ccynm_ru": "Узбекский сум",
            "ccynm_en": "Uzbek Sum"
        },
        {
            "id": "96668bcf-185e-4865-8b3a-27b3c9b04641",
            "code": "840",
            "ccy": "USD",
            "ccynm_uz": "AQSH Dollari",
            "ccynm_uzc": "АҚШ доллари",
            "ccynm_ru": "Доллар США",
            "ccynm_en": "US Dollar"
        },
		...
    ],
    "links": {
        "first": "<API_URL>/currencies?page=1",
        "last": "<API_URL>/currencies?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/currencies?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/currencies",
        "per_page": "25",
        "to": 2,
        "total": 2
    }
}
```

### POST `/currencies`

Parameters:

- code (required, integer)
- ccy (required, string)
- ccynm_uz (required, string)
- ccynm_uzc (required, string)
- ccynm_ru (required, string)
- ccynm_en (required, string)

Http request example:

```
{
	"code": "978",
    "ccy": "EUR",
    "ccynm_uz": "YEVRO",
    "ccynm_uzc": "EВРО",
    "ccynm_ru": "Евро",
    "ccynm_en": "Euro"
}
```

Server response:

```
{
    "data": {
        "id": "96680bea-4c0e-4261-9788-d8fd2da4a705",
        "code": "978",
        "ccy": "EUR",
        "ccynm_uz": "YEVRO",
        "ccynm_uzc": "EВРО",
        "ccynm_ru": "Евро",
        "ccynm_en": "Euro",
        "created_at": "2022-05-28 16:10:06",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:10:06",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/currencies/{id}`

No params

server response:

```
{
    "data": {
        "id": "96680bea-4c0e-4261-9788-d8fd2da4a705",
        "code": "978",
        "ccy": "EUR",
        "ccynm_uz": "YEVRO",
        "ccynm_uzc": "EВРО",
        "ccynm_ru": "Евро",
        "ccynm_en": "Euro",
        "created_at": "2022-05-28 16:10:06",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:10:06",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### PUT `/currencies/{id}`

Parameters:

- code (optional, integer)
- ccy (optional, string)
- ccynm_uz (optional, string)
- ccynm_uzc (optional, string)
- ccynm_ru (optional, string)
- ccynm_en (optional, string)

Http request example:

```
{
	"code": "643",
    "ccy": "RUB",
    "ccynm_uzc": "Россия рубли",
    "ccynm_ru": "Российский рубль",
    "ccynm_uz": "Rossiya rubli",
    "ccynm_en": "Russian Ruble"
}
```

Server response:

```
{
    "data": {
        "id": "96680bea-4c0e-4261-9788-d8fd2da4a705",
        "code": "643",
        "ccy": "RUB",
        "ccynm_uz": "Rossiya rubli",
        "ccynm_uzc": "Россия рубли",
        "ccynm_ru": "Российский рубль",
        "ccynm_en": "Russian Ruble",
        "created_at": "2022-05-28 16:10:06",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:14:57",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### DELETE `/currencies/{id}`

No params

```

```

## Administrations of firms

### GET `/firms`

Parameters:

- search (optional, any string to search from name)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668e9a-de90-4268-8d87-12ad9bcd7c90",
            "name": "Firm 1"
        },
        {
            "id": "96668ead-0606-4da9-aa51-8ae1c97fe21c",
            "name": "Firm 2"
        },
		...
    ],
    "links": {
        "first": "<API_URL>/firms?page=1",
        "last": "<API_URL>/firms?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/firms?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/firms",
        "per_page": "25",
        "to": 3,
        "total": 3
    }
}
```

### POST `/firms`

Parameters:

- name (required, string)

Http request example:

```
{
	"name": "Some Firm",
}
```

Server response:

```
{
    "data": {
        "id": "96680f65-96fb-4e90-9e99-0e067ef908a7",
        "name": "Some firm",
        "created_at": "2022-05-28 16:19:50",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:19:50",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/firms/{id}`

No params

Server response:

```
{
    "data": {
        "id": "96680f65-96fb-4e90-9e99-0e067ef908a7",
        "name": "Some firm",
        "created_at": "2022-05-28 16:19:50",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:19:50",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### PUT `/firms/{id}`

Parameters:

- name (optional, string)

Http request example:

```
{
	"name": "Some Firm",
}
```

Server response:

```
{
    "data": {
        "id": "96680f65-96fb-4e90-9e99-0e067ef908a7",
        "name": "OOO SOME FIRM",
        "created_at": "2022-05-28 16:19:50",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:23:19",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### DELETE `/firms/{id}`

No params

Server response:

```

```

## Administration of wallets

### GET `/wallets`

Parameters:

- search (optional, any string to search from name and project_api_url)
- name (optional, for filtering by name)
- project_api_url (optional, for filtering by project_api_url)
- currency_id (optional, uuid, for filtering by currency_id)
- parent_id (optional, uuid, for filtering by parent_id)
- firm_id (optional, uuid, for filtering by firm_id)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"name": "Name of wallet",
	"project_api_url": "Project API url",
	"currency_id: "96685e54-09a7-4807-9826-25dd4b08c463",
	"parent_id: "96685e54-09a7-4807-9826-25dd4b08c463",
	"firm_id: "96685e54-09a7-4807-9826-25dd4b08c463",
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96685fa5-206b-42f4-93eb-2c9c966441a6",
            "name": "Wallet 526",
            "project_api_url": null,
        },
        {
            "id": "9668607f-55ed-4b23-836f-789888f8686b",
            "name": "Wallet 526",
            "project_api_url": null,
        },
        ...
    ],
    "links": {
        "first": "<API_URL>/wallets?page=1",
        "last": "<API_URL>/wallets?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/wallets?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/wallets",
        "per_page": "25",
        "to": 3,
        "total": 3
    }
}
```

### POST `/wallets`

Parameters:

- name (required, string)
- project_api_url (optional, string)
- currency_id (required, uuid of currency)
- parent_id (optional, uuid of parent wallet)
- firm_id (optional, uuid of firm)
- user_ids (optional, string, comma separated uuids list of users)

Http request example:

```
{
	"name": "Some Wallet",
	"project_api_url": "https://api.someurl.uz/v1/some_method",
	"currency_id": "96685e54-09a7-4807-9826-25dd4b08c463",
	"parent_id": "96685e54-09a7-4807-9826-25dd4b08c463",
	"firm_id": "96685e54-09a7-4807-9826-25dd4b08c463",
	"user_ids": "96685f7d-840d-4582-9b02-d94a6f700548,9668605d-d602-4854-9eba-d7536f141237"
}
```

Server response:

```
{
    "data": {
        "id": "96687387-f959-4d2a-ab2c-dce3d797613e",
        "name": "Wallet 527",
        "project_api_url": "https://api.someurl.uz/v1/some_method",
        "currency": {
            "id": "96685e54-09a7-4807-9826-25dd4b08c463",
            "code": "860",
            "ccy": "UZS",
            "ccynm_uz": "O`zbek so`mi",
            "ccynm_uzc": "Ўзбек сўми",
            "ccynm_ru": "Узбекский сум",
            "ccynm_en": "Uzbek Sum"
        },
        "firm": null,
        "parent": null,
        "created_at": "2022-05-28 20:59:50",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 20:59:50",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "users": [
            {
                "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
                "name": "Owner",
                "phone": "901234567"
            }
        ]
    }
}
```

### GET `/wallets/{id}`

No params

Server response:

```
{
    "data": {
        "id": "96687387-f959-4d2a-ab2c-dce3d797613e",
        "name": "Wallet 527",
        "project_api_url": null,
        "currency": {
            "id": "96685e54-09a7-4807-9826-25dd4b08c463",
            "code": "860",
            "ccy": "UZS",
            "ccynm_uz": "O`zbek so`mi",
            "ccynm_uzc": "Ўзбек сўми",
            "ccynm_ru": "Узбекский сум",
            "ccynm_en": "Uzbek Sum"
        },
        "firm": null,
        "parent": null,
        "created_at": "2022-05-28 20:59:50",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 20:59:50",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "users": [
            {
                "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
                "name": "John Doe",
                "phone": "901234567"
            }
        ]
    }
}
```

### PUT `/wallets/{id}`

Parameters:

- name (required, string)
- project_api_url (optional, string)
- currency_id (required, uuid of currency)
- parent_id (optional, uuid of parent wallet)
- firm_id (optional, uuid of firm)

Http request example:

```
{
	"name": "Some Other Wallet",
	"project_api_url": "https://api.someurl.uz/v1/some_method",
	"currency_id": "96685e54-09a7-4807-9826-25dd4b08c463",
	"parent_id": "96685e54-09a7-4807-9826-25dd4b08c463",
	"firm_id": "96685e54-09a7-4807-9826-25dd4b08c463",
	"user_ids": "96685f7d-840d-4582-9b02-d94a6f700548,9668605d-d602-4854-9eba-d7536f141237"
}
```

Server response:

```
{
    "data": {
        "id": "96687387-f959-4d2a-ab2c-dce3d797613e",
        "name": "Wallet 527",
        "project_api_url": null,
        "currency": {
            "id": "96685e54-09a7-4807-9826-25dd4b08c463",
            "code": "860",
            "ccy": "UZS",
            "ccynm_uz": "O`zbek so`mi",
            "ccynm_uzc": "Ўзбек сўми",
            "ccynm_ru": "Узбекский сум",
            "ccynm_en": "Uzbek Sum"
        },
        "firm": null,
        "parent": null,
        "created_at": "2022-05-28 20:59:50",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 20:59:50",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "users": [
            {
                "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
                "name": "John Doe",
                "phone": "901234567"
            }
        ]
    }
}
```

### DELETE `/wallets/{id}`

No params

Server response:

```

```

### PUT `/wallets/{id}/users`

Parameters:

- user_ids (required, string, comma separated uuids list of users)

Http request example:

```
{
	"user_ids": "96685f7d-840d-4582-9b02-d94a6f700548,9668605d-d602-4854-9eba-d7536f141237"
}
```

Server response:

```
{
    "data": {
        "id": "96687387-f959-4d2a-ab2c-dce3d797613e",
        "name": "Wallet 527",
        "project_api_url": null,
        "currency": {
            "id": "96685e54-09a7-4807-9826-25dd4b08c463",
            "code": "860",
            "ccy": "UZS",
            "ccynm_uz": "O`zbek so`mi",
            "ccynm_uzc": "Ўзбек сўми",
            "ccynm_ru": "Узбекский сум",
            "ccynm_en": "Uzbek Sum"
        },
        "firm": null,
        "parent": null,
        "created_at": "2022-05-28 20:59:50",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 20:59:50",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "users": [
            {
                "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
                "name": "John Doe",
                "phone": "901234567"
            },
            {
                "id": "96685f7d-840d-4582-9b02-d94a6f700548",
                "name": "Usss 526",
                "phone": "987654123"
            },
            {
                "id": "9668605d-d602-4854-9eba-d7536f141237",
                "name": "Usssssaaaaa 526",
                "phone": "987654124"
            }
        ]
    }
}
```

### PUT `/wallets/{id}/users/{user_id}/detach`

No params

Server response:

```
{
    "data": {
        "id": "96687387-f959-4d2a-ab2c-dce3d797613e",
        "name": "Wallet 527",
        "project_api_url": null,
        "currency": {
            "id": "96685e54-09a7-4807-9826-25dd4b08c463",
            "code": "860",
            "ccy": "UZS",
            "ccynm_uz": "O`zbek so`mi",
            "ccynm_uzc": "Ўзбек сўми",
            "ccynm_ru": "Узбекский сум",
            "ccynm_en": "Uzbek Sum"
        },
        "firm": null,
        "parent": null,
        "created_at": "2022-05-28 20:59:50",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 20:59:50",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null,
        "users": [
            {
                "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
                "name": "John Doe",
                "phone": "901234567"
            },
            {
                "id": "9668605d-d602-4854-9eba-d7536f141237",
                "name": "Usssssaaaaa 526",
                "phone": "987654124"
            }
        ]
    }
}
```

## Administration of categories

### GET `/categories`

Parameters:

- search (optional, any string to search from name)
- name (optional, for filtering by name)
- wallet_id (optional, uuid, for filtering by wallet_id)
- parent_id (optional, uuid, for filtering by parent_id)
- color (optional, 'string', for filtering by color)
- bgcolor (optional, 'string', for filtering by bgcolor)
- type (optional, integer, for filtering by type, value can be 1 or 2)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
	"name":"Category 4",
    "wallet_id": "9668607f-55ed-4b23-836f-789888f8686b",
    "parent_id": "9668607f-55ed-4b23-836f-789888f8686b",
    "color": "#123789",
    "bgcolor":"#FEDEEE",
    "type": 2,
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        {
            "id": "9669a5df-8549-4aa7-b40b-f1e2f792b328",
            "name": "Category 2",
            "icon": "Some other icon",
            "color": "#FFFFFF",
            "bgcolor": "#000000",
            "type": 2
        },
        ...
    ],
    "links": {
        "first": "<API_URL>/categories?page=1",
        "last": "<API_URL>/categories?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/categories?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/categories",
        "per_page": "25",
        "to": 4,
        "total": 4
    }
}
```

### POST `/categories`

Parameters:

- name (required, string)
- icon (required, string)
- color (optional, string of HEX code, ex: #000000)
- bgcolor (optional, string of HEX code, ex: #FFFFFF)
- type (required, integer, value can be 1 or 2)
- parent_id (optional, uuid)
- wallet_id (required, uuid of wallet)

Http request example:

```
{
	"name":"Category 5",
    "icon": "Some-icon",
    "color": "#123789",
    "bgcolor":"#FEDEEE",
    "type": 1,
    "parent_id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
    "wallet_id": "9668607f-55ed-4b23-836f-789888f8686b"
}
```

Server response:

```
{
    "data": {
        "id": "9669c883-53dc-47b0-bd90-e752706b5de5",
        "wallet": {
            "id": "9668607f-55ed-4b23-836f-789888f8686b",
            "name": "Wallet 526",
            "project_api_url": null
        },
        "name": "Category 5",
        "icon": "Some-icon",
        "color": "#123789",
        "bgcolor": "#FEDEEE",
        "type": 1,
        "parent": {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        "children": [],
        "created_at": "2022-05-29 12:53:17",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-05-29 12:53:17",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/categories/{id}`

No params

Server response:

```
{
    "data": {
        "id": "9669c883-53dc-47b0-bd90-e752706b5de5",
        "wallet": {
            "id": "9668607f-55ed-4b23-836f-789888f8686b",
            "name": "Wallet 526",
            "project_api_url": null
        },
        "name": "Category 5",
        "icon": "Some-icon",
        "color": "#123789",
        "bgcolor": "#FEDEEE",
        "type": 1,
        "parent": {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        "children": [],
        "created_at": "2022-05-29 12:53:17",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-05-29 12:53:17",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### PUT `/categories/{id}`

Parameters:

- name (optional, string)
- icon (optional, string)
- color (optional, string of HEX code, ex: #000000)
- bgcolor (optional, string of HEX code, ex: #FFFFFF)
- type (optional, integer, value can be 1 or 2)
- parent_id (optional, uuid)
- wallet_id (optional, uuid of wallet)

Http request example:

```
{
	"name":"Category 7",
    "icon": "Some-other-icon",
    "color": "#139751",
    "bgcolor":"#AB00BA",
    "type": 2,
    "parent_id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
    "wallet_id": "9668607f-55ed-4b23-836f-789888f8686b"
}
```

Server response:

```
{
    "data": {
        "id": "9669c883-53dc-47b0-bd90-e752706b5de5",
        "wallet": {
            "id": "9668607f-55ed-4b23-836f-789888f8686b",
            "name": "Wallet 526",
            "project_api_url": null
        },
        "name": "Category 7",
        "icon": "Some-other-icon",
        "color": "#139751",
        "bgcolor": "#AB00BA",
        "type": 2,
        "parent": {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        "children": [],
        "created_at": "2022-05-29 12:53:17",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-05-29 12:57:58",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### DELETE `/categories/{id}`

No params

Server response:

```

```

## Administration of payment methods

### GET `/payment_methods`

Parameters:

- search (optional, any string to search from name)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"search": "Something",
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "96668e9a-de90-4268-8d87-12ad9bcd7c90",
            "name": "Cash"
        },
        {
            "id": "96668ead-0606-4da9-aa51-8ae1c97fe21c",
            "name": "UZCARD"
        },
		...
    ],
    "links": {
        "first": "<API_URL>/payment_methods?page=1",
        "last": "<API_URL>/payment_methods?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/payment_methods?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/payment_methods",
        "per_page": "25",
        "to": 3,
        "total": 3
    }
}
```

### POST `/payment_methods`

Parameters:

- name (required, string)

Http request example:

```
{
	"name": "VISA CARD",
}
```

Server response:

```
{
    "data": {
        "id": "96680f65-96fb-4e90-9e99-0e067ef908a7",
        "name": "VISA CARD",
        "created_at": "2022-05-28 16:19:50",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:19:50",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/payment_methods/{id}`

No params

Server response:

```
{
    "data": {
        "id": "96680f65-96fb-4e90-9e99-0e067ef908a7",
        "name": "VISA CARD",
        "created_at": "2022-05-28 16:19:50",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:19:50",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### PUT `/payment_methods/{id}`

Parameters:

- name (optional, string)

Http request example:

```
{
	"name": "MasterCard",
}
```

Server response:

```
{
    "data": {
        "id": "96680f65-96fb-4e90-9e99-0e067ef908a7",
        "name": "MasterCard",
        "created_at": "2022-05-28 16:19:50",
        "created_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "updated_at": "2022-05-28 16:23:19",
        "updated_by": {
            "id": "96668bce-90b6-470a-8f40-180547c13fe3",
            "name": "John Doe",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### DELETE `/payment_methods/{id}`

No params

Server response:

```

```

## Administration of transactions

### GET `/transactions`

Parameters:

- wallet_id (optional, uuid)
- category_id (optional, uuid)
- payment_method_id (optional, uuid)
- date (optional, date format: YYYY-mm-dd)
- debit (optional, float)
- credit (optional, float)
- note (optional, string)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"wallet_id": "96687141-c27e-43ce-812e-2a4300858ac0",
    "category_id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
    "payment_method_id": "966a0a47-260a-43b8-98b5-a9de46681d3d",
    "date":"2022-06-05",
    "wallet_id":"96687141-c27e-43ce-812e-2a4300858ac0",
    "credit":79000,
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "9676fc7b-f33c-412d-a6a7-4951623dd936",
            "date": "2022-06-05",
            "debit": "150000",
            "credit": null,
            "image": null,
            "note": null
        },
        {
            "id": "9676fcf1-9c2f-453d-9753-adc399ec1a89",
            "date": "2022-06-05",
            "debit": null,
            "credit": "150000",
            "image": null,
            "note": null
        },
        ...
    ],
    "links": {
        "first": "<API_URL>/transactions?page=1",
        "last": "<API_URL>/transactions?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/transactions?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/transactions",
        "per_page": "25",
        "to": 19,
        "total": 19
    }
}
```

### POST `/transactions`

Parameters:

- type (required, integer, 1 - Wallet, 2 - Firm)
- wallet_id (required if type==1, uuid)
- firm_id (required if type==2, uuid)
- category_id (required, uuid)
- payment_method_id (required, uuid)
- date (required, date, format:YYYY-mm-dd)
- debit (optional, float)
- credit (optional, float)
- image (optional, base64 encoded image)
- note (optional, string)

Http request example:

```
{
	"type":1,
    "category_id":"9669a4f5-e422-4d95-a54c-2af6e7518f6c",
    "payment_method_id": "966a0a47-260a-43b8-98b5-a9de46681d3d",
    "date":"2022-06-05",
    "wallet_id":"96687141-c27e-43ce-812e-2a4300858ac0",
    "credit":79000,
}
```

Server response:

```
{
    "data": {
        "id": "967745f5-9118-4aa2-be89-a456e804048e",
        "date": "2022-06-05",
        "debit": null,
        "credit": 79000,
        "image": "http://URL/storage/hWXPpkoBALvIObRz.png",
        "note": null,
        "wallet": {
            "id": "96687141-c27e-43ce-812e-2a4300858ac0",
            "name": "Wallet 527",
            "project_api_url": "<project_api_url>"
        },
        "category": {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        "payment_method": {
            "id": "966a0a47-260a-43b8-98b5-a9de46681d3d",
            "name": "Cash"
        },
        "created_at": "2022-06-05 05:49:49",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-06-05 05:49:49",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/transactions/{id}`

No params

Server response:

```
{
    "data": {
        "id": "967745f5-9118-4aa2-be89-a456e804048e",
        "date": "2022-06-05",
        "debit": null,
        "credit": "79000",
        "image": "http://<URL>/storage/hWXPpkoBALvIObRz.png",
        "note": null,
        "wallet": {
            "id": "96687141-c27e-43ce-812e-2a4300858ac0",
            "name": "Wallet 527",
            "project_api_url": "<project_api_url>"
        },
        "category": {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        "payment_method": {
            "id": "966a0a47-260a-43b8-98b5-a9de46681d3d",
            "name": "Cash"
        },
        "created_at": "2022-06-05 05:49:49",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-06-05 05:49:49",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### PUT `/transactions/{id}`

Parameters:

- wallet_id (optional, uuid)
- category_id (optional, uuid)
- payment_method_id (optional, uuid)
- date (optional, date, format:YYYY-mm-dd)
- debit (optional, float)
- credit (optional, float)
- image (optional, base64 encoded image)
- note (optional, string)

Http request example:

```
{
	"type":1,
    "category_id":"9669a4f5-e422-4d95-a54c-2af6e7518f6c",
    "payment_method_id": "966a0a47-260a-43b8-98b5-a9de46681d3d",
    "date":"2022-06-05",
    "wallet_id":"96687141-c27e-43ce-812e-2a4300858ac0",
    "credit":79000,
}
```

Server response:

```
{
    "data": {
        "id": "967745f5-9118-4aa2-be89-a456e804048e",
        "date": "2022-06-05",
        "debit": null,
        "credit": 98500,
        "image": "http://<URL>/storage/2J1efxm775G128vy.png",
        "note": null,
        "wallet": {
            "id": "96687141-c27e-43ce-812e-2a4300858ac0",
            "name": "Wallet 527",
            "project_api_url": "<project_api_url>"
        },
        "category": {
            "id": "9669a4f5-e422-4d95-a54c-2af6e7518f6c",
            "name": "Category 1",
            "icon": "Some icon",
            "color": "#000000",
            "bgcolor": "#FFFFFF",
            "type": 1
        },
        "payment_method": {
            "id": "966a0a47-260a-43b8-98b5-a9de46681d3d",
            "name": "Cash"
        },
        "created_at": "2022-06-05 05:49:49",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-06-05 06:02:01",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### DELETE `/transactions/{id}`

No params

Server response:

```

```

## Administration of exchange rate

### GET `/exchange_rates`

Parameters:

- currency_id (optional, uuid)
- date (optional, date, format: YYYY-mm-dd)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"currency_id": "96687141-c27e-43ce-812e-2a4300858ac0",
    "date": "2022-06-08",
    "column": "created_at",
    "order": "desc
}
```

Server response:

```
{
    "data": [
        {
            "id": "967dc7a2-9314-4fbf-ba96-4f8d9de9eb2c",
            "date": "2022-06-08",
            "rate": "10950.05",
            "currency": {
                "id": "96685e54-09a7-4807-9826-25dd4b08c463",
                "code": "860",
                "ccy": "UZS",
                "ccynm_uz": "O`zbek so`mi",
                "ccynm_uzc": "Ўзбек сўми",
                "ccynm_ru": "Узбекский сум",
                "ccynm_en": "Uzbek Sum"
            }
        },
        {
            "id": "967dc8d3-e2de-4daa-8f72-4452f0b1f9d1",
            "date": "2022-06-09",
            "rate": "10950.05",
            "currency": {
                "id": "96685e54-09a7-4807-9826-25dd4b08c463",
                "code": "860",
                "ccy": "UZS",
                "ccynm_uz": "O`zbek so`mi",
                "ccynm_uzc": "Ўзбек сўми",
                "ccynm_ru": "Узбекский сум",
                "ccynm_en": "Uzbek Sum"
            }
        },
        ...
    ],
    "links": {
        "first": "<API_URL>/exchange_rates?page=1",
        "last": "<API_URL>/exchange_rates?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "<API_URL>/exchange_rates?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "<API_URL>/exchange_rates",
        "per_page": "25",
        "to": 3,
        "total": 3
    }
}
```

### POST `/exchange_rates`

Parameters:

- currency_id (required, uuid)
- date (optional, date, format: YYYY-mm-dd)
- rate (required, float)

Http request example:

```
{
    "currency_id": "96685e54-0bd5-4f78-914e-4bd61c16b4ac",
    "date": "2022-06-09",
    "rate": 10950.05
}
```

Server response:

```
{
    "data": {
        "id": "967dfe7b-7190-4908-a65c-205ca9198455",
        "date": "2022-06-09",
        "rate": 10950.05,
        "currency": {
            "id": "96685e54-0bd5-4f78-914e-4bd61c16b4ac",
            "code": "840",
            "ccy": "USD",
            "ccynm_uz": "AQSH Dollari",
            "ccynm_uzc": "АҚШ доллари",
            "ccynm_ru": "Доллар США",
            "ccynm_en": "US Dollar"
        },
        "created_at": "2022-06-08 14:00:45",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-06-08 14:00:45",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/exchange_rates/{id}`

No params

Server response:

```
{
    "data": {
        "id": "967dfe7b-7190-4908-a65c-205ca9198455",
        "date": "2022-06-09",
        "rate": "10950.05",
        "currency": {
            "id": "96685e54-0bd5-4f78-914e-4bd61c16b4ac",
            "code": "840",
            "ccy": "USD",
            "ccynm_uz": "AQSH Dollari",
            "ccynm_uzc": "АҚШ доллари",
            "ccynm_ru": "Доллар США",
            "ccynm_en": "US Dollar"
        },
        "created_at": "2022-06-08 14:00:45",
        "created_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "updated_at": "2022-06-08 14:00:45",
        "updated_by": {
            "id": "96685e53-475c-4d0f-8aaf-bd0d3e75c2e9",
            "name": "Owner",
            "phone": "901234567"
        },
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

### GET `/exchange_rates/latest/{currency}`

No params

Server response:

```
{
    "data": {
        "id": "967ddf26-6a17-4961-afeb-1ef1e343228a",
        "date": "2022-06-08",
        "rate": "11046.94",
        "currency": {
            "id": "96685e54-0bd5-4f78-914e-4bd61c16b4ac",
            "code": "840",
            "ccy": "USD",
            "ccynm_uz": "AQSH Dollari",
            "ccynm_uzc": "АҚШ доллари",
            "ccynm_ru": "Доллар США",
            "ccynm_en": "US Dollar"
        },
        "created_at": "2022-06-08 12:33:09",
        "created_by": null,
        "updated_at": "2022-06-08 12:33:09",
        "updated_by": null,
        "deleted_at": "1970-01-01 06:00:00",
        "deleted_by": null
    }
}
```

## History

### GET `/history`

Parameters:

- by (optional, boolean, if true operations done by user will be returned, otherwise all operations except done by user will be returned)
- type (optional, string, value should be one of these: "User", "Role", "Permission", "Currency", "Firm", "Wallet", "Category", "PaymentMethod", "Transaction","ExchangeRate")
- type_id (optional, uuid, historiable_id)
- status (optional, integer, value should be one of these: 1 (Model created), 2 (Model updated), 3 (Model deleted), 4 (Role attached), 5 (Role detached), 6 (Created by user), 7 (Updated by user), 8 (Deleted by user), 9 (Role attached by), 10 (Role detached by), 11 (Permission attached), 12 (Permission detached), 13 (Permission attached by) 14 (Permission detached by), 15 (Permission synced), 16 (Permission synced by), 17 (User attached to wallet), 18 (User detached from wallet), 19 (User attached to wallet by), 20 (User detached from wallet by), 21 (Wallet attached to user), 22 (Wallet detached from user), 23 (Wallet attached to user by), 24 (Wallet detached from user by))
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Http request example:

```
{
	"by": true,
    "status": 7,
    "column": "created_at",
    "order": "desc
}
```
