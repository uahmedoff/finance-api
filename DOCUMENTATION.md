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

## CRUD for users

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

## CRUD for currencies

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

## CRUD for firms

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
            "parent": null
        },
        {
            "id": "9668607f-55ed-4b23-836f-789888f8686b",
            "name": "Wallet 526",
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
            "parent": null
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
